<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item  ">
                <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> Главная</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/product_list.php"> Каталог</a>
            </li>

            <li class="nav-item  ">
                <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/about_us.php"> О нас</a>
            </li>

            <li class="nav-item">
                <a class="nav-link disabled" href="#">Корзина</a>
            </li>

            <div class="registrationt ">
                <?php if (isset($_SESSION['logged_user'])) : ?>
                    Авторизованны!<br>
                    Вы - <?php echo $_SESSION['logged_user']->login; ?>
                    <br>
                    <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>../pages/logout.php">Выйти</a>

                <?php else : ?>
                    <li class="nav-item  ">
                        Вы - Гость <br>
                        <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/reg_aunt/registration.php">ВХОД|РЕГИСТРАЦИЯ</a>
                    </li>
                <?php endif; ?>
            </div>
        </ul>
    </div>
</nav>