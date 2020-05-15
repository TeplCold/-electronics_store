<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   session_start();
   include("../db_connect.php");
   include("functions.php");

   $error = array();

   $login = mb_strtolower(mysqli_real_escape_string($link, clear_string($_POST['reg_login'], 'utf-8')));
   $pass = mb_strtolower(mysqli_real_escape_string($link, clear_string($_POST['reg_pass'], 'utf-8')));

   $surname = mysqli_real_escape_string($link, clear_string($_POST['reg_surname']));
   $name = mysqli_real_escape_string($link, clear_string($_POST['reg_name']));
   $patronymic = mysqli_real_escape_string($link, clear_string($_POST['reg_patronymic']));
   $email = mysqli_real_escape_string($link, clear_string($_POST['reg_email']));

   if (mb_strlen($login, 'utf-8') < 5 or mb_strlen($login, 'utf-8') > 15) {
      $error[] = "Логин должен быть от 5 до 15 символов!";
   } else {
      $result =  mysqli_query($link, "SELECT login FROM users WHERE login = '$login'");
      if (mysqli_num_rows($result) > 0) {
         $error[] = "Логин занят!";
      }
   }

   if (mb_strlen($pass, 'utf-8') < 7 or mb_strlen($pass, 'utf-8') > 15) $error[] = "Укажите пароль от 7 до 20 симвлолв!";
   if (mb_strlen($surname, 'utf-8') < 3 or mb_strlen($surname, 'utf-8') > 20) $error[] = "Укажите фамилию от 3 до 20 символов!";
   if (mb_strlen($name, 'utf-8') < 3 or mb_strlen($name, 'utf-8') > 15) $error[] = "Укажите имя 3 от 15 символов!";
   if (mb_strlen($patronymic, 'utf-8') < 3 or mb_strlen($patronymic, 'utf-8') > 25) $error[] = "Укажите отчество от 3 до 25 символов!";


   //preg_match сверяет веденные данные с шаблоном
   //trim удаляет пробелы в начале и в конце
   if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "Укажите корректный email!";
   else {
      $result =  mysqli_query($link, "SELECT email FROM users WHERE email = '$email'");
      if (mysqli_num_rows($result) > 0) {
         $error[] = "email занят!";
      }
   }

   if (count($error)) {
      echo implode('<br />', $error);
   } else {



      $pass   = sha1($pass); //шифруем пароль
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
