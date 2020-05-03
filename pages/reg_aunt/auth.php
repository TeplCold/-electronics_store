<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") //проверяем как обратились к файлу
{
    include("../db_connect.php"); //подключение к бд 
    include("functions.php"); //подключаем фукцию очистки сторк 

    $login = clear_string($_POST["login"]); //помешаем в login глобальный массив $_POST и reg_login - поле куда вводим логин

    $pass   = sha1(clear_string($_POST["pass"]));
    $pass   = strrev($pass); //переварачиваем пароль
    $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";

    if ($_POST["rememberme"] == "yes") //если выбран чекбокс 
    {
        setcookie('rememberme', $login . '+' . $pass, time() + 3600 * 24 * 31, "/");
    }

    $result = mysqli_query($link, "SELECT * FROM users WHERE (login = '$login' OR email = '$login')AND pass = '$pass'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $_SESSION['auth'] = 'yes_auth'; //добавляем в сесию то что пользователь авторизирован
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_pass'] = $row["pass"]; // в сессию сохраняем пароль пользователя
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_email'] = $row["email"];
        echo 'yes_auth'; //ответ ajax 
    } else {
        echo 'no_auth';
    }
}
