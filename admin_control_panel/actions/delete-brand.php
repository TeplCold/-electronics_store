<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("../../pages/db_connect.php");

    $delete = mysqli_query($link, "DELETE FROM brand WHERE brand_id = '{$_POST["id"]}'");
    echo "delete";
}
