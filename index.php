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
    <link rel="stylesheet" type="text/css" href="style/home/home.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">

    <!-- owlcarousel css style -->
    <link rel="stylesheet" href="owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/assets/owl.theme.default.min.css">
</head>

<body>
    <div class="fon">

        <?php include("pages/header_footer/header.php") ?>

        <div class="containerglavn">
            <div class="blockglavn">
                <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
                <div class="inetshop"> Интернет магазин</div>
                <div class="glavnplus"> SPASE ELECTRONICS - небольшой, но динамично развивающийся интернет-магазин. Это позволяет нам более внимательно относиться к потребностям и желаниям наших покупателей. Индивидуальный подход, подробные консультации, широкий ассортимент электроники, цифровой и бытовой техники. Ассортимент постоянно расширяется. Интернет-магазин SPASE ELECTRONICS - это возможность сделать покупки оптом и в розницу.</div>
                <div class="join"> Приятных покупок!</div>
            </div>
        </div>
        <div class="block-basket">
            <p id="block-basket"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
        </div>



        <div class="container text-white ">
            <div class="row justify-content-center">
                <div class="col boxes "> Новинки</div>
                <div class="col-xl-auto col-lg-auto col-md-3 col-auto">
                    <ul class="cards">
                        <?php

                        $result =  mysqli_query($link, "SELECT * FROM  `products` WHERE visible = '1' ORDER BY`datatime` DESC LIMIT 8");

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
                                $a = mysqli_num_rows($query_reviews);

                                echo (' 
                            <li>

                                <div class="count_otzv">
                                    <div class="count"> <img src="assets/64875.png" />' . $row["count"] . ' </div>
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
                                        <div class="otzv"> <img src="assets/sms.png" />' .  $a . ' </div>
                                    </div>
                        
                                </a>

                                <div class="card_price">
                                    <div class="price">' . group_numerals($row["price"]) . '₽ </div>
                                    <div class="add-card"  tid="' . $row["id"] . '" > <img src="assets/_9610-12+.png" /></div>
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

        <div class="container-fluid downheader ">
            <div class="container text-white ">
                <div class="row justify-content-center">
                    <div class="col boxes "> Популярные товары</div>
                    <div class="col-xl-auto col-lg-auto col-md-3 col-auto">
                        <ul class="cards">
                            <?php

                            $result =  mysqli_query($link, "SELECT * FROM  `products` WHERE visible = '1' ORDER BY`count` DESC LIMIT 4");

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
                                    $a = mysqli_num_rows($query_reviews);

                                    echo (' 
                                <li>

                                    <div class="count_otzv">
                                        <div class="count"> <img src="assets/64875.png" />' . $row["count"] . ' </div>
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
                                            <div class="otzv"> <img src="assets/sms.png" />' .  $a . ' </div>
                                        </div>
                            
                                    </a>

                                    <div class="card_price">
                                        <div class="price">' . group_numerals($row["price"]) . '₽ </div>
                                        <div class="add-card"  tid="' . $row["id"] . '" > <img src="assets/_9610-12+.png" /></div>
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
        </div>

        <div class="container-fluid text-white " data-wow-offset="300">

            <div class=" justify-content-center">

                <div class="col text-center  boxesobzor">Обзоры</div>
                <div class="w-100"></div>
                <div class="txt-tril text-center">
                    Мы с радостью предоставляем Вам видеообзоры наших товаров
                    <div class="w-100"></div>
                    Приятного просмотра!
                </div>
                <div class="w-100"></div>

                <div class="container">
                    <div id="carouselExampleIndicators" class="carousel slide my-carousel" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">

                            <div class="carousel-item active">

                                <div class="container">

                                    <div class="mar">

                                        <div class=" justify-content-center text-center asas">

                                            <div class="  text-center txt ">

                                                <div class=" buttonbox">

                                                    <div class="holder">
                                                        <button id="click" class="block" type="button" data-toggle="modal" data-target="#exampleModalCenter"> cмотреть</button>
                                                    </div>
                                                    <img src="//img.youtube.com/vi/kc-OcOduEx0/mqdefault.jpg" alt="Need For Speed: Payback - трейлер" class="img_thriller">

                                                    <div class="thriller_Name"> Need For Speed Payback</div>

                                                    <div class="smpage ">
                                                        <a href="pages/infGame/Need_for_Speed_Payback.html" class="smBtn ">
                                                            Перейти к товару
                                                        </a>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class=" text-center txt">

                                                <div class=" buttonbox">
                                                    <div class="holder ">

                                                        <button id="click2" class="block" type="button" data-toggle="modal" data-target="#exampleModalCenter"> cмотреть </button>

                                                    </div>

                                                    <img src="//img.youtube.com/vi/DuvN4YcJ0ZA/mqdefault.jpg" alt="Need For Speed: Payback - трейлер" div class="img_thriller">

                                                    <div class="thriller_Name"> Metro: Exodus </div>

                                                    <div class="smpage ">

                                                        <a href="pages/infGame/Metro_Exodus.html" class="smBtn">

                                                            Перейти к товару

                                                        </a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="carousel-item ">

                                <div class="container">

                                    <div class="mar">

                                        <div class=" justify-content-center text-center asas">

                                            <div class="  text-center txt ">

                                                <div class=" buttonbox">

                                                    <div class="holder">
                                                        <button id="click" class="block" type="button" data-toggle="modal" data-target="#exampleModalCenter"> cмотреть</button>
                                                    </div>
                                                    <img src="//img.youtube.com/vi/kc-OcOduEx0/mqdefault.jpg" alt="Need For Speed: Payback - трейлер" class="img_thriller">

                                                    <div class="thriller_Name"> Need For Speed Payback</div>

                                                    <div class="smpage ">
                                                        <a href="pages/infGame/Need_for_Speed_Payback.html" class="smBtn ">
                                                            Перейти к товару
                                                        </a>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class=" text-center txt">

                                                <div class=" buttonbox">
                                                    <div class="holder ">

                                                        <button id="click2" class="block" type="button" data-toggle="modal" data-target="#exampleModalCenter"> cмотреть </button>

                                                    </div>

                                                    <img src="//img.youtube.com/vi/DuvN4YcJ0ZA/mqdefault.jpg" alt="Need For Speed: Payback - трейлер" div class="img_thriller">

                                                    <div class="thriller_Name"> Metro: Exodus </div>

                                                    <div class="smpage ">

                                                        <a href="pages/infGame/Metro_Exodus.html" class="smBtn">

                                                            Перейти к товару

                                                        </a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Назад</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Вперед</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>



        <div class="container-fluid recomend ">
            <div class="container text-white ">
                <div class="row justify-content-center">
                    <div class="col boxes "> Рекомендуемые товары</div>
                    <div class="col-xl-auto col-lg-auto col-md-3 col-auto">
                        <ul class="cards">
                            <?php

                            $result =  mysqli_query($link, "SELECT * FROM products,reviews_products WHERE  products.visible = '1' AND reviews_products.moderat='1' AND products.id=reviews_products.products_id ORDER BY reviews_products.rating DESC LIMIT 4	");

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
                                    $a = mysqli_num_rows($query_reviews);

                                    echo (' 
                                <li>

                                    <div class="count_otzv">
                                        <div class="count"> <img src="assets/64875.png" />' . $row["count"] . ' </div>
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
                                            <div class="otzv"> <img src="assets/sms.png" />' .  $a . ' </div>
                                        </div>
             
                                    </a>

                                    <div class="card_price">
                                        <div class="price">' . group_numerals($row["price"]) . '₽ </div>
                                        <div class="add-card"  tid="' . $row["id"] . '" > <img src="assets/_9610-12+.png" /></div>
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
        </div>

        <div class="container text-white ">
            <div class="row justify-content-center">
                <div class="col boxes "> Случайные товары</div>
                <div class="col-xl-auto col-lg-auto col-md-3 col-auto">
                    <ul class="cards">
                        <?php

                        $result =  mysqli_query($link, "SELECT DISTINCT * FROM  `products` WHERE visible = '1' ORDER BY RAND() DESC LIMIT 4");

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
                                $a = mysqli_num_rows($query_reviews);

                                echo (' 
                            <li>
                                <div class="count_otzv">
                                    <div class="count"> <img src="assets/64875.png" />' . $row["count"] . ' </div>
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
                                            <div class="otzv"> <img src="assets/sms.png" />' .  $a . ' </div>
                                        </div>
                                </a>

                                <div class="card_price">
                                    <div class="price">' . group_numerals($row["price"]) . '₽ </div>
                                    <div class="add-card"  tid="' . $row["id"] . '" > <img src="assets/_9610-12+.png" /></div>
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












        <?php include("pages/header_footer/footer.php") ?>

        <script defer type="text/javascript" src="javascript/jquery-3.4.1.js"></script>
        <script defer type="text/javascript" src="javascript/cart.js"></script>
        <script defer type="text/javascript" src="javascript/header_footer.js"></script>
        <script defer type="text/javascript" src="javascript/scrollup.js"></script>
        <script defer type="text/javascript" src="javascript/jquery-3.5.1.js"> </script>
        <script defer src="bootstrap/js/bootstrap.min.js"></script>

       


        <a href="#" class="scrollup">Наверх</a>
    </div>
</body>

</html>