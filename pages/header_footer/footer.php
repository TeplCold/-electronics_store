<?php

if ($_POST["send_message"]) {
    $error = array();

    if (!$_POST["feed_name"]) $error[] = "Укажите имя";

    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($_POST["feed_email"]))) {
        $error[] = "Укажите корректный E-mail";
    }

    if (!$_POST["feed_text"]) $error[] = "Укажите текст сообщения!";


    if (count($error)) {
        $_SESSION['message'] = "<p id='form-error'>" . implode(', ', $error) . "</p>";
    } else {
        send_mail(
            'george.tepl@bk.ru',
            $_POST["feed_email"],
            'обратная связь',
            'От: ' . $_POST["feed_name"] . '<br />' . $_POST["feed_text"]
        );
        $_SESSION['message'] = "<p id='form-success'>Ваше сообщение успешно отправленно!</p>";
    }
}
?>

<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>


<div id="block-content_footer">
    <div class="container block-content_footer">
        <div class="social_network">
            <div class="footerimg"><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> <img src="../../assets/images.png" /></a></div>
            <div class="containerzagolovokcontacts">
                <div class="zagolovokcontactssocial"> Мы в социальных сетях</div>
                <a href="#"><img class="social_network_img" src="../../assets/1.png" /></a>
                <a href="#"><img class="social_network_img" src="../../assets/2.png" /></a>
                <a href="#"><img class="social_network_img" src="../../assets/4.png" /></a>
                <a href="#"><img class="social_network_img" src="../../assets/5.png" /></a>
            </div>
            <div class="containerzagolovokcontacts">
                <div class="zagolovokcontactssocial"> Мы принимаем к оплате</div>
                <img class="social_network_img" src="../../assets/card1.png" />
                <img class="social_network_img" src="../../assets/card2.png" />
                <img class="social_network_img" src="../../assets/card3.png" />
                <img class="social_network_img" src="../../assets/card4.png" />
            </div>
        </div>

        <div class="razdel">
            <div class="zagolovokfooter"> Разделы </div>
            <div class="containerrazdel">
                <div class="containerrazdelmargin"> <a class="" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> Главная</a></div>
                <div class="containerrazdelmargin"> <a class="" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/product_list.php"> Каталог</a></div>
                <div class="containerrazdelmargin"> <a class="" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/about_us.php"> О нас</a></div>
                <div class="containerrazdelmargin"> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick">Корзина</a></div>
            </div>
        </div>

        <div class="contacts">
            <div class="zagolovokfooter"> Контакты </div>
            <div class="blockcontacts">
                <div class="zagolovokcontacts"> Email </div>
                <div class="contentcontacts"> teplcold@gmail.com </div>
            </div>
            <div class="blockcontacts">
                <div class="zagolovokcontacts"> Номер телефона </div>
                <div class="contentcontacts"> 8-951-219-00-00 </div>
            </div>
            <div class="blockcontacts">
                <div class="zagolovokcontacts"> Адрес </div>
                <div class="contentcontacts"> г. Ижевск, ул. Студенческая, 42</div>
            </div>
        </div>

        <div class="obrfrrdback">
            <div class="zagolovokfooter"> Обратная связь</div>
            <form method="post">
                <div id="block-feedback">
                    <ul id="feedback">
                        <li><input class="feed_name" placeholder="Ваше имя" type="text" name="feed_name" /></li>
                        <li><input class="feed_email" placeholder="Ваш E-mail" type="text" name="feed_email" /></li>
                        <li><textarea class="feed_text" placeholder="Текст сообщения" name="feed_text"></textarea></li>
                    </ul>
                </div>
                <div class="form_submit"> <input type="submit" name="send_message" id="form_submit"></div>
            </form>
        </div>
    </div>
</div>
<div class="prava">© SPASE ELECTRONICS, 2020. Все права защищены</div>