<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");

    $id = clear_string($_GET["id"]); //подключаем функцию очистки строк
    $id = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    $action = clear_string($_GET["action"]);
    $action = mb_strtolower($action, 'UTF-8'); //Приведение строки к нижнему регистру
    $action = mysqli_real_escape_string($link, $action); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    if (isset($action)) {
        switch ($action) {

            case 'delete':

                if (file_exists("../assets/products/" . $_GET["img"])) {
                    unlink("../assets/products/" . $_GET["img"]);
                }
                break;
        }
    }

    if ($_POST["submit_save"]) { //определяем нажатие кнопки добавить

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

        if (empty($_POST["upload_image"])) {
            include("actions/upload-image.php");
            unset($_POST["upload_image"]);
        }

        if (empty($_POST["galleryimg"])) {
            include("actions/upload-gallery.php");
            unset($_POST["galleryimg"]);
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


            $querynew = "title='{$_POST["form_title"]}',price='{$_POST["form_price"]}',min_description='{$_POST["txt1"]}',description='{$_POST["txt2"]}',features='{$_POST["txt4"]}',visible='$chk_visible'";

            mysqli_query($link, "UPDATE products SET $querynew WHERE id = '$id'");

            $_SESSION['message'] = "<p id='form-success'>Товар успешно изменен!</p>";
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
        <link rel="stylesheet" href="style/edit_product/edit_product.css">

    </head>

    <body>

        <?php include("header.php"); ?>

        <div class="container block_cuntent">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                    <li class="breadcrumb-item"><a href="tovar.php">Товары</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Изменение товара</li>
                </ol>
            </nav>

            <?php include("panelyprav.php"); ?>

            <div class="container_cuntent">
                <p id="title-page">Изменение товара</p>

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

                $result = mysqli_query($link, "SELECT * FROM products WHERE id='$id'");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        echo '
                        <form enctype="multipart/form-data" method="post">
                            <ul id="edit-tovar">

                                <li class="nazv">
                                    <label>Название товара</label>
                                </li>
                                <li class="nazv">
                                    <input type="text" name="form_title" value="' . $row["title"] . '" />
                                </li>

                                <li class="nazv">
                                    <label>Цена</label>
                                </li>
                                <li class="nazv">
                                <input type="text" name="form_price"  value="' . $row["price"] . '" />
                                </li>
                                ';
                ?>
                        <li class="nazv">
                            <label>Категория</label>
                        </li>
                        <li class="nazv">
                            <select id="form_category" name="form_category" size="1">
                                <?php
                                $category = mysqli_query($link, "SELECT * FROM category");
                                if (mysqli_num_rows($category) > 0) {
                                    $result_category = mysqli_fetch_array($category);
                                    do {
                                        echo '  <option value="' . $result_category["category_id"] . '" >' . $result_category["category"] . '</option>';
                                    } while ($result_category = mysqli_fetch_array($category));
                                }
                                ?>
                            </select>
                        </li>

                        <li class="nazv">
                            <label>Подкатегория</label>
                        </li>
                        <li class="nazv">
                            <select name="form_subcategory" id="type" size="1">
                                <?php
                                $subcategory = mysqli_query($link, 'SELECT * FROM subcategory');
                                if (mysqli_num_rows($subcategory) > 0) {
                                    $result_subcategory = mysqli_fetch_array($subcategory);
                                    do {
                                        echo '  <option value="' . $result_subcategory["subcategory_id"] . '" >' . $result_subcategory["subcategory"] . '</option>';
                                    } while ($result_subcategory = mysqli_fetch_array($subcategory));
                                }
                                ?>
                            </select>
                        </li>

                        <li class="nazv">
                            <label>Брэнд</label>
                        </li>
                        <li class="nazv">
                            <select name="form_brand" id="type" size="1">
                                <?php
                                $subcategory = mysqli_query($link, 'SELECT * FROM brand');
                                if (mysqli_num_rows($subcategory) > 0) {
                                    $result_subcategory = mysqli_fetch_array($subcategory);
                                    do {
                                        echo '  <option value="' . $result_subcategory["brand_id"] . '" >' . $result_subcategory["brand"] . '</option>';
                                    } while ($result_subcategory = mysqli_fetch_array($subcategory));
                                }
                                ?>
                            </select>
                        </li>
                        </ul>

                        <li class="nazv">
                            <?php
                            if (strlen($row["image"]) > 0 && file_exists("../assets/products/" . $row["image"])) {
                                echo '
                            <label class="stylelabel" >Основная картинка</label>
                            <div id="baseimg">
                                <a href="edit_product.php?id=' . $row["products_id"] . '&img=' . $row["image"] . '&action=delete" ></a>
                                <div class = "card_image"> <img src="../assets/products/' . $row["image"] . '" /> </div>
                            </div>
                            ';
                            } else {
                                echo '  
                            <label class="stylelabel">Основная картинка</label>
                    
                            <div id="baseimg-upload">
                                <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                <input type="file" name="upload_image" />
                            </div>
                            ';
                            }



                            echo '
                        <p class="h3click">Краткое описание товара</p>
                        <div class="div-editor1">
                            <textarea id="editor1" name="txt1" cols="100" rows="10"> ' . $row["min_description"] . ' </textarea>
                        </div>

                        <p class="h3click">Описание товара</p>
                        <div class="div-editor2">
                            <textarea defer id="editor2" name="txt2" cols="100" rows="10">  ' . $row["description"] . ' </textarea>
                        </div>

                        <p class="h3click">Характеристики</p>
                        <div class="div-editor4">
                            <textarea id="editor4" name="txt4" cols="100" rows="10">  ' . $row["features"] . ' </textarea>
                        </div>

                        ';
                            ?>



                        <li class="nazv nazv_top">
                            <label class="stylelabel">Галерея картинок</label>
                        </li>

                        <ul id="gallery-img">
                            <?php
                            $query_img = mysqli_query($link, "SELECT * FROM image_products WHERE products_id='$id'");

                            if (mysqli_num_rows($query_img) > 0) {

                                $result_img = mysqli_fetch_array($query_img);
                                do {
                                    if (strlen($result_img["image"]) > 0 && file_exists("../assets/products/" . $result_img["image"])) {
                                        $img_path = '../assets/products/' . $result_img["image"];
                                    } else {
                                        $img_path = "../assets/products/no_photo.jpg";
                                    }

                                    echo '
                                    <a class="del-img" img_id="' . $result_img["id"] . '" ></a>    
                                <li id="del' . $result_img[" id"] . '" >
                                <div class = "card_images"> <img src="' . $img_path . '" title="' . $result_img["image"] . '" /> </div>

                                   
                        

                                </li> 
                                ';
                                } while ($result_img = mysqli_fetch_array($query_img));
                            }
                            ?>
                        </ul>
                        <div id="objects">
                            <div id="addimage1" class="addimage">
                                <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                <input type="file" name="galleryimg[]" />
                            </div>
                        </div>

                        <p id="add-input">Добавить</p>

                        <li class="nazv">
                            <label>Обзор</label>
                        </li>
                        <li class="nazv">
                            <input type="text" name="form_title" />
                        </li>

                        <li class="nazv">
                            <label>Название обзора</label>
                        </li>
                        <li class="nazv">
                            <input type="text" name="form_title" />
                        </li>
                <?php
                        if ($row["visible"] == '1') $checked1 = "checked";

                        echo '
                        <div>
                            <h3 class="h3title">Настройки товара</h3>
                            <ul id="chkbox">
                                <li><input type="checkbox" name="chk_visible" id="chk_visible" ' . $checked1 . ' /><label for="chk_visible"> &nbsp показать товар</label></li>
                            </ul>
                        </div>

                        <div class="submit_form"><input type="submit" id="submit_form" name="submit_save" value="Сохранить" /></div>
                        </form>';
                    } while ($row = mysqli_fetch_array($result));
                }
                ?>


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

                <script defer type="text/javascript" src="../javascript/scrollup.js"></script>
            </div>
        </div>
        <?php include("footer.php") ?>
        <a href="#" class="scrollup">Наверх</a>

    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>