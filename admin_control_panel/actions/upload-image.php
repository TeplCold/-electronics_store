<?php
$error_img = array();

if ($_FILES['upload_image']['error'] > 0) {
  //выводим ошибки в зависимости от номера
  switch ($_FILES['upload_image']['error']) {
    case 1:
      $error_img[] =  'Размер файла превышает допустимое значение UPLOAD_MAX_FILE_SIZE';
      break;
    case 2:
      $error_img[] =  'Размер файла превышает допустимое значение MAX_FILE_SIZE';
      break;
    case 3:
      $error_img[] =  'Не удалось загрузить часть фаила';
      break;
    case 4:
      $error_img[] =  'Фаил не был загружен';
      break;
    case 6:
      $error_img[] =  'Отсутствует временная папка.';
      break;
    case 7:
      $error_img[] =  'Не удалось записать фаил на диск.';
      break;
    case 8:
      $error_img[] =  'PHP-расширение остановло загрузку файла.';
      break;
  }
} else {
  //проверяем расширения
  if ($_FILES['upload_image']['type'] == 'image/jpeg' || $_FILES['upload_image']['type'] == 'image/jpg' || $_FILES['upload_image']['type'] == 'image/png') {

    $imgext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['upload_image']['name']));

    //папка для загрузки
    $uploaddir = '../assets/products/';
    //новое сгенерированное имя файла
    $newfilename = $_POST["form_title"] . '-' . $id . rand(1, 100) . '.' . $imgext;
    $newfilename = preg_replace('/[а-я]+/iu', "", $newfilename);
    //путь к файлу (папка.фаил)
    $uploadfile = $uploaddir . $newfilename;

    //загружаем фаил move_uploaded_file
    if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $uploadfile)) {

      $update = mysqli_query($link, "UPDATE products SET image='$newfilename' WHERE id = '$id'");
    } else {
      $error_img[] =  "Ошибка загрузки файла.";
    }
  } else {
    $error_img[] =  'Неверный формат: jpeg, jpg, png';
  }
}
