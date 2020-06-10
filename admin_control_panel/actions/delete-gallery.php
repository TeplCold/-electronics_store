<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include("../../pages/db_connect.php");

  $path = $_SERVER['DOCUMENT_ROOT'] . "/assets/products/" . $_POST["title"];

  if (file_exists($path)) {
    unlink($path);
    $delete = mysqli_query($link, "DELETE FROM image_products WHERE id = '{$_POST["id"]}'");
    echo "delete";
  } else {
    echo "delete";
    $delete = mysqli_query($link, "DELETE FROM image_products WHERE id = '{$_POST["id"]}'");
  }
}
