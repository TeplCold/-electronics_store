<?php
session_start();

if ($_SESSION['auth'] != 'yes_auth') { //выводим эту страницу только когда пользователь не авторизирован
    include("db_connect.php");
    include("reg_aunt/functions.php");
    include("reg_aunt/auth_cooke.php");
?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>

        <title>Вход/Регистрация</title>
        <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

        <!---------------------------------------------------------------------------->
        <link rel="stylesheet" type="text/css" href="../style/reg_aunt/authentication.css">

    </head>

    <body>
        <div class="fon">
            <?php include("header_footer/header.php") ?>

            <div class="containerglavn">
                <div class="blockglavn">
                    <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
                    <div class="inetshop"> Интернет магазин</div>
                    <div class="glavnplus"> SPASE ELECTRONICS - небольшой, но динамично развивающийся интернет-магазин. Это позволяет нам более внимательно относиться к потребностям и желаниям наших покупателей. Индивидуальный подход, подробные консультации, широкий ассортимент электроники, цифровой и бытовой техники. Ассортимент постоянно расширяется. Интернет-магазин SPASE ELECTRONICS - это возможность сделать покупки оптом и в розницу.</div>
                    <div class="join"> Приятных покупок!</div>
                </div>
            </div>

            <!-- Аторизация  -->
            <div id="block-body">
                <?php
                if ($_SESSION['auth'] == 'yes_auth') {
                    echo 'Вы успешно вошли под учетной записью - ' . $_SESSION['auth_name'];
                }
                ?>
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
                            <div class="auth-loading"><img src="../assets/reg_aunt/loading.gif"></div>
                        </div>
                    </form>

                    <div id="block-remind">
                        <h3>Востановление пароля</h3>
                        <p id="message-remind" class="message-remind-success"></p>
                        <input type="text" id="remind-email" placeholder="Ваш E-mail" />
                        <p id="button-remind"><a>Готово</a></p>
                        <p class="auth-loading"><img src="../assets/reg_aunt/loading.gif"></p>
                        <p id="prev-auth">Назад</p>
                    </div>
                </div>
            </div>

            <!-- Регистрация -->
            <div id="block-content">
                <form method="post" id="form_reg" action="reg_aunt/handler_reg.php">
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
        </div>

        <?php include("header_footer/footer.php") ?>
        <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
        <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
        <script defer type="text/javascript" src="../javascript/jquery.form.js"></script>
        <script defer type="text/javascript" src="../javascript/jquery.validate.js"></script>
        <script defer type="text/javascript" src="../javascript/reg_aunt/reg_validation.js"></script>
        <!--подключение генерации пароля -->
        <script defer type="text/javascript" src="../javascript/reg_aunt/genpass.js"></script>
        <!-- подключение авторизации -->
        <script defer type="text/javascript" src="../javascript/reg_aunt/view_pass.js"></script>
        <script defer type="text/javascript" src="../javascript/reg_aunt/aut.js"></script>
        <script defer type="text/javascript" src="../javascript/reg_aunt/recover_pass.js"></script>
        <script defer type="text/javascript" src="../javascript/cart.js"></script>
        <script defer type="text/javascript" src="../javascript/header_footer.js"></script>

    </body>

    </html>

<?php } elseif ($_SESSION['auth_login'] == 'admin') {
    header(("Location: ../admin_control_panel/admin_control_panel.php"));
} else {
    header(("Location: ../index.php"));
} ?>