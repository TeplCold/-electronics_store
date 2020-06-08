<?php
include("pages/db_connect.php");
include("pages/reg_aunt/functions.php");
include("pages/group_numerals.php");
include("pages/reg_aunt/auth_cooke.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Главная</title>
    <link rel="shortcut icon" href="../../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="style/content/content.css">

    <link rel="stylesheet" type="text/css" href="style/home/home.css">
</head>

<body>

    <?php include("pages/header_footer/header.php") ?>

    <p id="block-basket"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>

    <div class="container_cards">
        <div class="section_name"> новинки </div>
        <ul class="cards">
            <?php
            $result =  mysqli_query($link, "SELECT * FROM  `products` WHERE visible = '1' ORDER BY`datatime` DESC");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    if ($row["image"] != "" && file_exists("assets/products/" . $row["image"])) {
                        $img_path = 'assets/products/' . $row["image"]; //фото есть 
                    } else {
                        $img_path = "assets/products/no_photo.jpg"; //фото нету
                    }

                    $query_reviews = mysqli_query($link, "SELECT * FROM reviews_products WHERE products_id='{$row['id']}' AND moderat='1'");
                    $row_reviews = mysqli_fetch_array($query_reviews);
                    $rating = round($row_reviews['rating'] / $query_reviews);

                    echo (' 
                        <li>
                            <a href="/pages/content.php?id=' . $row["id"] . '">
                                <div class = "card_image"> <img src="' . $img_path . '" /> </div>
                                <div> ' . $row["title"] . ' </div>
                                ');
            ?>
                    <div class="rating-mini">
                        <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                    </div>

            <?php
                    echo ('
                                <div> 👁' . $row["count"] . ' </div>
                                <div>' . group_numerals($row["price"]) . '₽ </div>
                            </a>
                            <a  class="add-card"  tid="' . $row["id"] . '" >в корзину</a>
                        </li>
                        ');
                } while ($row = mysqli_fetch_array($result));
            }
            ?>
        </ul>
    </div>

    <?php include("pages/header_footer/footer.php") ?>


    <script defer type="text/javascript" src="javascript/jquery-3.4.1.js"> </script>
    <script type="text/javascript" src="javascript/jquery-3.5.1.js"> </script>


    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>