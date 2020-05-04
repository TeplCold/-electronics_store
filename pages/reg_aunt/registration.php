<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Вход/Регистрация</title>
    <link rel="shortcut icon" href="../../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script type="text/javascript" src="../../javascript/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../javascript/jquery.form.js"></script>
    <script type="text/javascript" src="../../javascript/jquery.validate.js"></script>
    <script type="text/javascript" src="../../javascript/reg_aunt/reg_validation.js"></script>

    <script defer type="text/javascript" src="../../javascript/reg_aunt/genpass.js"></script>
    <!-- подключение авторизации -->
    <script defer type="text/javascript" src="../../javascript/reg_aunt/view_pass.js"></script>
    <link href="../../style/reg_aunt/authentication.css" rel="stylesheet">
    <!-- ------- -->

<body>

    <?php include("../header_footer/header.php") ?>

    <!-- Аторизация  -->
    <div id="block-body">
        <div id="block-top-auth">
            <form method="post"> 
            <div id="imput-email-pass">

                <p id="message-auth">Неверный логин или пароль</p>

                <div><input type="text" name="auth_login" id="auth_login" placeholder="Логин или Email" /> </div>

                <div>
                    <input type="password" name="auth_pass" id="auth_pass" placeholder="Пароль">
                    <span id="button-pass-show-hide" class="pass-show"></span>
                </div>

                <div id="list-auth">
                    <div><input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme">Запомнить меня</label> </div>
                    <div><a id="remindpass" href="#">Забыли пароль?</a></div>
                </div>
                <div id="button-auth"><a>Вход</a></div>
                <div class="auth-loading"><img src="../../assets/reg_aunt/loading.gif"></div>

            </div>
            </form>

            <div id="block-remind">
                <h3>Востановление пароля</h3>
                <p id="message-remind" class="message-remind-success"></p>
                <input type="text" id="remind-email" placeholder="Ваш E-mail" />
                <p id="button-remind"><a>Готово</a></p>
                <p class="auth-loading"><img src="../../assets/reg_aunt/loading.gif"></p>
                <p id="prev-auth">Назад</p>
            </div>


        </div>
    </div>

    <!-- Регистрация -->
    <div id="block-content">
        <form method="post" id="form_reg" action="handler_reg.php">
            <p id="reg_message"></p>
            <div id="block-form-registration">
                <div id="form-registration">

                    <div>
                        <label>Логин</label>
                        <input type="text" name="reg_login" id="reg_login" />
                    </div>

                    <div>
                        <label>Пароль</label>
                        <input type="text" name="reg_pass" id="reg_pass" />
                        <span id="genpass">Сгенерировать</span>
                    </div>

                    <div>
                        <label>Фамилия</label>
                        <input type="text" name="reg_surname" id="reg_surname" />
                    </div>

                    <div>
                        <label>Имя</label>
                        <input type="text" name="reg_name" id="reg_name" />
                    </div>

                    <div>
                        <label>Отчество</label>
                        <input type="text" name="reg_patronymic" id="reg_patronymic" />
                    </div>

                    <div>
                        <label>E-mail</label>
                        <input type="text" name="reg_email" id="reg_email" />
                    </div>

                </div>
            </div>
            <input type="submit" name="reg_submit" id="form_submit" value="Зарегистрироваться" />
        </form>
    </div>

</body>

</html>