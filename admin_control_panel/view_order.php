<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");
    include("../pages/group_numerals.php");

    $id = clear_string($_GET["id"]);
    $id = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.


    $action = $_GET["action"];
    $action = mb_strtolower($action, 'UTF-8'); //Приведение строки к нижнему регистру
    $action = mysqli_real_escape_string($link, $action); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    if (isset($action)) {
        switch ($action) {
            case 'accept':
                $update = mysqli_query($link, "UPDATE orders SET order_confirmed='yes' WHERE order_id = '$id'");
                break;
            case 'delete':
                $delete = mysqli_query($link, "DELETE FROM orders WHERE order_id = '$id'");
                header("Location: orders.php");
                break;
        }
    }
?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>

        <title>Панель управления</title>
        <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

        <link rel="stylesheet" href="style/view_order/view_order.css">
        <link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">

    </head>

    <body>

        <?php include("header.php"); ?>
        <div class="container block_cuntent">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Заказы</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Просмот заказа</li>
                </ol>
            </nav>

            <?php include("panelyprav.php"); ?>

            <div id="block-parameters">


                <?php
                if (isset($msgerror)) echo '<p id="form-error" align="center">' . $msgerror . '</p>';

                $result = mysqli_query($link, "SELECT * FROM orders WHERE order_id = '$id'");

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $datetime = strtotime($row["order_datetime"]);
                    do {
                        if ($row["order_confirmed"] == 'yes') {
                            $status = '<span>Обработан</span>';
                        } else {
                            $status = '<span>Не обработан</span>';
                        }

                        if ($row["order_pay"] == "accepted") {
                            $statpay = '<span>Оплачено</span>';
                        } else {
                            $statpay = '<span>Не оплачено</span>';
                        }

                        echo '
                        <div class="blockdadanom">
                            <p class="order-number" >Заказ № ' . $row["order_id"] . ' - ' . $status . '</p>
                            <p class="order-datetime" >' .   date("d.m.Y h:i:s", $datetime)   . '</p>
                        </div>
                        ';

               
                        $query_product = mysqli_query($link, "SELECT * FROM buy_products,products WHERE buy_products.buy_id_order = '$id' AND products.id = buy_products.buy_id_product");
                        $result_query = mysqli_fetch_array($query_product);
                        echo '  </TABLE>
                        <ul id="info-order"> ';
                        do {
                            $int = $result_query["price"] * $result_query["buy_count_product"]; //общая цена
                            $all_price = $all_price + $int; // подсчитываем итоговую цену
                            $index_count =  $index_count + 1; //счет товаров

                            echo '
                            ';
                        } while ($result_query = mysqli_fetch_array($query_product));

                        echo '
                        <li>Общая цена - <span>' . group_numerals($all_price) . '</span>  ₽</li>
                        <li>Способ доставки - <span>' . $row["order_dostavka"] . '</span></li>
                        <li>Статус оплаты - ' . $statpay . '</li>
                        <li>Тип оплаты - <span>' . $row["order_type_pay"] . '</span></li>
                        <li>Дата оплаты - <span>' . date("d.m.Y h:i:s", $datetime)  . '</span></li>
                        </ul>

                        <TABLE align="center" WIDTH="100%">
                        <TR>
                        <TH class="index_count">№</TH>
                        <TH>Наименование товара</TH>
                        <TH>Цена</TH>
                        <TH>Количество</TH>
                        </TR>
                        ';
                        $query_product = mysqli_query($link, "SELECT * FROM buy_products,products WHERE buy_products.buy_id_order = '$id' AND products.id = buy_products.buy_id_product");

                        $result_query = mysqli_fetch_array($query_product);
                        do {
                            $price = $price + ($result_query["price"] * $result_query["buy_count_product"]); //общая цена
                            $index_count =  $index_count + 1; //счет товаров
                            echo '
                            <TR>
                            <TD class="index_count">' . $index_count . '</TD>
                            <TD>' . $result_query["title"] . '</TD>
                            <TD>' . $result_query["price"] . ' ₽</TD>
                            <TD>' . $result_query["buy_count_product"] . '</TD>
                            </TR>
                            ';
                        } while ($result_query = mysqli_fetch_array($query_product));




                        echo '
                  
                    
                    <TABLE align="center" WIDTH="100%">
                    <TR>
                    <TH>ФИО</TH>
                    <TH>Адрес</TH>
                    <TH>Контакты</TH>
                    <TH>Примечание</TH>
                    </TR>

                    <TR>
                    <TD  align="CENTER" >' . $row["order_fio"] . ' ' . $row["order_name"] . ' ' . $row["order_patronymic"] . '</TD>
                    <TD  align="CENTER" >' . $row["order_address"] . '</TD>
                    <TD  align="CENTER" >' . $row["order_phone"] . '</br>' . $row["order_email"] . '</TD>
                    <TD  align="CENTER" >' . $row["order_note"] . '</TD>
                    </TR>
                    </TABLE>
                    <p class="view-order-link" ><a class="green" href="view_order.php?id=' . $row["order_id"] . '&action=accept" >Подтвердить заказ</a> | <a class="delete4" rel="view_order.php?id=' . $row["order_id"] . '&action=delete" >Удалить заказ</a></p>
                    ';
                    } while ($row = mysqli_fetch_array($result));
                }
                ?>
            </div>

            <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
            <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
            <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
            <script defer type="text/javascript" src="js/script.js"></script>
            <script defer type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script>
            <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
            <script defer type="text/javascript" src="../javascript/scrollup.js"></script>
        </div>
        <?php include("footer.php") ?>
        <a href="#" class="scrollup">Наверх</a>
    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>