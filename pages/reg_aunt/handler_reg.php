<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   session_start();

   error_reporting(E_ALL);
   ini_set('display_errors', 1);

   include("../db_connect.php");
   include("functions.php");

   $error = array();

   //помешаем в login глобальный массив $_POST и reg_login - поле куда вводим логин
   $login  = clear_string($_POST['reg_login']); //подключаем функцию очистки строк
   $login  = mb_strtolower($login, 'UTF-8'); //Приведение строки к нижнему регистру
   $login = mysqli_real_escape_string($link, $login); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
   //помешаем в  $pass  глобальный массив $_POST и reg_pass  - поле куда вводим пароль
   $pass  = clear_string($_POST['reg_pass']); //подключаем функцию очистки строк
   $pass = mysqli_real_escape_string($link, $pass); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

   $surname  = clear_string($_POST['reg_surname']);
   $surname  = mysqli_real_escape_string($link, $surname); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
   $surname  = mb_strtolower($surname, 'UTF-8'); //Приведение строки к нижнему регистру
   $surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

   $name   = clear_string($_POST['reg_surname']);
   $name   = mysqli_real_escape_string($link, $name); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
   $name   = mb_strtolower($name, 'UTF-8'); //Приведение строки к нижнему регистру
   $name  = mb_convert_case($name, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

   $patronymic   = clear_string($_POST['reg_surname']);
   $patronymic   = mysqli_real_escape_string($link, $patronymic); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
   $patronymic   = mb_strtolower($patronymic, 'UTF-8'); //Приведение строки к нижнему регистру
   $patronymic  = mb_convert_case($patronymic, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

   $email  = clear_string($_POST['reg_email']); //подключаем функцию очистки строк
   $email  = mb_strtolower($email, 'UTF-8'); //Приведение строки к нижнему регистру
   $email = mysqli_real_escape_string($link, $email); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

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
