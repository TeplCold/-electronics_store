<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") //проверяем как обратились к файлу
{
   include("../db_connect.php"); //подключение к бд 
   include("functions.php");  //функция очистки строк 

   $login = clear_string($_POST['reg_login']); //помешаем в login глобальный массив $_POST и reg_login - поле куда вводим логин
   $result =  mysqli_query($link, "SELECT login FROM users WHERE login = '$login'"); //отправляем в БД запрос
   if (mysqli_num_rows($result) > 0) // если есть логин то возвращаем:
   {
      echo 'false'; // лож (логин существует)
   } else {
      echo 'true'; //(логин не существует)
   }
}
?>