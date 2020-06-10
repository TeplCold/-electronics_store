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

        <?php include("header.php"); ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
            </ol>
        </nav>

        Панель управления

        <div id="left-nav">
            <ul>
                <li><a href="orders.php">Заказы</a><?php echo $count_str1; ?></li>
                <li><a href="tovar.php">Товары</a></li>
                <li><a href="clients.php">Клиенты/администраторы</a></li>
                <li><a href="reviews.php">Отзывы</a><?php echo $count_str2; ?></li>
                <li><a href="category_brand.php">Категории/брэнды</a></li>
                <li><a href="news.php">Новости</a></li>
            </ul>
        </div>


        <p id="title-page">Общая статистика</p>









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