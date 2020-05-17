<?php include("db_connect.php");
session_start();
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");

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
?>



<!DOCTYPE html>
<html lang="ru">

<head>

    <title> Корзина </title>

    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


    <link href="../style/cart/cart.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="../../javascript/jquery-3.4.1.js"></script>

</head>

<body id="particles-js">

    <?php include("header_footer/header.php");

    $action = clear_string($_GET["action"]); //подключаем функцию очистки строк
    $action = mb_strtolower($action, 'UTF-8'); //Приведение строки к нижнему регистру
    $action = mysqli_real_escape_string($link, $action); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    switch ($action) {
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case 'oneclick':

            echo '
            <div id="block-step">
                <div id="name-step">
                    <ul>
                        <li> <a class="active"> Корзина товаров</a></li>
                        <li><span>&rarr;</span></li>
                        <li> <a> Оформление заказа</a></li>
                        <li><span>&rarr;</span></li>
                        <li> <a> Завершение</a></li>
                    </ul>
                </div>
                <a href="cart.php?action=clear">Очистить корзину</a>
            </div>
            ';

            $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_cart");

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                echo '

            <div id="list-card">
                <div id="name-card"> Товар</div>
                <div id="name-qty">Кол-во</div>
                <div id="name-prise">Цена</div>
                <p>Шаг 1 из 3</p>
            </div>
            ';

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

                        <div class="card">
                            <img src="' . $img_path . '"/>
                            <div> <a>' . $row["title"] . '</a> </div>
                        </div>
                        

                        <div class="count">
                            <ul class="input-count">
                        
                                <li>
                                <p class="count-minus">-</p>
                                </li>
                        
                                <li>
                                <p><input value="'  . $row["count_cart"] . '"/></p>
                                </li>
                        
                                <li>
                                <p class="count-plus">+</p>
                                </li>
                    
                            </ul>
                        </div>

                        <div id="tovar" class="price-product">
                            <h5>
                                <span class="span-count" >1</span> 
                                x 
                                <span> ' . $row["price"] . '₽ </span>

                            </h5><p>' . $int . '₽</p>

                        </div>

                        <div class="delete-cart"><a  href="cart.php?id=' . $row["id_cart"] . '&action=delete" >X</a></div>

                    </div>
                    ';
                } while ($row = mysqli_fetch_array($result));

                echo '
                <h2 class="itog-price">Итого: <strong>' . $all_price . '</strong> ₽</h2>
                <p  class="button-next" ><a href="cart.php?action=confirm" >Далее</a></p> 
                ';
            } else {
                echo '<h3 id="clear-cart">Корзина пуста</h3>';
            }
            break;





            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case 'confirm':
            echo '
            <div id="block-step">
            <div id="name-step">
    
                <ul>
                    <li> <a> Корзина товаров</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a class="active"> Оформление заказа</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a> Завершение</a></li>
                </ul>
            </div>
            <p>Шаг 2 из 3</p>
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








            if ($_SESSION['auth'] != 'yes_auth') {
                echo '
            <li><label for="order_fio"><span>*</span>���</label><input type="text" name="order_fio" id="order_fio" value="' . $_SESSION["order_fio"] . '" /><span class="order_span_style" >������: ������ ���� ��������</span></li>
            <li><label for="order_email"><span>*</span>E-mail</label><input type="text" name="order_email" id="order_email" value="' . $_SESSION["order_email"] . '" /><span class="order_span_style" >������: ivanov@mail.ru</span></li>
            <li><label for="order_phone"><span>*</span>�������</label><input type="text" name="order_phone" id="order_phone" value="' . $_SESSION["order_phone"] . '" /><span class="order_span_style" >������: 8 950 100 12 34</span></li>
            <li><label class="order_label_style" for="order_address"><span>*</span>�����<br /> ��������</label><input type="text" name="order_address" id="order_address" value="' . $_SESSION["order_address"] . '" /><span>������: �. ������,<br /> �� ����������� � 18, �� 58</span></li>
            ';
            }
            echo '
            <li><label class="order_label_style" for="order_note">����������</label><textarea name="order_note"  >' . $_SESSION["order_note"] . '</textarea><span>�������� ���������� � ������.<br />  ��������, ������� ����� ��� ������<br />  ������ ���������</span></li>
            </ul>
            <p align="right" ><input type="submit" name="submitdata" id="confirm-button-next" value="�����" /></p>
            </form>
            
            
             ';

            break;







            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case 'completion':
            echo '
            <div id="block-step">
            <div id="name-step">
    
                <ul>
                    <li> <a> Корзина товаров</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a> Оформление заказа</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a class="active"> Завершение</a></li>
                </ul>
    
            </div>
            <p>Шаг 3 из 3</p>
            <a href="cart.php?action=clear">Очистить корзину</a>
            </div>
            ';
            break;
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        default:
            echo '
        <div id="block-step">
            <div id="name-step">
                <ul>
                    <li> <a class="active"> Корзина товаров</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a> Оформление заказа</a></li>
                    <li><span>&rarr;</span></li>
                    <li> <a> Завершение</a></li>
                </ul>
            </div>
            <p>Шаг 1 из 3</p>
            <a href="cart.php?action=clear">Очистить корзину</a>
        </div>
        ';

            $result = mysqli_query($link, "SELECT * FROM cart,products WHERE cart.ip_users = '{$_SERVER['REMOTE_ADDR']}' AND products.id = cart.id_cart");

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                echo '

        <div id="list-card">
            <div id="name-card"> Товар</div>
            <div id="name-qty">Кол-во</div>
            <div id="name-prise">Цена</div>
        </div>
        ';

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

                    <div class="card">
                        <img src="' . $img_path . '"/>
                        <div> <a>' . $row["title"] . '</a> </div>
                    </div>
                    

                    <div class="count">
                        <ul class="input-count">
                    
                            <li>
                            <p class="count-minus">-</p>
                            </li>
                    
                            <li>
                            <p><input value="'  . $row["count_cart"] . '"/></p>
                            </li>
                    
                            <li>
                            <p class="count-plus">+</p>
                            </li>
                
                        </ul>
                    </div>

                    <div id="tovar" class="price-product">
                        <h5>
                            <span class="span-count" >1</span> 
                            x 
                            <span> ' . $row["price"] . '₽ </span>

                        </h5><p>' . $int . '₽</p>

                    </div>

                    <div class="delete-cart"><a  href="cart.php?id=' . $row["id_cart"] . '&action=delete" >X</a></div>

                </div>
                ';
                } while ($row = mysqli_fetch_array($result));

                echo '
            <h2 class="itog-price">Итого: <strong>' . $all_price . '</strong> ₽</h2>
            <p  class="button-next" ><a href="cart.php?action=confirm" >Далее</a></p> 
            ';
            } else {
                echo '<h3 id="clear-cart">Корзина пуста</h3>';
            }
            break;
    }

    ?>





    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>