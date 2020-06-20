<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");


    $action = $_GET["action"];
    //проверяем существует ли переменная
    if (isset($action)) {
        $id = (int) $_GET["id"];
        switch ($action) {
            case 'delete':
                $delete = mysqli_query($link, "DELETE FROM products WHERE id = '$id'");
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

        <link rel="stylesheet" href="style/tovar/tovar.css">
        <link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">

    </head>

    <body>

        <?php include("header.php");

        $all_count = mysqli_query($link, "SELECT * FROM products");
        $all_count_result = mysqli_num_rows($all_count); //mysqli_num_rows подсчитываем кол-во товаров
        ?>

        <div class="container block_cuntent">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Товары</li>
                </ol>
            </nav>

            <?php include("panelyprav.php"); ?>




            <div id="block-info">
                <p id="count-style">Всего товаров- <strong><?php echo $all_count_result; ?></strong></p>
                <p id="add-style"><a href="add_product.php">Добавить товар</a></p>
            </div>



            <div class="row justify-content-center">
                <div class="col-xl-auto col-lg-auto col-md-3 col-auto">
                    <?php
                    $num = 8; //вывод товара 
                    $page = (int) $_GET['page']; //значение страници              

                    $count = mysqli_query($link, "SELECT COUNT(*) FROM products $cat");
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
                    ?>

                    <li>
                        <ul class="cards">
                            <?php
                            $result = mysqli_query($link, "SELECT * FROM products $cat ORDER BY id DESC LIMIT  $start, $num");
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_array($result);
                                do {
                                    if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                                        $img_path = '../assets/products/' . $row["image"]; //фото есть 
                                    } else {
                                        $img_path = "../assets/products/no_photo.jpg"; //фото нету
                                    }
                                    echo (' 
                                    <li>
                                            <div class = "blockimage">
                                                    <div class = "card_image"> <img src="' . $img_path . '" /> </div>
                                            </div>
                                                <div class="down_card">
                                                    <div class="tow_title"> <a>' . $row["title"] . '</a> </div> 
                                            </div>
                                      
                                        <div class="card_price2">
                                            <a href="edit_product.php?id=' . $row["id"] . '">Изменить</a> | 
                                            <a rel="tovar.php?id=' . $row["id"] . '&action=delete" class="delete" >Удалить</a>
                                        </div>
                                    </li>
                                  
                
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ...
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </p>
                                </li>
                                ');
                                } while ($row = mysqli_fetch_array($result));
                            }
                            ?>
                        </ul>
                </div>
            </div>









            <div class="container-fluid" id="pagination">
                <?php
                if ($page != 1) {
                    $pstr_prev = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page - 1) . '">    <   </a></li>';
                }
                if ($page != $total) {
                    $pstr_next = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page + 1) . '">    >   </a></li>';
                }

                // Формируем ссылки со страницами

                if ($page - 4 > 0) $page4left = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
                if ($page - 3 > 0) $page3left = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
                if ($page - 2 > 0) $page2left = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
                if ($page - 1 > 0) $page1left = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';
                if ($page + 4 <= $total) $page4right = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
                if ($page + 3 <= $total) $page3right = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
                if ($page + 2 <= $total) $page2right = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
                if ($page + 1 <= $total) $page1right = '<li class="page-item"><a class="page-link" href="tovar.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';

                if ($page + 5 == $total) {
                    $strtotal1 = '<li><a class="page-link" href="tovar.php?page=' . $total . '">' . $total . '</a></li>';
                } elseif ($page + 4 < $total) {
                    $strtotal1 = '<li class="page-item"><a class="page-link">...</a></li><li><a class="page-link" href="tovar.php?page=' . $total . '">' . $total . '</a></li>';
                } else {
                    $strtotal1 = "";
                }

                if ($page == 6) {
                    $strtotal2 = '<li><a class="page-link" href="tovar.php?page=' . 1 . '">' . 1 . '</a></li>';
                } elseif ($page - 4 > 1) {
                    $strtotal2 = '<li><a class="page-link" href="tovar.php?page=' . 1 . '">' . 1 . '</a></li> <li class="page-item"><a class="page-link">...</a></li>';
                } else {
                    $strtotal2 = "";
                }

                if ($total > 1) {
                    echo '
                        <nav class="container_pagination" aria-label="Page navigation example">
                        <ul class="pagination">
                        ';
                    echo $pstr_prev . $strtotal2  . $page4left . $page3left . $page2left . $page1left .
                        "<li class='page-item active' ><p class='page-link' href='tovar.php?sort=" . $_GET["sort"] . " &page=" . $page . "'>" . $page . "</p></li>" . $page1right . $page2right . $page3right . $page4right  . $strtotal1 . $pstr_next;
                    echo '
                 </ul>
            </nav>
            ';
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