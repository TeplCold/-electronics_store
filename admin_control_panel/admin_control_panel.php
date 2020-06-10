<?php
session_start();
if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");
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
        <link rel="stylesheet" href="style/style.css">

    </head>

    <body>
        <?php include("header.php");

        // Общее кол-во заказов
        $query1 = mysqli_query($link, "SELECT * FROM orders");
        $result1 = mysqli_num_rows($query1);
        // Общее кол-во товаров
        $query2 = mysqli_query($link, "SELECT * FROM products");
        $result2 = mysqli_num_rows($query2);
        // Общее кол-во отзывов
        $query3 = mysqli_query($link, "SELECT * FROM reviews_products");
        $result3 = mysqli_num_rows($query3);
        // Общее кол-во клиентов
        $query4 = mysqli_query($link, "SELECT * FROM users");
        $result4 = mysqli_num_rows($query4);
        ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Главная</li>
            </ol>
        </nav>

        <?php include("panelyprav.php"); ?>

        <p id="title-page">Общая статистика</p>
        <ul id="general-statistics">
            <li>
                <p>Всего заказов - <span><?php echo $result1; ?></span></p>
            </li>
            <li>
                <p>Товаров - <span><?php echo $result2; ?></span></p>
            </li>
            <li>
                <p>Отзывы - <span><?php echo $result3; ?></span></p>
            </li>
            <li>
                <p>Клиенты - <span><?php echo $result4; ?></span></p>
            </li>
        </ul>

        <h3 id="title-statistics">Статистика продаж</h3>

        <TABLE>
            <TR>
                <TH>Дата</TH>
                <TH>Товар</TH>
                <TH>Цена</TH>
                <TH>Статус</TH>
            </TR>
            <?php

            $result = mysqli_query($link, "SELECT * FROM orders,buy_products WHERE orders.order_pay='accepted' AND orders.order_id=buy_products.buy_id_order");

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {

                    $result2 = mysqli_query($link, "SELECT * FROM products WHERE id='{$row["buy_id_product"]}'");
                    if (mysqli_num_rows($result2) > 0) {
                        $row2 = mysqli_fetch_array($result2);
                    }

                    $statuspay = "";
                    if ($row["order_pay"] == "accepted") $statuspay = "Оплачено";

                    echo '
                    <TR>
                    <TD  align="CENTER" >' . $row["order_datetime"] . '</TD>
                    <TD  align="CENTER" >' . $row2["title"] . '</TD>
                    <TD  align="CENTER" >' . $row2["price"] . ' ₽</TD>
                    <TD  align="CENTER" >' . $statuspay . '</TD>
                    </TR>
                    ';
                } while ($row = mysqli_fetch_array($result));
            }
            ?>

            <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
            <script defer type="text/javascript" src="../javascript/cart.js"></script>
            <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
            <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
            <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>