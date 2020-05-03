<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   session_start();
   include("../db_connect.php");
   include("functions.php");

   $error = array();
   $login = strtolower(clear_string($_POST['reg_login']));
   $pass = strtolower(clear_string($_POST['reg_pass']));
   $surname = clear_string($_POST['reg_surname']);
   $name = clear_string($_POST['reg_name']);
   $patronymic = clear_string($_POST['reg_patronymic']);
   $email = clear_string($_POST['reg_email']);



   if (strlen($login) < 5 or strlen($login) > 15) {
      $error[] = "Логин должен быть от 5 до 15 символов!";
   } else {
      $result =  mysqli_query($link, "SELECT login FROM users WHERE login = '$login'");
      if (mysqli_num_rows($result) > 0) {
         $error[] = "Логин занят!";
      }
   }

   if (strlen($pass) < 7 or strlen($pass) > 15) $error[] = "Укажите пароль от 7 до 20 симвлолв!";
   if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите фамилию от 3 до 20 символов!";
   if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите имя 3 от 15 символов!";
   if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "Укажите отчество от 3 до 25 символов!";
   //preg_match сверяет веденные данные с шаблоном
   //trim удаляет пробелы в начале и в конце
   if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) {
      $error[] = "Укажите корректный email!";
   } else {
      $result =  mysqli_query($link, "SELECT email FROM users WHERE email = '$email'");
      if (mysqli_num_rows($result) > 0) {
         $error[] = "email занят!";
      }
   }

   if (count($error)) {
      echo implode('<br />', $error);
   } else {

      $pass   = sha1($pass);
      $pass   = strrev($pass); //переварачиваем пароль
      $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";

      $ip = $_SERVER['REMOTE_ADDR'];

      mysqli_query($link, "	INSERT INTO users(login,pass,surname,name,patronymic,email,datetime,ip)
						VALUES(
						
							'" . $login . "',
							'" . $pass . "',
							'" . $surname . "',
							'" . $name . "',
							'" . $patronymic . "',
                            '" . $email . "',
                            NOW(),
                            '" . $ip . "'							
						)");
      echo 'true';
   }
}
