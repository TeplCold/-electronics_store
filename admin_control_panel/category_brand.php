<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");


    if ($_POST["submit_cat_category"]) {

        $error = array();

        if (!$_POST["cat_brand"])  $error[] = "Укажите название брэнда!";
        if (!$_POST["cat_category"])  $error[] = "Укажите название категории!";
        if (!$_POST["cat_subcategory"]) $error[] = "Укажите название подкатегории!";

        if (count($error)) {
            $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            $cat_category = clear_string($_POST["cat_category"]);
            $cat_subcategory = clear_string($_POST["cat_subcategory"]);

            // mysqli_query($link, "INSERT INTO category(categorya,subcategory)
            //                 VALUES(						
            //                     '" . $cat_category . "',
            //                     '" . $cat_subcategory . "'                              
            //                 )");
            // $_SESSION['message'] = "<p id='form-success'>Категория успешно добавлена!</p>";
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
            $_SESSION['message'] = "<p id='form-success'>Брэнд успешно добавлен!</p>";
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

        <link rel="stylesheet" href="style/category_brand/category_brand.css">

    </head>

    <body>

        <?php include("header.php"); ?>

        <div class="container block_cuntent">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Категории/брэнды</li>
                </ol>
            </nav>

            <?php include("panelyprav.php"); ?>




            <form method="post" class="from">

                <ul id="cat_products">

                    <?php
                    if (isset($msgerror)) echo '<p id="form-error">' . $msgerror . '</p>';
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    } ?>



                    <label>Брэнды</label>
                    <li class="margindelete"><select name="cat_brand" id="cat_brand" size="1">
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
                        </select> </li>
                    <a class="delete-cat_brand">Удалить</a>
                    <li>
                        <input class="cat_buttom" type="text" name="cat_brand" />
                    </li>
                    <p><input type="submit" name="submit_cat_brand" id="submit_form" value="Добавить" /></p>
                </ul>




                <ul id="cat_products">
                    <li class="margindelete">
                        <label>Категории</label>
                    <li>
                        <select name="cat_category" id="cat_category" size="1">
                            <?php
                            $result = mysqli_query($link, "SELECT * FROM category ORDER BY category DESC");
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                do {
                                    echo ' <option value="' . $row["category_id"] . '" >' . $row["category"]  . '</option>';
                                } while ($row = mysqli_fetch_array($result));
                            }
                            ?>
                        </select>
                    </li>
                    <a class="delete-cat_category">Удалить</a>
                    </li>
                    <li>
                        <input class="cat_buttom" type="text" name="cat_category" />
                    </li>
                    <p><input type="submit" name="submit_cat_category" id="submit_form" value="Добавить" /></p>


                    <li>
                        <label>Подкатегория</label>
                    <li> <select name="subcategory" id="subcategory" size="1"></select>
                            <?php
                            $result = mysqli_query($link, "SELECT * FROM subcategory ORDER BY subcategory DESC");
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                do {
                                    echo ' <option value="' . $row["subcategory_id"] . '" >' . $row["subcategory"] . '</option>';
                                } while ($row = mysqli_fetch_array($result));
                            }
                            ?>
                        </select> </li>
                    <a class="delete-subcategory">Удалить</a>
                    </li>
                    <li>
                        <input class="cat_buttom" type="text" name="cat_subcategory" />
                    </li>
                    <p><input type="submit" name="submit_cat_category" id="submit_form" value="Добавить" /></p>
                </ul>

            </form>

            <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
            <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

            <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
            <script defer type="text/javascript" src="../javascript/cart.js"></script>
            <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
            <script defer type="text/javascript" src="js/script.js"></script>
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