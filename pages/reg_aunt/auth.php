<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") //проверяем как обратились к файлу
{
    include("../db_connect.php"); //подключение к бд 
    include("functions.php"); //подключаем фукцию очистки сторк 

    //помешаем в login глобальный массив $_POST и reg_login - поле куда вводим логин
    $login  = clear_string($_POST['login']); //подключаем функцию очистки строк
    $login  = mb_strtolower($login, 'UTF-8'); //Приведение строки к нижнему регистру
    $login = mysqli_real_escape_string($link, $login); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    // echo $login . '||';

    //помешаем в  $pass  глобальный массив $_POST и reg_pass  - поле куда вводим пароль
    $pass  = clear_string($_POST['pass']); //подключаем функцию очистки строк
    $pass = mysqli_real_escape_string($link, $pass); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
    $pass   = sha1($pass); //шифруем пароль
    $pass   = strrev($pass); //переварачиваем пароль
    $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";
    //echo $pass; //ответ ajax 

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
