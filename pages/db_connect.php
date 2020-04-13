<?php
$host = 'localhost'; // адрес сервера 
$database = 'electronics_store'; // имя базы данных
$user = 'root'; // имя пользователя
$password = ''; // пароль

$link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка" . mysqli_error($link));
