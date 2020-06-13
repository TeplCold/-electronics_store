<?php
include("db_connect.php");
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
include("group_numerals.php");
session_start();

$sorting = '';
if (isset($_GET['sort'])) {
    $sorting = $_GET['sort'];
}
switch ($sorting) {

    case 'price-asc';
        $sorting = 'price ASC';
        $sort_name = 'Цена (по возрастанию)';
        break;

    case 'price-desc';
        $sorting = 'price DESC';
        $sort_name = 'Цена (по убыванию)';
        break;

    case 'title';
        $sorting = 'title';
        $sort_name = 'от А до Я';
        break;

    default:
        $sorting = 'id ASC';
        $sort_name = 'без сортировки';
        break;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <title>Каталог</title>
    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="../style/product_list/product_list.css">

</head>


<body>

    <?php include("header_footer/header.php") ?>

    <div class="containerglavn">
        <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
        <div class="inetshop"> Интернет магазин</div>
        <div class="glavnplus"> SPASE ELECTRONICS - Игровой торрент портал для настоящих PRO геймеров, это молодой, но успешно развивающийся игровой торрент портал. На нашем сайте, пользователям предоставляется возможность скачать игру без регистрации и каких либо ограничений, также на сайте представленны статьи, анонсы, гайды и многое другое.</div>
        <div class="join"> Приятных покупок!</div>
        <p id="block-basket"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
    </div>

    <ul id="options-list">
        Сортировать:

        <li> <a id="select-sort"><?php echo $sort_name; ?></a>
            <ul id="sorting-list">
                <li><a href="product_list.php?sort=id-ASC">без сортировки</a></li>
                <li><a href="product_list.php?sort=price-desc">Цена (по убыванию)</a></li>
                <li><a href="product_list.php?sort=price-asc">Цена (по возрастанию)</a></li>
                <li><a href="product_list.php?sort=title">от А до Я</a></li>
            </ul>
        </li>
    </ul>

    <div class="container text-white ">

        <div class="row justify-content-center">


            <div class="col-xl-auto col-lg-auto col-md-3 col-auto">

                <ul class="cards">
                    <?php
                    $num = 16; //вывод товара 
                    $page = (int) $_GET['page']; //значение страници              

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

                    $result = mysqli_query($link, "SELECT * FROM products WHERE visible='1' ORDER BY $sorting $qury_start_num ");

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                                $img_path = '../assets/products/' . $row["image"]; //фото есть 
                            } else {
                                $img_path = "../assets/products/no_photo.jpg"; //фото нету
                            }

                            $query_reviews = mysqli_query($link, "SELECT * FROM reviews_products WHERE products_id='{$row['id']}' AND moderat='1'");
                            $row_reviews = mysqli_fetch_array($query_reviews);
                            $rating = round($row_reviews['rating'] / $query_reviews);
                            $a = mysqli_num_rows($query_reviews);

                            echo (' 
                        <li>

                        <div class="count_otzv">
                            <div class="count"> <img src="../assets/64875.png" />' . $row["count"] . ' </div>
                        </div>
                      


                            <a href="/pages/content.php?id=' . $row["id"] . '">
                            


                         <div class = "blockimage">
                                <div class = "card_image"> <img src="' . $img_path . '" /> </div>
                            </div>


                             <div class="down_card">
                              <div class="tow_title"> <a>' . $row["title"] . '</a> </div> 
                                ');
                    ?>

                            <div class="rating">
                                <div class="rating-mini">
                                    <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>
                                    <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>
                                    <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>
                                    <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>
                                    <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                                </div>


                        <?php
                            echo ('  
                                <div class="otzv"> <img src="../assets/sms.png" />' .  $a . ' </div>
                            </div>
                     
                            </a>

                            <div class="card_price">
                                <div class="price">' . group_numerals($row["price"]) . '₽ </div>
                                 <div class="add-card"  tid="' . $row["id"] . '" > <img src="../assets/_9610-12+.png" /></div>
                            </div>
                            </div>
                        </li>
                        ');
                        } while ($row = mysqli_fetch_array($result));
                    }
                        ?>
                </ul>

            </div>

        </div>

    </div>











    <?php

    if ($page != 1) {
        $pstr_prev = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page - 1) . '">    <   </a></li>';
    }
    if ($page != $total) {
        $pstr_next = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page + 1) . '">    >   </a></li>';
    }

    // Формируем ссылки со страницами

    if ($page - 4 > 0) $page4left = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
    if ($page - 3 > 0) $page3left = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
    if ($page - 2 > 0) $page2left = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
    if ($page - 1 > 0) $page1left = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';
    if ($page + 4 <= $total) $page4right = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
    if ($page + 3 <= $total) $page3right = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
    if ($page + 2 <= $total) $page2right = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
    if ($page + 1 <= $total) $page1right = '<li class="page-item"><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';

    if ($page + 5 == $total) {
        $strtotal1 = '<li><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . $total . '">' . $total . '</a></li>';
    } elseif ($page + 4 < $total) {
        $strtotal1 = '<li class="page-item"><a class="page-link">...</a></li><li><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . $total . '">' . $total . '</a></li>';
    } else {
        $strtotal1 = "";
    }

    if ($page == 6) {
        $strtotal2 = '<li><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . 1 . '">' . 1 . '</a></li>';
    } elseif ($page - 4 > 1) {
        $strtotal2 = '<li><a class="page-link" href="product_list.php?sort=' . $_GET["sort"] . '&page=' . 1 . '">' . 1 . '</a></li> <li class="page-item"><a class="page-link">...</a></li>';
    } else {
        $strtotal2 = "";
    }

    if ($total > 1) {
        echo '
    <nav class="container_pagination" aria-label="Page navigation example">
    <ul class="pagination">
    ';
        echo $pstr_prev . $strtotal2  . $page4left . $page3left . $page2left . $page1left .
            "<li class='page-item active' ><p class='page-link' href='product_list.php?sort=" . $_GET["sort"] . " &page=" . $page . "'>" . $page . "</p></li>" . $page1right . $page2right . $page3right . $page4right  . $strtotal1 . $pstr_next;
        echo '
    </ul>
    </nav>
    ';
    }
    ?>

    <?php include("header_footer/footer.php") ?>

    <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
    <script defer type="text/javascript" src="../javascript/cart.js"></script>
    <script defer type="text/javascript" src="../javascript/product_list.js"></script>
    <script defer type="text/javascript" src="../javascript/header_footer.js"></script>

    <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
    <script defer src="../bootstrap/js/bootstrap.min.js"></script>
    <script defer type="text/javascript" src="../javascript/scrollup.js"></script>
    <a href="#" class="scrollup">Наверх</a>

</body>

</html>