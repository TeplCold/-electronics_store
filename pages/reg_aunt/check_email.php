<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") //проверяем как обратились к файлу если методом POST то:
{
   include("db_connect.php"); //подключение к бд 
   include("functions.php");  //функция очистки строк 

   $email = clear_string($_POST['reg_email']); //помешаем в email глобальный массив $_POST и reg_email - поле куда вводим email
   $result =  mysqli_query($link, "SELECT email FROM users WHERE email = '$email'"); //отправляем в БД запрос
   if (mysqli_num_rows($result) > 0) // если есть email то возвращаем:
   {
      echo 'false'; // лож (email существует)
   } else {
      echo 'true'; //(email не существует)
   }
}
