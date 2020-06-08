<?php
$host = 'localhost'; //адрес сервера 
$database = 'electronics_store'; //имя базы данных
$user = 'root'; //имя пользователя
$password = ''; //пароль

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL.";
    echo "Код ошибки errno: " . mysqli_connect_errno();
    echo "Текст ошибки error: " . mysqli_connect_error();
}
