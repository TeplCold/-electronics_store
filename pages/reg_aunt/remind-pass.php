<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../db_connect.php");
    include("functions.php");

    $email = clear_string($_POST["email"]);

    if ($email != "") {

        $result = mysqli_query($link, "SELECT email FROM users WHERE email='$email'");
        if (mysqli_num_rows($result) > 0) {

            //Генерация пароля
            $newpass = fungenpass();

            //Шифрования пароля
            $pass   = sha1($pass);
            $pass   = strrev($pass); //переварачиваем пароль
            $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";

            // Обнавления паролья на новый
            $update = mysqli_query($link, "UPDATE users SET pass='$pass' WHERE email='$email'");


            // Отправка нового пароля

            send_mail(
                'teplcold@gmail.com',
                $email,
                'Новый пароль для сайта',
                'Ваш пароль: ' . $newpass
            );

            echo 'yes';
        } else {
            echo 'Данный E-mail не найден!';
        }
    } else {
        echo '������� ���� E-mail';
    }
}
