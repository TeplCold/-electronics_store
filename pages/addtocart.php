<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("db_connect.php");
    include("reg_aunt/functions.php");

    $id = clear_string($_POST["id"]); // подключаем функцию очистки строк
    $id = mb_strtolower($id, 'UTF-8'); // Приведение строки к нижнему регистру
    $id =  mysqli_real_escape_string($link, $id); // Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    $result = mysqli_query($link, "SELECT * FROM cart WHERE ip_users = '{$_SERVER['REMOTE_ADDR']}' AND id_products_cart = '$id'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $new_count = $row["count_cart"] + 1;
        $update = mysqli_query($link, "UPDATE cart SET count_cart='$new_count' WHERE ip_users = '{$_SERVER['REMOTE_ADDR']}' AND  id_products_cart ='$id'");
    } else {

        $result = mysqli_query($link, "SELECT * FROM products WHERE id = '$id'");
        $row = mysqli_fetch_array($result);

        mysqli_query($link, "INSERT INTO cart(id_products_cart,cart_price,datetime_cart,ip_users)
						VALUES(	
                            '" . $row['id'] . "',
                            '" . $row['price'] . "',					
							NOW(),
                            '" . $_SERVER['REMOTE_ADDR'] . "'                                                                        
						    )");
    }
}
