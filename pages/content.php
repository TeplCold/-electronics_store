<?php
include("db_connect.php");
session_start();
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
include("group_numerals.php");

$id  = clear_string($_GET["id"]); //подключаем функцию очистки строк
$id  = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
$id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

//проверка чтобы не было накрутки просмторов товара при перезагрузке

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

    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <!-- owlcarousel css style -->
    <link rel="stylesheet" href="../owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../owlcarousel/assets/owl.theme.default.min.css">

    <!---------------------------------------------------------------------------->
    <link rel="stylesheet" type="text/css" href="../style/content/content.css">

</head>


<body>
    <?php include("header_footer/header.php");

    echo ('<div class="owl-carousel owl-theme" id="carousel1" >');
    $result = mysqli_query($link, "SELECT * FROM image_products WHERE products_id='$id'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        do {
            if ($row["image"] != "" && file_exists("../assets/products/" . $row["image"])) {
                $img_path = '../assets/products/' . $row["image"]; //фото есть 
            } else {
                $img_path = "../assets/products/no_photo.jpg"; //фото нету
            }
            echo ('
                <div> <img src="' . $img_path . '" alt="Img"/> </div>
                ');
        } while ($row = mysqli_fetch_array($result));
        echo ('</div>');
    }

    $result = mysqli_query($link, "SELECT * FROM products WHERE id ='$id' AND visible='1'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        do {
            $query_reviews = mysqli_query($link, "SELECT * FROM reviews_products WHERE products_id='$id' AND moderat='1'");
            $count_reviews =  mysqli_num_rows($query_reviews);
            echo ('
            <div> ' . $row["title"] . ' </div>
            <div> ' . $row["count"] . ' </div>
            
            <div>' . group_numerals($row["price"]) . '₽ </div>
            <a  class="add-card"  tid="' . $row["id"] . '" >в корзину</a>
            <div> ' . $row["min_description"] . ' </div>
            ');

            if (!empty($query_reviews)) {
                $rating = 0;

                foreach ($query_reviews as $row) {
                    $rating += $row['rating'];
                }
                ini_set('display_errors', 0);
                $rating = $rating / $count_reviews;
    ?>
                <p>Средний рейтинг <?php echo round($rating, 2); ?></p>
                <div class="rating-mini">
                    <span class="<?php if (round($rating) >= 1) echo 'active'; ?>"></span>
                    <span class="<?php if (round($rating) >= 2) echo 'active'; ?>"></span>
                    <span class="<?php if (round($rating) >= 3) echo 'active'; ?>"></span>
                    <span class="<?php if (round($rating) >= 4) echo 'active'; ?>"></span>
                    <span class="<?php if (round($rating) >= 5) echo 'active'; ?>"></span>
                </div>
                <p>На основе <?php echo $count_reviews; ?> оценок</p>


                <?php
            }

            echo ('
         
            ');
        } while ($row = mysqli_fetch_array($result));

        $result = mysqli_query($link, "SELECT * FROM products WHERE id ='$id' AND visible='1'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            echo ('
                    <br>
                    <br>
                    <br>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Описание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Characteristics-tab" data-toggle="tab" href="#Characteristics" role="tab" aria-controls="Characteristics" aria-selected="false">Характеристики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Отзывы</a>
                    </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">' . $row["description"] . '</div>
                        <div class="tab-pane fade" id="Characteristics" role="tabpanel" aria-labelledby="Characteristics-tab">' . $row["features"] . '</div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    ');


            $query_reviews = mysqli_query($link, "SELECT * FROM reviews_products WHERE products_id='$id' AND moderat='1' ORDER BY reviews_id DESC");

            if (mysqli_num_rows($query_reviews) > 0) {
                $row_reviews = mysqli_fetch_array($query_reviews);
                do {

                    $date = strtotime($row_reviews["date"]);



                    echo ' <div class="block-reviews" >
                       <h3>-----------------------------------------------------------------------------------------------------------------------------</h3>
                       <strong>' . $row_reviews["name"] . '</strong>, ' . date("d.m.Y", $date) . '
                       <br>
                       ';


                    $rating = round($row_reviews["rating"] / $query_reviews);
                ?>

                    <div class="rating-mini">
                        <span class="<?php if ($rating >= 1) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 2) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 3) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 4) echo 'active'; ?>"></span>
                        <span class="<?php if ($rating >= 5) echo 'active'; ?>"></span>
                    </div>


    <?php
                    echo '
                       <p> Плюсы' . $row_reviews["good_reviews"] . '</p>
                       <p> Минусы ' . $row_reviews["bad_reviews"] . '</p>
                       <p> Отзыв' . $row_reviews["comment"] . '</p> </div>
                       ';
                } while ($row_reviews = mysqli_fetch_array($query_reviews));
            } else {
                echo '<p">Будь первым, кто оставит отзыв.</p>';
            }

            echo ' 
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
              Написать отзыв
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">

                  <div class="rating-area">
                  <input type="radio" id="star-5" name="rating" value="5">
                  <label for="star-5" title="Оценка «5»"></label>	
                  <input type="radio" id="star-4" name="rating" value="4">
                  <label for="star-4" title="Оценка «4»"></label>    
                  <input type="radio" id="star-3" name="rating" value="3">
                  <label for="star-3" title="Оценка «3»"></label>  
                  <input type="radio" id="star-2" name="rating" value="2">
                  <label for="star-2" title="Оценка «2»"></label>    
                  <input type="radio" id="star-1" name="rating" value="1">
                  <label for="star-1" title="Оценка «1»"></label>
                  </div>
            ';

            if ($_SESSION['auth'] == 'yes_auth') {
                echo ('
                <ul>
                <li><p><textarea placeholder="Имя" id="name_review" disabled="disabled"> ' . $_SESSION['auth_name'] . '</textarea></p></li>   
                <li><p><textarea placeholder="Достоинства" id="good_review" ></textarea></p></li>    
                <li><p><textarea placeholder="Недостатки" id="bad_review" ></textarea></p></li>     
                <li><p><textarea placeholder="Комментарий" id="comment_review" ></textarea></p></li>     
                </ul>');
            } else {
                echo (' 
                <ul>
                <li><p><textarea placeholder="Имя" id="name_review"></textarea></p></li>    
                <li><p><textarea placeholder="Достоинства" id="good_review" ></textarea></p></li>    
                <li><p><textarea placeholder="Недостатки" id="bad_review" ></textarea></p></li>     
                <li><p><textarea placeholder="Комментарий" id="comment_review" ></textarea></p></li>     
                </ul>');
            }





            echo ('
                  </div>
                  <div class="modal-footer">
                  <p>Комментарии публикуются после проверки модераторами. Если вы оскорбили собеседника, использовали ненормативную лексику или указали ссылку на другой сайт, то комментарий не будет опубликован.</p>
                  <p id="reload-img"><img src="../assets/reg_aunt/loading.gif"/></p> <p id="button-send-review" iid="' . $id . '" ></p>
                  </div>
                </div>
              </div>
            </div> 
        </div>
            ');
        }
        while ($row = mysqli_fetch_array($result));
    }

    ?>

    <?php include("header_footer/footer.php") ?>

    <script type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../javascript/jquery-3.5.1.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-------------------------------------------------------------------------->
    <script src="../owlcarousel/owl.carousel.min.js"></script>
    <script src="../owlcarousel/connection_owlcarousel.js"></script>
    <script src="../javascript/content.js"></script>
</body>

</html>