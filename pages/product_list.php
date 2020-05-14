<?php include("db_connect.php");
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










    <div class="container_cards">
        <ul class="cards">
            <?php
            $result =  mysqli_query($link, "SELECT * FROM  `products` ORDER BY $sorting");
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



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>