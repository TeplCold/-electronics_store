<?php include("pages/db_connect.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Главная</title>
    <link rel="shortcut icon" href="../../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

    <?php include("pages/header_footer/header.php") ?>




    новинки
    <!-- 
    <?php
    $result =  mysqli_query($link, "SELECT * FROM  `products` WHERE `new_items` = 1");
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
                        <img src="' . $img_path . '" /> 
                     ' . $row["title"] . '
                     ' . $row["price"] . '₽
                        </li>
                        ');
        } while ($row = mysqli_fetch_array($result));
    }
    ?> -->

</body>

</html>