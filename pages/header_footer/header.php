<link rel="stylesheet" type="text/css" href="../../style/header_footer/header_footer.css">

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item  "><a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> Главная</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/product_list.php"> Каталог</a></li>
            <li class="nav-item  "> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/about_us.php"> О нас</a></li>

            <li class="nav-item">
                <p id="block-basket_header_count"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
                <p> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick">Корзина</a></p>
                <p id="block-basket_header_prise"> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
            </li>

            <?php if (isset($_SESSION['auth_name']) != ($_SESSION['auth_login'] == 'admin')) : ?>
                <div id="auth-user-info">
                    <p id="auth-user-info"> Вы - <?php echo $_SESSION['auth_name']; ?></p>
                </div>

            <?php elseif ($_SESSION['auth_login'] == 'admin') : ?>
                <li class="nav-item  ">
                    <p id="auth-user-info"> Вы - Администратор</p>
                </li>

            <?php else : ?>
                <li class="nav-item  ">
                    Вы - Гость <br>
                    <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/registration.php">ВХОД|РЕГИСТРАЦИЯ</a>
                </li>
            <?php endif; ?>

            <div id="block-user">
                <ul>

                    <?php if ($_SESSION['auth_login'] == 'admin') : ?>
                        <li> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /admin_control_panel/admin_control_panel.php"> Панель управления</a></li>
                    <?php else : ?>
                        <li> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /pages/profile.php"> Профиль</a></li>
                    <?php endif; ?>

                    <li>
                        <p id="logout">Выход</p>
                    </li>
                </ul>
            </div>
        </ul>
    </div>

    <!-- форма поиска -->
    <div id="block-search">
        <form method="GET" action="/pages/search.php?q=">
            <span></span>
            <input type="text" id="input-search" name="q" placeholder="Поиск по сайту" onfocus="this.value=''" value="<?php echo $search; ?>" />
            <input type="submit" id="button-search" value="Поиск" />
        </form>
    </div>
</nav>