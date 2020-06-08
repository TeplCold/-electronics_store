<?php
if ($_SESSION['auth'] != 'yes_auth' && $_COOKIE["rememberme"]) { //ксли пользователь не авторизирован и куки не существуют то

    $str = $_COOKIE["rememberme"]; // принимаем значение rememberme в str
    $all_len = strlen($str); // определяем всю длину строки
    $login_len = strpos($str, '+'); // длина строки логина
    $login = clear_string(substr($str, 0, $login_len));  // обрезаем строку до + и получаем логин
    $pass = clear_string(substr($str, $login_len + 1, $all_len)); // получаем пароль 

    $result = mysqli_query($link, "SELECT * FROM users WHERE (login = '$login' OR email = '$login')AND pass = '$pass'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        session_start();
        $_SESSION['auth'] = 'yes_auth'; //добавляем в сесию то что пользователь авторизирован
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_pass'] = $row["pass"]; // в сессию сохраняем пароль пользователя
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_email'] = $row["email"];
    }
}
