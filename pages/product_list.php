<?php include("db_connect.php");
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
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
<html lang="en">

<head>
    <title>Каталог</title>
    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="../style/product_list/product_list.css">

    <script type="text/javascript" src="../../javascript/jquery-3.4.1.js"></script>
    <script defer type="text/javascript" src="../javascript/product_list.js"></script>

</head>


<body id="particles-js">

    <?php include("header_footer/header.php") ?>

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

    <div class="container_cards container-fluid">
        <ul class="cards">
            <?php

            $num = 2; //вывод товара 
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
                    echo ('

                        <li>
                        <div class = "card_image">
                        <img src="' . $img_path . '" /> 
                        </div>
                        
                        <div> ' . $row["title"] . ' </div>
                        
                        <div>' . $row["price"] . '₽ </div>
                        
                        </li>
               
                   
                        ');
                } while ($row = mysqli_fetch_array($result));
            }
            ?>
        </ul>
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

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>