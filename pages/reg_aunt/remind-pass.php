<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../db_connect.php");
    include("functions.php");

    $email  = clear_string($_POST['email']); //подключаем функцию очистки строк
    $email  = mb_strtolower($email, 'UTF-8'); //Приведение строки к нижнему регистру
    $email =  mysqli_real_escape_string($link, $email); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    if ($email != "") {

        $result = mysqli_query($link, "SELECT email FROM users WHERE email='$email'");
        if (mysqli_num_rows($result) > 0) {

            //Генерация пароля
            $newpass = fungenpass();

            //Шифрования пароля
            $pass   = sha1($newpass); //шифруем пароль
            $pass   = strrev($pass); //переварачиваем пароль
            $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";
            // Обнавления паролья на новый
            $update = mysqli_query($link, "UPDATE users SET pass='$pass' WHERE email='$email'");


            // Отправка нового пароля

            send_mail(
                'george.tepl@bk.ru',
                $email,
                'Новый пароль для сайта',
                'Ваш пароль: ' . $newpass
            );
            echo 'yes';
        } else {
            echo 'Данный E-mail не найден!';
        }
    }
}
