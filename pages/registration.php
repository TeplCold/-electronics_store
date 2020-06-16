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
                    <div class="inetshop"> Вход и регистрация</div>
                    <div class="glavnplus"> Здесь Вы можете зарегистрироваться и участвовать в обсуждении материалов сайта, а так же ознакомится с правилами нашего интернет-магазина</div>
                </div>
            </div>

            <div class="container-fluid fluid st">

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog " aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Востановление пароля</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>

                                    <input type="text" id="remind-email" placeholder="Введите Ваш E-mail" />
                                </div>
                                <h6 id="message-remind" class="message-remind-success"></h6>
                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <p id="prev-auth">Назад</p>
                                </button>


                                <button type="button" class="btn btn-primary">
                                    <p id="button-remind"><a>Готово</a></p>
                                    <p class="a-loading"><img src="../assets/reg_aunt/loading.gif"></p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="cont_login">

                    <div class="cont_info_log_sign_up">

                        <div class="col_md_login">

                            <div class="cont_ba_opcitiy">

                                <h2 class="font">Войти</h2>

                                <p>У вас уже есть логин?</p>

                                <button class="btn_login grow" onclick="cambiar_login()">Войти</button>

                            </div>

                        </div>

                        <div class="col_md_sign_up">

                            <div class="cont_ba_opcitiy">

                                <h2 class="font ">Регистрация </h2>

                                <p>Нет логина?</p>

                                <button class="btn_sign_up grow" onclick="cambiar_sign_up()">Зарегистрироваться</button>

                            </div>

                        </div>

                    </div>

                    <div class="cont_back_info">

                        <div class="cont_img_back_grey">

                            <img src="../assets/bg.jpg" alt="" />

                        </div>

                    </div>

                    <div class="cont_forms">

                        <div class="cont_img_back_">

                            <img src="../assets/bg.jpg" alt="" />

                        </div>


                        <div class="cont_form_login">

                            <a onclick="ocultar_login_sign_up()">

                                <button class="rgba" type="button">&#10060;</button>

                            </a>

                            <form method="post">
                                <div id="imput-email-pass">
                                    <p id="message-auth">Неверный логин или пароль</p>
                                    <h2 class="font ">Войти</h2>

                                    <input required type="text" name="auth_login" id="auth_login" placeholder="Логин или Email" />
                                    <div>
                                        <input required type="password" name="auth_pass" id="auth_pass" placeholder="Пароль">
                                        <span id="button-pass-show-hide" class="pass-show"></span>
                                    </div>
                                    <div id="auth-loading">
                                        <input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme">Запомнить меня</label></input>
                                        <input readonly class="btn_login " id="button-auth" value="Вход"></input>
                                        <input class="auth-loading" id="button-auth"> <img src="../assets/reg_aunt/loading.gif"> </input>
                                    </div>
                                    <div id="list-auth"></div>
                                    <button class=" remindpass" data-toggle="modal" data-target="#staticBackdrop">
                                        <div id="remindpass">Забыли пароль? </div>
                                    </button>
                                </div>
                            </form>
                        </div>







                        <div class="cont_form_sign_up">

                            <a onclick="ocultar_login_sign_up()">

                                <button class="rgba" type="button">&#10060;</button>

                            </a>

                            <form method="post" id="form_reg" action="reg_aunt/handler_reg.php">
                                <h2 class="font">Регистрация</h2>
                                <p id="reg_message"></p>

                                <input required type="text" name="reg_surname" id="reg_surname" placeholder="Фамилия">

                                <input required type="text" name="reg_name" id="reg_name" placeholder="Имя">
                                <input required type="text" name="reg_patronymic" id="reg_patronymic" placeholder="Отчество">
                                <input required type="text" name="reg_email" id="reg_email" placeholder="E-mail">

                                <input required type="text" name="reg_login" id="reg_login" placeholder="Логин">

                                <input required type="text" name="reg_pass" id="reg_pass" placeholder="Пароль">
                                <div id="genpass">Сгенерировать</div>

                                <input class="btn_sign_up" type="submit" name="reg_submit" id="form_submit" value="Зарегистрироваться">

                            </form>

                        </div>

                    </div>

                </div>

            </div>


            <div class="pravmargin">

                <div id="pravmargin">

                    <h2 class="pravila ">Правила </h2>

                    <div class="caption"> Порядок поведения на сайте. </div>

                    <div class="w-100"></div>

                    <div class="txt">

                        1. Общение на сайте строится на принципах общепринятой морали и сетевого этикета.

                        <div class="w-100"></div>

                        2. Строго запрещено использование нецензурных слов, брани, оскорбительных выражений, в независимости от того, в каком виде
                        и кому они были адресованы. В том числе при подмене букв символами.

                        <div class="w-100"></div>

                        3. Категорически запрещается любая реклама, в том числе реклама интернет-проектов (за исключением случаев когда внешние ссылки
                        касаются темы обсуждения и без них никак не обойтись). Модераторы могут удалить / отредактировать сообщение без
                        уведомления автора. Остальные ссылки публикуются после предварительного согласования с администрацией.

                    </div>

                    <div class="caption ">

                        Комментарии и сообщения.

                    </div>

                    <div class="txt">

                        1. Содержание комментариев должно быть информативным, максимально четко отражая смысл проблемы.

                        <div class="w-100"></div>

                        2. Перед добавлением комментария убедитесь, что вы создаете ее в соответствующей тематике, а также постарайтесь убедиться
                        в том, что данный комментарий не обсуждался ранее.

                        <div class="w-100"></div>

                        3. Запрещено создание одинаковых по смыслу сообщений.

                        <div class="w-100"></div>

                        4. Старайтесь не делать грамматических ошибок в сообщениях – это создаст негативное впечатление о вас.

                    </div>

                    <div class="caption">

                        Отношения между пользователями и администрацией.

                    </div>

                    <div class="txt">

                        1. В своих действиях администрация форума руководствуется здравым смыслом и внутренними правилами управления сайтом.

                        <div class="w-100"></div>

                        2. Обсуждение действий администрации (администраторов и модераторов) категорически запрещается .

                        <div class="w-100 "></div>

                        Администрация оставляет за собой право изменять правила с последующим уведомлением об этом пользователей форума. Все изменения
                        и новации на сайте производятся с учетом мнений и интересов пользователей.

                    </div>
                </div>
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
        <script defer src="../javascript/reg.js"></script>

    </body>

    </html>

<?php } elseif ($_SESSION['auth_login'] == 'admin') {
    header(("Location: ../admin_control_panel/admin_control_panel.php"));
} else {
    header(("Location: ../index.php"));
} ?>