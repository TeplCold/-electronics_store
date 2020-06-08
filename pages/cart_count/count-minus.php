<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../db_connect.php");
    include("../reg_aunt/functions.php");

    $id  = clear_string($_POST['id']); //подключаем функцию очистки строк
    $id  = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z .

    $result = mysqli_query($link, "SELECT * FROM cart WHERE id_cart = '$id' AND ip_users = '{$_SERVER['REMOTE_ADDR']}'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $new_count = $row["count_cart"] - 1;

        if ($new_count > 0) {
            $update = mysqli_query($link, "UPDATE cart SET count_cart='$new_count' WHERE id_cart ='$id' AND ip_users = '{$_SERVER['REMOTE_ADDR']}'");
            echo $new_count;
        } else {
            echo $row["count_cart"];
        }
    }
}
