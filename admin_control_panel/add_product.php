<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");

    if ($_POST["submit_add"]) { //определяем нажатие кнопки добавить

        $error = array();
        // проверка полей
        if (!$_POST["form_title"]) {
            $error[] = "Укажите название товара";
        }

        if (!$_POST["form_price"]) {
            $error[] = "Укажите цену";
        }

        if (!$_POST["form_category"]) {
            $error[] = "Укажите категорию";
        } else {
            $result = mysqli_query($link, "SELECT * FROM category WHERE category_id='{$_POST["form_category"]}'");
            $row = mysqli_fetch_array($result);
            $selectbrand = $row["brand"];
        }

        // Проверка чекбоксов
        if ($_POST["chk_visible"]) {
            $chk_visible = "1";
        } else {
            $chk_visible = "0";
        }

        if (count($error)) {
            $_SESSION['message'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {

            mysqli_query($link, "INSERT INTO products (title, price, min_description, description, features, visible) VALUES(	
              
                '" . $_POST["form_title"] . "',	
                '" . $_POST["form_price"] . "',
               
                '" . $_POST["txt1"] . "',
                '" . $_POST["txt2"] . "',
                '" . $_POST["txt4"] . "',
       
                '" . $chk_visible . "'                  
            )");

            $_SESSION['message'] = "<p id='form-success'>Товар успешно добавлен!</p>";
            $id = mysqli_insert_id($link);

            if (empty($_POST["upload_image"])) {
                include("actions/upload-image.php");
                unset($_POST["upload_image"]);
            }

            if (empty($_POST["galleryimg"])) {
                include("actions/upload-gallery.php");
                unset($_POST["galleryimg"]);
            }
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
        <link rel="stylesheet" href="style/add_product/add_product.css">

    </head>

    <body>

        <?php include("header.php"); ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                <li class="breadcrumb-item"><a href="tovar.php">Товары</a></li>
                <li class="breadcrumb-item active" aria-current="page">Добавление товара</li>
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

        <p id="title-page">Добавление товара</p>

        <?php
        if (isset($msgerror)) echo '<p id="form-error">' . $msgerror . '</p>';

        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }

        if (isset($_SESSION['answer'])) {
            echo $_SESSION['answer'];
            unset($_SESSION['answer']);
        }
        ?>

        <form enctype="multipart/form-data" method="post">
            <ul id="edit-tovar">

                <li>
                    <label>Название товара</label>
                    <input type="text" name="form_title" />
                </li>

                <li>
                    <label>Цена</label>
                    <input type="text" name="form_price" />
                </li>

                <li>
                    <label>Тип товара</label>
                    <select name="form_type" id="type" size="6">
                        <option value="smartfony"> Смартфоны</option>
                        <option value="tablet_pc"> Планшеты</option>
                        <option value="cell_phones"> Мобильные телефоны</option>
                        <option value="handsfree"> Наушники </option>
                        <option value="backup_battery">Power bank</option>
                        <option value="cellphones_chargers">Зарядные устройства</option>
                    </select>
                </li>

                <li>
                    <label>Брэнд</label>
                    <select name="form_category" size="10">

                        <?php
                        $category = mysqli_query($link, "SELECT * FROM brand");

                        if (mysqli_num_rows($category) > 0) {
                            $result_category = mysqli_fetch_array($category);
                            do {
                                echo '  <option value="' . $result_category["brand_id"] . '" >' . $result_category["brand"] . '</option>';
                            } while ($result_category = mysqli_fetch_array($category));
                        }
                        ?>

                    </select>
            </ul>

            <label class="stylelabel">Основная картинка</label>

            <div id="baseimg-upload">
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                <input type="file" name="upload_image" />
            </div>

            <h3 class="h3click">Краткое описание товара</h3>
            <div class="div-editor1">
                <textarea id="editor1" name="txt1" cols="100" rows="10"></textarea>


            </div>

            <h3 class="h3click">Описание товара</h3>
            <div class="div-editor2">
                <textarea defer id="editor2" name="txt2" cols="100" rows="10"></textarea>

            </div>

            <h3 class="h3click">Характеристики</h3>
            <div class="div-editor4">
                <textarea id="editor4" name="txt4" cols="100" rows="10"></textarea>

            </div>

            <label class="stylelabel">Галерея картинок</label>

            <div id="objects">

                <div id="addimage1" class="addimage">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <input type="file" name="galleryimg[]" />
                </div>

            </div>

            <p id="add-input">Добавить</p>

            <h3 class="h3title">Настройки товара</h3>
            <ul id="chkbox">
                <li><input type="checkbox" name="chk_visible" id="chk_visible" /><label for="chk_visible">Показать товар</label></li>
            </ul>


            <p><input type="submit" id="submit_form" name="submit_add" value="Добавить товар" /></p>
        </form>
        <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
        <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>


        <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
        <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
        <script defer type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script defer type="text/javascript">
            var ckeditor1 = CKEDITOR.replace("editor1");
        </script>
        <script defer type="text/javascript">
            var ckeditor1 = CKEDITOR.replace("editor2");
        </script>
        <script defer type="text/javascript">
            var ckeditor1 = CKEDITOR.replace("editor4");
        </script>
    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>