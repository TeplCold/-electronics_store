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

        case 'accept':
            $sort = "moderat='1' DESC";
            $sort_name = ' проверенные';
            break;

        case 'no-accept':
            $sort = "moderat='0' DESC";
            $sort_name = ' не проверенные';
            break;

        default:
            $sort = "reviews_id DESC";
            $sort_name = ' без сортировки';
            break;
    }


    $action = $_GET["action"];
    if (isset($action)) {

        switch ($action) {

            case 'accept':
                $update = mysqli_query($link, "UPDATE reviews_products SET moderat='1' WHERE reviews_id = '$id'");
                break;

            case 'delete':
                $delete = mysqli_query($link, "DELETE FROM reviews_products WHERE reviews_id = '$id'");
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

        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/reviews/reviews.css">
        <link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">

    </head>

    <body>

        <?php include("header.php");

        $all_count = mysqli_query($link, "SELECT * FROM reviews_products");
        $all_count_result = mysqli_num_rows($all_count);

        $no_accept_count = mysqli_query($link, "SELECT * FROM reviews_products WHERE moderat = '0'");
        $no_accept_count_result = mysqli_num_rows($no_accept_count);

        ?>


        <div class="container block_cuntent">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Отзывы</li>
                </ol>
            </nav>

            <?php include("panelyprav.php"); ?>



            <div id="block-info">
                <ul id="review-info-count">
                    <li>Всего отзывов - <strong><?php echo $all_count_result; ?></strong></li>
                    <li>Не проверенные - <strong><?php echo $no_accept_count_result; ?></strong></li>
                </ul>
            </div>

            <div id="block-parameters">
                <ul id="options-list">
                    <li>Сортировать:&nbsp; </li> <li></li>
                    <li><a id="select-links" href="#">
                            <? echo   $sort_name; ?></a>
                        <ul id="list-links-sort">
                            <li><a href="reviews.php?sort=accept"> проверенные</a></li>
                            <li><a href="reviews.php?sort=no-accept"> не проверенные</a></li>
                        </ul>
                    </li>
                </ul>
            </div>


            <?php
            $num = 5;
            $page = (int) $_GET['page'];

            $count = mysqli_query($link, "SELECT COUNT(*) FROM products WHERE visible = '1'");
            $temp = mysqli_fetch_array($count);

            if ($temp[0] > 0) {
                $tempcount = $temp[0];
                // находим общее число страниц 
                $total = (($tempcount - 1) / $num) + 1;
                $total =  intval($total);
                $page = intval($page);

                if (empty($page) or $page < 0) {
                    $page = 1;
                }
                if ($page > $total) {
                    $page = $total;
                }
                // вычисляем с какого номера начинать следует выводить товар
                $start = $page * $num - $num;
                $qury_start_num = " LIMIT $start, $num";
            }

            $result = mysqli_query($link, "SELECT * FROM reviews_products,products WHERE products.id = reviews_products.products_id ORDER BY $sort LIMIT $start, $num");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);

                do {
                    if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                        $img_path = '../assets/products/' . $row["image"]; //фото есть 
                    } else {
                        $img_path = "../assets/products/no_photo.jpg"; //фото нету
                    }

                    $row_date = strtotime($row["date"]);

                    if ($row["moderat"] == '0') {
                        $link_accept = '<a class="green" href="reviews.php?id=' . $row["reviews_id"] . '&action=accept" >Принять</a> | ';
                    } else {
                        $link_accept = '';
                    }

                    $rating = round($row['rating'] / $result);

                    echo ('
                        
            <div class="container-fluid">   

                <div class="block_content">
                   
                    <div class="block-reviews" >
                        <div class="containerblock-reviews">
                            <div class="block-reviews-name"><strong >' . $row["name"] . '</strong></div>'); ?>
                    <div class="rating-mini">
                        <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                    </div><?php echo '
                            <div class="container_data"> ' . date("d.m.Y", $date) . '</div>  
                        </div>

                        <div class="block_cardss">
                            <div class="container_cardss">
                                <div class = "blockimage">
                                    <div class = "card_image"> <img src="' . $img_path . '" /> </div>   
                                </div>
                            </div>
                        </div>    
                            
                        <div> ' . $row["title"] . ' </div>
                      
                        <div class="container_reviews"> 
                            <div class="block_reviews"> Достоинства </div>  
                            <p class="block_coment"> ' . $row["good_reviews"] . '</p>
                            <div class="block_reviews"> Недостатки </div> 
                            <p class="block_coment"> ' . $row["bad_reviews"] . '</p>
                            <div class="block_reviews"> Комментарий </div>
                            <p class="block_coment"> ' . $row["comment"] . '</p> 
                        </div>
                    </div>
                    
                        <p class="links-actions">' . $link_accept . '<a class="delete2" rel="reviews.php?id=' . $row["reviews_id"] . '&action=delete" >Удалить</a> </p>
                </div>
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