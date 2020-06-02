<?php include("db_connect.php");
session_start();
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
include("group_numerals.php");

$id  = clear_string($_GET["id"]); //подключаем функцию очистки строк
$id  = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
$id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.



if ($id != $_SESSION['countid']) {
    $querycount = mysqli_query($link, "SELECT count FROM products WHERE id='$id'");
    $resultcount = mysqli_fetch_array($querycount);

    $newcount = $resultcount["count"] + 1;

    $update = mysqli_query($link, "UPDATE products SET count='$newcount' WHERE id='$id'");
}

$_SESSION['countid'] = $id;
?>



<!DOCTYPE html>
<html lang="ru">

<head>

    <!-- <title></title> -->

    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!--  -->
    <link rel="stylesheet" type="text/css" href="../style/product_list/product_list.css">

    <script type="text/javascript" src="../../javascript/jquery-3.4.1.js"></script>





</head>


<body>

    <?php include("header_footer/header.php");





    $result = mysqli_query($link, "SELECT * FROM products WHERE id ='$id' AND visible='1'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        do {
            if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                $img_path = '../assets/products/' . $row["image"]; //фото есть 
            } else {
                $img_path = "../assets/products/no_photo.jpg"; //фото нету
            }
            echo ('


            <div class = "card_image">
            <img src="' . $img_path . '" /> 
            </div>

            <div> ' . $row["title"] . ' </div>

            <div> ' . $row["count"] . ' </div>

                        
            <div>' . group_numerals($row["price"]) . '₽ </div>

            <a  class="add-card"  tid="' . $row["id"] . '" >в корзину</a>

            <div> ' . $row["min_description"] . ' </div>
       
            ');
        } while ($row = mysqli_fetch_array($result));
    }









    ?>











    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>