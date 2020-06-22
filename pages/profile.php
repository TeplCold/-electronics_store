<link rel="stylesheet" type="text/css" href="../style/profile/profile.css">
<?php session_start();
include("db_connect.php");
include("reg_aunt/functions.php");

if ($_SESSION['auth'] == 'yes_auth') //выводим эту страницу только когда пользователь зарегистрирован
{


    if ($_POST["save_submit"]) {

        $surname  = clear_string($_POST['info_surname']);
        $surname  = mysqli_real_escape_string($link, $surname); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
        $surname  = mb_strtolower($surname, 'UTF-8'); //Приведение строки к нижнему регистру
        $_POST["info_surname"] = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

        $name   = clear_string($_POST['info_name']);
        $name   = mysqli_real_escape_string($link, $name); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
        $name   = mb_strtolower($name, 'UTF-8'); //Приведение строки к нижнему регистру
        $_POST["info_name"] = mb_convert_case($name, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

        $patronymic   = clear_string($_POST['info_patronymic']);
        $patronymic   = mysqli_real_escape_string($link, $patronymic); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
        $patronymic   = mb_strtolower($patronymic, 'UTF-8'); //Приведение строки к нижнему регистру
        $_POST["info_patronymic"] = mb_convert_case($patronymic, MB_CASE_TITLE, "UTF-8"); //Преобразует первый символ строки в верхний регистр

        $email  = clear_string($_POST['info_email']); //подключаем функцию очистки строк
        $email  = mb_strtolower($email, 'UTF-8'); //Приведение строки к нижнему регистру
        $_POST["info_email"]  = mysqli_real_escape_string($link, $email); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

        $error = array();

        //помешаем в  $pass  глобальный массив $_POST и reg_pass  - поле куда вводим пароль
        $pass  = clear_string($_POST['info_pass']); //подключаем функцию очистки строк
        $pass = mysqli_real_escape_string($link, $pass); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
        $pass   = sha1($pass); //шифруем пароль
        $pass   = strrev($pass); //переварачиваем пароль
        $pass   = "9nm2rv8q" . $pass . "2yotykytk6z";

        if ($_SESSION['auth_pass'] != $pass) {
            $error[] = 'Неверный текущий пароль!';
        } else {

            if ($_POST["info_new_pass"] != "") {
                if (strlen($_POST["info_new_pass"]) < 7 || strlen($_POST["info_new_pass"]) > 20) {
                    $error[] = 'Укажите новый пароль от 7 до 20 символов!';
                } else {

                    $newpass  = clear_string($_POST['info_new_pass']); //подключаем функцию очистки строк
                    $newpass  = mb_strtolower($newpass, 'UTF-8'); //Приведение строки к нижнему регистру
                    $newpass =  mysqli_real_escape_string($link,  $newpass); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.
                    $newpass    = sha1($newpass); //шифруем пароль
                    $newpass    = strrev($newpass); //переварачиваем пароль
                    $newpass    = "9nm2rv8q" .   $newpass  . "2yotykytk6z";
                    $newpassquery = "pass='" . $newpass . "',";
                }
            }

            if ($_POST["info_email"] != "") {
                if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($_POST["info_email"]))) $error[] = "Укажите корректный email!";
                else {
                    $result =  mysqli_query($link, "SELECT email FROM users WHERE email = '$email'");
                    if ($_POST["info_email"] != $_SESSION['auth_email']) {
                        if (mysqli_num_rows($result) > 0) {
                            $error[] = "email занят!";
                        }
                    }
                }
            }

            if (strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"]) > 20) {
                $error[] = 'Укажите фамилию от 3 до 20 символов!';
            }

            if (strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"]) > 15) {
                $error[] = 'Укажите имя от 3 до 15 символов!';
            }

            if (strlen($_POST["info_patronymic"]) < 3 || strlen($_POST["info_patronymic"]) > 25) {
                $error[] = 'Укажите отчество от 3 до 25 символов!';
            }
        }

        if (count($error)) {
            $_SESSION['msg'] = "<p id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            $_SESSION['msg'] = "<p id='form-success'>Данные успешно сохранены!</p>";

            $dataquery = $newpassquery . "surname='" . $_POST["info_surname"] . "',name='" . $_POST["info_name"] . "',patronymic='" . $_POST["info_patronymic"] . "',email='" . $_POST["info_email"] . "'"; //phone='" . $_POST["info_phone"] . "',address='" . $_POST["info_address"] 
            $update = mysqli_query($link, "UPDATE users SET $dataquery WHERE login = '{$_SESSION['auth_login']}'");

            if ($newpass) {
                $_SESSION['auth_pass'] = $newpass;
            }
            $_SESSION['auth_surname'] = $_POST["info_surname"];
            $_SESSION['auth_name'] = $_POST["info_name"];
            $_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
            $_SESSION['auth_email'] = $_POST["info_email"];
        }
    }
?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>

        <title>Профиль</title>
        <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    </head>

    <body id="particles-js">

        <div class="fon">
            <?php include("header_footer/header.php") ?>

            <div class="containerglavn">
                <div class="blockglavn">
                    <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
                    <div class="inetshop"> Профиль</div>
                </div>
            </div>
            <?php

            if ($_SESSION['msg']) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            ?>
            <div class="container content">
                <form method="post">

                    <ul id="info-profile">

                        <li class="info-profile">
                            <div><label for="info_surname">Фамилия</label></div>
                            <div><input type="text" name="info_surname" id="info_surname" placeholder="Фамилия" value="<?php echo $_SESSION['auth_surname']; ?>" /></div>
                        </li>

                        <li class="info-profile">
                            <div><label for="info_name">Имя</label></div>
                            <div> <input type="text" name="info_name" id="info_name" value="<?php echo $_SESSION['auth_name']; ?>" /></div>
                        </li>

                        <li class="info-profile">
                            <div><label for="info_patronymic">Отчество</label></div>
                            <div><input type="text" name="info_patronymic" id="info_patronymic" value="<?php echo $_SESSION['auth_patronymic']; ?>" /></div>
                        </li>

                        <li class="info-profile">
                            <div> <label for="info_email">E-mail</label></div>
                            <div> <input type="text" name="info_email" id="info_email" value="<?php echo $_SESSION['auth_email']; ?>" /></div>
                        </li>

                        <li class="info-profile">
                            <div><label for="info_new_pass">Новый пароль</label></div>
                            <div> <input type="text" name="info_new_pass" id="info_new_pass" value="" /> <span id="genpass2">Сгенерировать</span></div>

                        </li>

                        <li class="info-profile">
                            <div> <label for="info_pass">Введите текущий пароль для подтверждения</label></div>
                            <div><input type="text" name="info_pass" id="info_pass" value="" />
                                <input type="submit" class="info_pass" id="form_submit" name="save_submit" value="Сохранить" />
                            </div>
                        </li>

                    </ul>


                </form>
            </div>
            <?php include("header_footer/footer.php") ?>

            <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
            <script defer type="text/javascript" src="../javascript/cart.js"></script>
            <script defer type="text/javascript" src="../javascript/header_footer.js"></script>
            <!--подключение генерации пароля -->
            <script defer type="text/javascript" src="../javascript/reg_aunt/genpass.js"></script>

            <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
            <script defer src="../bootstrap/js/bootstrap.min.js"></script>

    </body>

    </html>

<?php } else {
    header(("Location: ../index.php"));
} ?>