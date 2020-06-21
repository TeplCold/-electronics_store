<?php
include("db_connect.php");
include("reg_aunt/functions.php");
include("reg_aunt/auth_cooke.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>

    <title>О нас </title>
    <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">

    <link rel="stylesheet" href="../style/about_us/about_us.css">

</head>

<body>

    <div class="fon">
        <?php include("header_footer/header.php") ?>

        <div class="containerglavn">
            <div class="blockglavn">
                <div class="SPASE_ELECTRONICS"> SPASE ELECTRONICS</div>
                <div class="inetshop">Немного о нас</div>

            </div>
        </div>

        <div class="container text-white container_content">
            <div class="contenttxtimg">
                <div class="contenttxt">
                    <p class="center">Вас приветствует коллектив компании "SPASE_ELECTRONICS"!</p>
                    <p>Компания «SPASE_ELECTRONICS» является интернет-магазином, ориентированная на розничную и мелкооптовую торговлю. На сегодняшний день мы — относительно молодая, но стремительно развивающаяся компания, работаем на российском рынке с 2020 года.</p>

                    <p> Мы обладаем всеми необходимыми ресурсами, в том числе высококвалифицированными, креативными, энергичными сотрудниками, которые помогают покупателям воспользоваться всеми преимуществами товаров ведущих брендов, опираясь на собственный опыт и лучшие розничные технологии.</p>

                    <p> Весь предлагаемый нами товар сертифицирован в России, подтверждающую соответствие российским стандартам. На купленную в нашем интернет-магазине технику распространяется гарантия производителя до 60 месяцев в зависимости от конкретной модели. Все товары комплектуются инструкцией по эксплуатации и фирменным гарантийным талоном производителя.</p>


                    <p>Мы ценим ваше время - поэтому каждый день стараемся сделать покупки в магазине «SPASE_ELECTRONICS» как можно быстрей и легче. Наша компания поможет Вам сделать правильный выбор и создать собственный яркий и комфортный мир, наполненный качественной техникой лучших мировых брендов.</p>


                    <div class="preem">
                        <div>Преимущества покупки техники в интернет-магазине «SPASE_ELECTRONICS»:</div>

                        <div>✓ Вы получаете профессиональную консультацию по телефону</div>
                        <div>✓ Оформляете заказ, не выходя из дома в любое время дня и ночи</div>
                        <div>✓ Оплачиваете заказ по факту доставки</div>
                        <div>✓ Возможность самовывоза в день заказа</div>
                    </div>
                </div>
                <div class="imgcontent"><img src="../assets/23-2147923607.jpg"></div>
            </div>





            <div class="infocicontent">
                <div>
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aacf9a04ae20bc1f88b6ce77dad94123a491a4ccd04c2d3fc7156f946f7d44f08&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
                </div>
                <div class="infocicontenttxt">
                    <p class="raspolo none">Где мы расположены</p>
                    <p>Россия, Ижевск, Студенческая ул., 7, Ижевск, Россия</p>
                    <p class="raspolo botom">Как выйти с нами на связь</p>
                    <p> ✓ По редакционным вопросам ✓</p>
                    <p>Teplcold@gmail.com 📧</p>
                    <p>✓ По вопросам рекламы ✓</p>
                    <p>Teplcold@gmail.com 📧</p>
                    <p>✓ Главный e-mail ✓</p>
                    <p>Teplcold@gmail.com 📧</p>
                    <p>Телефоны</p>
                    <p>89500009990 - Позвонить ✆</p>
                    <p>(техподдержка)</p>
                </div>
            </div>

            <div class="container-fluid text-center mt-xl-4 mt-lg-0 mt-md-4 mt-sm-4 mt-3 p-xl-4 p-lg-2 p-md-2  p-0 employes wow bounceINRight "
                    data-wow-offset="200">

                    <div class="txt-employes"> Список сотрудников </div>

                    <div class="name-employes"> SPASE_ELECTRONICS</div>

                    <div class="w-100 p-xl-3 p-lg-3 p-md-2 p-sm-2 p-1"></div>

                    <img src="../assets/administrator.jpg" class="rounded-circle img_employes grow">

                    <div class="w-100 p-xl-2 p-lg-2 p-md-2 p-sm-1 p-0"></div>

                    <div class="swing">

                        <div class="position">АДМИНИСТРАТОР</div>

                        <div class="FI">Тепляков Георгий</div>

                    </div>

                </div>
        </div>



    </div>
    <?php include("header_footer/footer.php") ?>

    <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
    <script defer type="text/javascript" src="../javascript/cart.js"></script>
    <script defer type="text/javascript" src="../javascript/header_footer.js"></script>

    <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
    <script defer src="../bootstrap/js/bootstrap.min.js"></script>

    <script defer type="text/javascript" src="../javascript/scrollup.js"></script>
    <a href="#" class="scrollup">Наверх</a>

</body>

</html>