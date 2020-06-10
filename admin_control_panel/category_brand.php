<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");


    if ($_POST["submit_cat_category"]) {

        $error = array();

        if (!$_POST["cat_category"])  $error[] = "Укажите название категории!";
        if (!$_POST["cat_subcategory"]) $error[] = "Укажите название подкатегории!";

        if (count($error)) {
            $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            $cat_category = clear_string($_POST["cat_category"]);
            $cat_subcategory = clear_string($_POST["cat_subcategory"]);

            mysqli_query($link, "INSERT INTO category(categorya,subcategory)
                            VALUES(						
                                '" . $cat_category . "',
                                '" . $cat_subcategory . "'                              
                            )");
            $_SESSION['message'] = "<p id='form-success'>Категория успешно добавлена!</p>";
        }
    }

    if ($_POST["submit_cat_brand"]) {

        $error = array();

        if (!$_POST["cat_brand"])  $error[] = "Укажите название брэнда!";

        if (count($error)) {
            $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            $cat_brand = clear_string($_POST["cat_brand"]);

            mysqli_query($link, "INSERT INTO brand(brand)
                            VALUES(						
                                '" . $cat_brand . "'                       
                            )");
            $_SESSION['message'] = "<p id='form-success'>Брэнда успешно добавлен!</p>";
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

        <link rel="stylesheet" href="style/style.css">

    </head>

    <body>

        <?php include("header.php"); ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Категории/брэнды</li>
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


        <p id="title-page">Категории/брэнды</p>

        <?php
        if (isset($msgerror)) echo '<p id="form-error">' . $msgerror . '</p>';
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        } ?>

        <form method="post">
            <ul id="cat_products">

                <label>Категории</label>
                <select name="cat_category" id="cat_category" size="10">
                    <?php
                    $result = mysqli_query($link, "SELECT * FROM category ORDER BY categorya DESC");

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            echo ' <option value="' . $row["category_id"] . '" >' . $row["categorya"] . ' - ' . $row["subcategory"] . '</option>';
                        } while ($row = mysqli_fetch_array($result));
                    }
                    ?>
                </select>
                <a class="delete-cat_category">Удалить</a>


                <label>Брэнды</label>
                <select name="cat_brand" id="cat_brand" size="10">
                    <?php
                    $result = mysqli_query($link, "SELECT * FROM brand ORDER BY brand DESC");

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            echo '
    
                            <option value="' . $row["brand_id"] . '" >' . $row["brand"] . '</option>
                
                            ';
                        } while ($row = mysqli_fetch_array($result));
                    }
                    ?>
                </select>
                <a class="delete-cat_brand">Удалить</a>

                <li>
                    <label>Категории</label>
                    <input type="text" name="cat_category" />
                </li>
                <li>
                    <label>Подкатегории</label>
                    <input type="text" name="cat_subcategory" />
                </li>
                <p><input type="submit" name="submit_cat_category" id="submit_form" /></p>
            </ul>

            <ul id="cat_products">
                <li>--------------------------------------------------------------</li>
                <li>
                    <label>Брэнды</label>
                    <input type="text" name="cat_brand" />
                </li>
                <p><input type="submit" name="submit_cat_brand" id="submit_form" /></p>
            </ul>

        </form>





        <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
        <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>



        <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
        <script defer type="text/javascript" src="../javascript/cart.js"></script>
        <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
        <script defer type="text/javascript" src="js/script.js"></script>



    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>