<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");

    $id = clear_string($_GET["id"]);
    $id = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    $sort = $_GET["sort"];
    $sort = mb_strtolower($sort, 'UTF-8'); //Приведение строки к нижнему регистру
    $sort = mysqli_real_escape_string($link, $sort); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    switch ($sort) {

        case 'all-orders':
            $sort = "order_id DESC";
            $sort_name = 'От А до Я';
            break;

        case 'confirmed':
            $sort = "order_confirmed = 'yes' DESC";
            $sort_name = 'Обработаные';
            break;

        case 'no-confirmed':
            $sort = "order_confirmed = 'no' DESC";
            $sort_name = 'Не обработаные';
            break;

        default:
            $sort = "order_id DESC";
            $sort_name = 'От А до Я';
            break;
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

        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/reviews/reviews.css">
        <link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">

    </head>

    <body>

        <?php include("header.php");

        $all_count = mysqli_query($link, "SELECT * FROM orders");
        $all_count_result = mysqli_num_rows($all_count);

        $buy_count = mysqli_query($link, "SELECT * FROM orders WHERE order_confirmed = 'yes'");
        $buy_count_result = mysqli_num_rows($buy_count);

        $no_buy_count = mysqli_query($link, "SELECT * FROM orders WHERE order_confirmed = 'no'");
        $no_buy_count_result = mysqli_num_rows($no_buy_count);

        ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Заказы</li>
            </ol>
        </nav>

        <?php include("panelyprav.php"); ?>


        <div id="block-parameters">
            <ul id="options-list">
                <li>Сортировать:</li>
                <li><a id="select-links" href="#">
                        <? echo $sort_name; ?></a>
                    <ul id="list-links-sort">
                        <li><a href="orders.php?sort=all-orders">От А до Я</a></li>
                        <li><a href="orders.php?sort=confirmed">Обработанные</a></li>
                        <li><a href="orders.php?sort=no-confirmed">Не обработанные</a></li>
                    </ul>
                </li>
            </ul>
        </div>


        <div id="block-info">
            <ul id="review-info-count">
                <li>Всего заказов - <strong>
                        <? echo $all_count_result; ?></strong></li>
                <li>Обработаных - <strong>
                        <? echo $buy_count_result; ?></strong></li>
                <li>Не обработаных - <strong>
                        <? echo $no_buy_count_result; ?></strong></li>
            </ul>
        </div>



        <div class="container-fluid">

            <?php
            $result = mysqli_query($link, "SELECT * FROM orders ORDER BY $sort");

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    $datetime = strtotime($row["order_datetime"]);
                    if ($row["order_confirmed"] == 'yes') {
                        $status = '<span class="green">Обработан</span>';
                    } else {
                        $status = '<span class="red">Не обработан</span>';
                    }

                    echo '
                    <div class="block-order">
                    <p class="order-datetime" >' . date("d.m.Y h:i:s", $datetime)  . '</p>
                    <p class="order-number" >Заказ № ' . $row["order_id"] . ' - ' . $status . '</p>
                    <p class="order-link" ><a class="green" href="view_order.php?id=' . $row["order_id"] . '" >Подробней</a></p>
                    </div>
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
    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>