<?php
include("db_connect.php");
session_start();
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
include("group_numerals.php");

$id  = clear_string($_GET["id"]); //подключаем функцию очистки строк
$id  = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
$id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

$action  = clear_string($_GET["action"]); //подключаем функцию очистки строк
$action = mb_strtolower($action, 'UTF-8'); //Приведение строки к нижнему регистру
$action = mysqli_real_escape_string($link, $action); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

switch ($action) {
    case 'clear':
        $clear = mysqli_query($link, "DELETE FROM cart WHERE ip_users = '{$_SERVER['REMOTE_ADDR']}'");
        break;

    case 'delete':
        $delete = mysqli_query($link, "DELETE FROM cart WHERE id_cart = '$id' AND ip_users = '{$_SERVER['REMOTE_ADDR']}'");
        break;
}

if (isset($_POST["submitdata2"])) {
    $_SESSION["order_delivery"] = $_POST["order_delivery"];
    $_SESSION["order_fio"] = $_POST["order_fio"];
    $_SESSION["order_name"] = $_POST["order_name"];
    $_SESSION["order_patronymic"] = $_POST["order_patronymic"];
    $_SESSION["order_email"] = $_POST["order_email"];
    $_SESSION["order_phone"] = $_POST["order_phone"];
    $_SESSION["order_address"] = $_POST["order_address"];
    $_SESSION["order_note"] = $_POST["order_note"];
    header("Location: cart.php?action=oneclick");
}

