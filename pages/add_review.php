<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("db_connect.php");
    include("reg_aunt/functions.php");

    $id  = clear_string($_POST['id']); //подключаем функцию очистки строк
    $id  = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и  Control-Z.

    $name   = clear_string($_POST['name']);
    $name   = mysqli_real_escape_string($link, $name); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    $name   = mb_strtolower($name, 'UTF-8'); //Приведение строки к нижнему регистру
    $name  = mb_convert_case($name, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

    $star  = clear_string($_POST['star']); //подключаем функцию очистки строк
    $star  = mb_strtolower($star, 'UTF-8'); //Приведение строки к нижнему регистру

    $good   = clear_string($_POST['good']);
    $good   = mysqli_real_escape_string($link, $good); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    $good   = mb_strtolower($good, 'UTF-8'); //Приведение строки к нижнему регистру
    $good  = mb_convert_case($good, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

    $bad   = clear_string($_POST['bad']);
    $bad   = mysqli_real_escape_string($link, $bad); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    $bad   = mb_strtolower($bad, 'UTF-8'); //Приведение строки к нижнему регистру
    $bad  = mb_convert_case($bad, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

    $comment   = clear_string($_POST['comment']);
    $comment   = mysqli_real_escape_string($link, $comment); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    $comment   = mb_strtolower($comment, 'UTF-8'); //Приведение строки к нижнему регистру
    $comment  = mb_convert_case($comment, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

    mysqli_query($link, "INSERT INTO reviews_products(products_id,name,rating,good_reviews,bad_reviews,comment,date)
                            VALUES(						
                                '" . $id . "',
                                '" . $name . "',
                                '" . $star . "',
                                '" . $good . "',
                                '" . $bad . "',
                                '" . $comment . "',
                                NOW()							
                            )");
    echo true;
}
