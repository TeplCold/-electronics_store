<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../db_connect.php");
    include("../group_numerals.php");

    $result = mysqli_query($link, "SELECT * FROM cart WHERE ip_users = '{$_SERVER['REMOTE_ADDR']}'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        do {
            $int = $int + ($row["cart_price"] * $row["count_cart"]);
        } while ($row = mysqli_fetch_array($result));

        echo group_numerals($int);
    }
}
?>