if (isset($_POST["submitdata"])) {

    $_SESSION["order_delivery"] = $_POST["order_delivery"];
    $_SESSION["order_fio"] = $_POST["order_fio"];
    $_SESSION["order_name"] = $_POST["order_name"];
    $_SESSION["order_patronymic"] = $_POST["order_patronymic"];
    $_SESSION["order_email"] = $_POST["order_email"];
    $_SESSION["order_phone"] = $_POST["order_phone"];
    $_SESSION["order_address"] = $_POST["order_address"];
    $_SESSION["order_note"] = $_POST["order_note"];

    if ($_SESSION['auth'] == 'yes_auth') {
        mysqli_query($link, "INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_name,order_patronymic,order_address,order_phone,order_note,order_email)
        VALUES(	
            NOW(),
            '" . $_POST["order_delivery"] . "',					
			'" . $_SESSION['auth_surname'] . "',	
            '" . $_SESSION['auth_name'] . "', 
            '" . $_SESSION['auth_patronymic'] . "',
            '" . $_SESSION['order_address'] . "',
            '" . $_SESSION['order_phone'] . "',
            '" . $_SESSION["order_note"] . "',
            '" . $_SESSION['auth_email'] . "'                  
            )");
    } else {

        mysqli_query($link, "INSERT INTO orders(order_datetime,order_dostavka,order_fio,order_name,order_patronymic,order_address,order_phone,order_note,order_email)
        VALUES(	
        NOW(),
        '" . clear_string($_POST["order_delivery"]) . "',					
        '" . clear_string($_POST["order_fio"]) . "',
        '" . clear_string($_POST["order_name"]) . "',
        '" . clear_string($_POST["order_patronymic"]) . "',
        '" . clear_string($_POST["order_address"]) . "',
        '" . clear_string($_POST["order_phone"]) . "',
        '" . clear_string($_POST["order_note"]) . "',
        '" . clear_string($_POST["order_email"]) . "'                   
        )");
    }

    $_SESSION["order_id"] = mysqli_insert_id($link);

    $result = mysqli_query($link, "SELECT * FROM cart WHERE ip_users = '{$_SERVER['REMOTE_ADDR']}'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        do {
            mysqli_query($link, "INSERT INTO buy_products(buy_id_order,buy_id_product,buy_count_product)
                    VALUES(	
                        '" . $_SESSION["order_id"] . "',					
                        '" . $row["id_products_cart"] . "',
                        '" . $row["count_cart"] . "'                   
                        )");
        } while ($row = mysqli_fetch_array($result));
    }
    header("Location: cart.php?action=completion");
}

$result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_products_cart");

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
    do {
        $int =  $int + ($row["price"] * $row["count_cart"]);
    } while ($row = mysqli_fetch_array($result));
    $itogpricecart = $int;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <title> Корзина </title>
    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <link href="../style/cart/cart.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="fon">

        <?php include("header_footer/header.php"); ?>

        <div class="containerglavn">
            <div class="blockglavn">
                <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
                <div class="inetshop">Корзина товаров</div>
                <div class="glavnplus"> Здесь Вы можете увидеть полный список выбранных Вами продуктов и окончательно его отредактировать после Вы можете оформить заказ</div>
                <div class="join"> Приятных покупок!</div>
            </div>
        </div>
        <div class="block-basket">
            <p id="block-basket"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
        </div>

        <?php

        $action = clear_string($_GET["action"]); //подключаем функцию очистки строк
        $action = mb_strtolower($action, 'UTF-8'); //Приведение строки к нижнему регистру
        $action = mysqli_real_escape_string($link, $action); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

        switch ($action) {
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'oneclick':
                echo '

            <div class="container container_card">
                <div id="block-step">
                   <div class="progress">
                        <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 1 из 3</p></div>
                        <div class="noactiv progress-bar " role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width: 33.33333333333333%">   <p>Шаг 2 из 3</p></div>
                        <div class="noactiv progress-bar " role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width: 33.33333333333333%">   <p>Шаг 3 из 3</p></div>
                    </div>
                    <div id="name-step">
                        <div  class="width_name1 "> <a class="active"> Корзина товаров</a></div>
                        <div class="width_name4" ><span>&rarr;</span></div>
                        <div  class="width_name2"> <a> Оформление заказа</a></div>
                        <div class="width_name5" ><span>&rarr;</span></div>
                        <div  class="width_name3"> <a> Завершение</a></div>
                    </div>
                </div>
                ';

                $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_products_cart");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    echo '
               <div class="clear"><a  href="cart.php?action=clear">Очистить корзину</a></div>
                ';
                }

                $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_products_cart");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        $int = $row["price"] * $row["count_cart"];
                        $all_price = $all_price + $int; // подсчитываем итоговую цену

                        if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                            $img_path = '../assets/products/' . $row["image"]; //фото есть 
                        } else {
                            $img_path = "../assets/products/no_photo.jpg"; //фото нету
                        }

                        echo '
                        <div id="block-list-card">
                            <div id="cintainer-list-card">

                                <div class="block_cardss">
                                    <div class="container_cardss">
                                        <div class = "blockimage">
                                            <div class = "card_image"> <img src="' . $img_path . '" /> </div>   
                                        </div>
                                    </div>
                                </div>

                                <div class="card_title"> <a>' . $row["title"] . '</a> </div>

                                <div  id="tovar' . $row["id_cart"] . '" class="price-product">
                                    <span> ' .  group_numerals($row["price"]) . '₽ </span>
                                </div> 

                                <div class="count">
                                    <ul class="input-count">
                                        <li>
                                            <p class="count-minus"  iid="' . $row["id_cart"] . '"> -</p>
                                        </li>
                                        <li>
                                            <p><input id="input-id' . $row["id_cart"] . '" class="count-input" maxlength="3" type="text" value="'  . $row["count_cart"] . '" iid="' . $row["id_cart"] . '"> </p>
                                        </li>
                                        <li>
                                            <p class="count-plus"  iid="' . $row["id_cart"] . '"> + </p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="price" id="tovar' . $row["id_cart"] . '" class="price-product">
                                    <p price="' . $row["cart_price"] . '" >' . group_numerals($int) . '₽</p>
                                </div>

                                <div class="delete-cart"><a  href="cart.php?id=' . $row["id_cart"] . '&action=delete" >×</a></div>
                            </div>
                        </div>
                    ';
                    } while ($row = mysqli_fetch_array($result));

                    echo '
                    <div class="cat_top">
                        <h2 class="itog-price">Итого: <strong>' . group_numerals($all_price) . '</strong>₽</h2>
                        <h2  class="button-next" ><a href="cart.php?action=confirm" >Далее</a></h2
                    </div>
                   
                </div>  
                </div>
            
                ';
                } else {
                    echo '<div class="clear-cart" ><h3 id="clear-cart">Корзина пуста</h3></div> </div>';
                }
                break;

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'confirm':
                echo '

                <div class="container container_card">
                    <div id="block-step">
                       <div class="progress">
                            <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 1 из 3</p></div>

                            <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 2 из 3</p></div>

                            <div class="noactiv progress-bar " role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width: 33.33333333333333%">   <p>Шаг 3 из 3</p></div>
                        </div>
                        <div id="name-step">
                            <div  class="width_name1 "> <a class="active"> Корзина товаров</a></div>
                            <div class="width_name4" ><span>&rarr;</span></div>
                            <div  class="width_name2"> <a class="active"> Оформление заказа</a></div>
                            <div class="width_name5" ><span>&rarr;</span></div>
                            <div  class="width_name3"> <a> Завершение</a></div>
                        </div>
                    </div>
                    ';

                if ($_SESSION['order_delivery'] == "Почтой") $chck1 = "checked";
                if ($_SESSION['order_delivery'] == "Курьером") $chck2 = "checked";
                if ($_SESSION['order_delivery'] == "Самовывоз") $chck3 = "checked";

                echo '
                    <h3 class="title-h3" >Способ доставки:</h3>
                    <form method="post">
                        <ul id="info-radio">
                            <li>
                                <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="Почтой" ' . $chck1 . '  />
                                <label class="label_delivery" for="order_delivery1">Почтой</label>
                            </li>
                            <li>
                                <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером" ' . $chck2 . ' />
                                <label class="label_delivery" for="order_delivery2">Курьером</label>
                            </li>
                            <li>
                                <input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз" ' . $chck3 . ' />
                                <label class="label_delivery" for="order_delivery3">Самовывоз</label>
                            </li>
                        </ul>

                        <h3 class="title-h3" >Информация для доставки:</h3>

                        <ul id="info-order">
                    ';
                if ($_SESSION['auth'] == 'yes_auth') {
                    echo '
                                <li><label for="order_phone"></label><input placeholder="Телефон" type="text" name="order_phone" id="order_phone" value="' . $_SESSION["order_phone"] . '" />
                                <li><label class="order_label_style" for="order_address"></label><input placeholder="Адрес доставки" type="text" name="order_address" id="order_address" value="' . $_SESSION["order_address"] . '" />
                                <li><label class="order_label_style" for="order_note" ></label><textarea  placeholder="Примечания" name="order_note"  >' . $_SESSION["order_note"] . '</textarea></li>
                                ';
                } else {
                    echo '
                                <li><label for="order_fio" ></label><input placeholder="Фамилия" type="text" name="order_fio" id="order_fio" value="' . $_SESSION["order_fio"] . '" />
                                <li><label for="order_name"></label><input placeholder="Имя" type="text" name="order_name" id="order_name" value="' . $_SESSION["order_name"] . '" />
                                <li><label for="order_patronymic"></label><input  placeholder="Отчество" type="text" name="order_patronymic" id="order_patronymic" value="' . $_SESSION["order_patronymic"] . '" />
                                <li><label for="order_email"></label><input  placeholder="E-mail" type="text" name="order_email" id="order_email" value="' . $_SESSION["order_email"] . '" />
                                <li><label for="order_phone"></label><input   placeholder="Телефон" type="text" name="order_phone" id="order_phone" value="' . $_SESSION["order_phone"] . '" />
                                <li><label class="order_label_style" for="order_address" ></label><input placeholder="Адрес доставки" type="text" name="order_address" id="order_address" value="' . $_SESSION["order_address"] . '" />
                                <li><label class="order_label_style" for="order_note" ></label><textarea placeholder="Примечания" name="order_note"  >' . $_SESSION["order_note"] . '</textarea></li>
                                ';
                }
                echo '
                        </ul> 

                            <div class="cat_top">
                                <h2  class="button-back" ><input type="submit" name="submitdata2" value="Назад" /></h2
                                <h2  class="button-next2"><input type="submit" name="submitdata" id="confirm-button-next" value="Далее"/></h2
                            </div>
                        </div>
                        
                    </form>
                </div>
                ';
                break;

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'completion':
                echo '
           
                <div class="container container_card">
                    <div id="block-step">
                       <div class="progress">
                            <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 1 из 3</p></div>

                            <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 2 из 3</p></div>

                            <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 3 из 3</p></div>

                        </div>
                        <div id="name-step">
                            <div  class="width_name1 "> <a class="active"> Корзина товаров</a></div>
                            <div class="width_name4" ><span>&rarr;</span></div>
                            <div  class="width_name2"> <a class="active"> Оформление заказа</a></div>
                            <div class="width_name5" ><span>&rarr;</span></div>
                            <div  class="width_name3"> <a class="active"> Завершение</a></div>
                        </div>
                    </div>
                    ';

                if ($_SESSION['auth'] == 'yes_auth') {
                    echo '
                    <ul id="list-info" >
                        <li><strong>Способ доставки: </strong>' . $_SESSION['order_delivery'] . '</li>
                        <li><strong>Фамилия: </strong>' . $_SESSION['auth_surname'] . '</li>
                        <li><strong>Имя: </strong>' . $_SESSION['auth_name'] .  '</li>
                        <li><strong>Отчество: </strong>' . $_SESSION['auth_patronymic'] . '</li>
                        <li><strong>Email: </strong>' . $_SESSION['auth_email'] . '</li>
                        <li><strong>Телефон: </strong>' . $_SESSION['order_phone'] . '</li>
                        <li><strong>Адрес доставки: </strong>' . $_SESSION['order_address'] . '</li>
                    ';
                    if ($_SESSION['order_note'] != "") {
                        echo '
                        <li><strong>Примечания: </strong>' . $_SESSION['order_note'] . '</li>
                        <h2 class="itog-price2">Итог: <strong>' . group_numerals($itogpricecart) . '</strong>₽</h2>
                    </ul>
                        ';
                    }
                } else {
                    echo '
                    <ul id="list-info" >
                        <li><strong>Способ доставки: </strong>' . $_SESSION['order_delivery'] . '</li>
                        <li><strong>Фамилия: </strong>' . $_SESSION['order_fio'] . '</li>
                        <li><strong>Имя: </strong>' . $_SESSION['order_name'] .  '</li>
                        <li><strong>Отчество: </strong>' . $_SESSION['order_patronymic'] . '</li>
                        <li><strong>Email: </strong>' . $_SESSION['order_email'] . '</li>
                        <li><strong>Телефон: </strong>' . $_SESSION['order_phone'] . '</li>
                        <li><strong>Адрес доставки: </strong>' . $_SESSION['order_address'] . '</li>
                        ';
                    if ($_SESSION['order_note'] != "") {
                        echo '
                        <li><strong>Примечания: </strong>' . $_SESSION['order_note'] . '</li>
                        <h2 class="itog-price2">Итог: <strong>' . group_numerals($itogpricecart) . '</strong>₽</h2>
                    </ul>
                        ';
                    }
                }

                echo '
                    <div class="cat_top2">
                        <p class="button-oplat"><a href="">Оплатить</a></p>   
                        <p class="button-back2"><a href="cart.php?action=confirm">Назад</a></p> 
                    </div>
                
                </div>
                ';
                break;

                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            default:
                echo '
            <div class="container container_card">
                <div id="block-step">
                   <div class="progress">
                        <div class="activ progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width:33.33333333333333%">   <p>Шаг 1 из 3</p></div>
                        <div class="noactiv progress-bar " role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width: 33.33333333333333%">   <p>Шаг 2 из 3</p></div>
                        <div class="noactiv progress-bar " role="progressbar" aria-valuenow="33" aria-valuemin="0"      aria-valuemax="100" style="width: 33.33333333333333%">   <p>Шаг 3 из 3</p></div>
                    </div>
                    <div id="name-step">
                        <div  class="width_name1 "> <a class="active"> Корзина товаров</a></div>
                        <div class="width_name4" ><span>&rarr;</span></div>
                        <div  class="width_name2"> <a> Оформление заказа</a></div>
                        <div class="width_name5" ><span>&rarr;</span></div>
                        <div  class="width_name3"> <a> Завершение</a></div>
                    </div>
                </div>
                ';

                $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_products_cart");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    echo '
               <div class="clear"><a  href="cart.php?action=clear">Очистить корзину</a></div>
                ';
                }

                $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_products_cart");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        $int = $row["price"] * $row["count_cart"];
                        $all_price = $all_price + $int; // подсчитываем итоговую цену

                        if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                            $img_path = '../assets/products/' . $row["image"]; //фото есть 
                        } else {
                            $img_path = "../assets/products/no_photo.jpg"; //фото нету
                        }

                        echo '
                        <div id="block-list-card">
                            <div id="cintainer-list-card">

                                <div class="block_cardss">
                                    <div class="container_cardss">
                                        <div class = "blockimage">
                                            <div class = "card_image"> <img src="' . $img_path . '" /> </div>   
                                        </div>
                                    </div>
                                </div>

                                <div class="card_title"> <a>' . $row["title"] . '</a> </div>

                                <div  id="tovar' . $row["id_cart"] . '" class="price-product">
                                    <span> ' .  group_numerals($row["price"]) . '₽ </span>
                                </div> 

                                <div class="count">
                                    <ul class="input-count">
                                        <li>
                                            <p class="count-minus"  iid="' . $row["id_cart"] . '"> -</p>
                                        </li>
                                        <li>
                                            <p><input id="input-id' . $row["id_cart"] . '" class="count-input" maxlength="3" type="text" value="'  . $row["count_cart"] . '" iid="' . $row["id_cart"] . '"> </p>
                                        </li>
                                        <li>
                                            <p class="count-plus"  iid="' . $row["id_cart"] . '"> + </p>
                                        </li>
                                    </ul>
                                </div>

                                <div class="price" id="tovar' . $row["id_cart"] . '" class="price-product">
                                    <p price="' . $row["cart_price"] . '" >' . group_numerals($int) . '₽</p>
                                </div>

                                <div class="delete-cart"><a  href="cart.php?id=' . $row["id_cart"] . '&action=delete" >×</a></div>
                            </div>
                        </div>
                    ';
                    } while ($row = mysqli_fetch_array($result));

                    echo '
                    <div class="cat_top">
                        <h2 class="itog-price">Итого: <strong>' . group_numerals($all_price) . '</strong>₽</h2>
                        <h2  class="button-next" ><a href="cart.php?action=confirm" >Далее</a></h2
                    </div>
                   
                </div>  
                </div>
            
                ';
                } else {
                    echo '<div class="clear-cart" ><h3 id="clear-cart">Корзина пуста</h3></div> </div>';
                }
                break;
        }
        ?>

        <?php include("header_footer/footer.php") ?>
        <a href="#" class="scrollup">Наверх</a>
    </div>

    <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
    <script defer type="text/javascript" src="../javascript/cart.js"></script>
    <script defer type="text/javascript" src="../javascript/header_footer.js"></script>

    <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
    <script defer src="../bootstrap/js/bootstrap.min.js"></script>
    <script defer type="text/javascript" src="../javascript/scrollup.js"></script>
</body>

</html>