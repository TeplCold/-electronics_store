<?php include("pages/db_connect.php");
include("pages/reg_aunt/functions.php");
include("pages/reg_aunt/auth_cooke.php");
session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Главная</title>
    <link rel="shortcut icon" href="../../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="style/home/home.css">

</head>

<body id="particles-js">

    <?php include("pages/header_footer/header.php") ?>



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



    <script type="text/javascript" src="javascript/particles.min.js"></script>
    <script type="text/javascript" src="javascript/particles.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>