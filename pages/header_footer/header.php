<link rel="stylesheet" type="text/css" href="../../style/header_footer/header_footer.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Underdog&display=swap" rel="stylesheet">


<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="glavnimg"><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> <img src="../../assets/images.png" /></a></div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">
            
            <div class="headlinks">
                <a class="linkhead" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> Главная</a>
                <a class="linkhead" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/product_list.php"> Каталог</a>
                <a class="linkhead" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/about_us.php"> О нас</a>
            </div>


        </ul>


        <!-- форма поиска -->
        <div id="block-search">
            <form class="form-wrapper cf" method="GET" action="/pages/search.php?q=">
                <input autocomplete="new-password" type="text" id="input-search" name="q" placeholder="Поиск по сайту..." onfocus="this.value=''" value="<?php echo $search; ?>" required />
                <button type="submit" id="button-search"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="block-basket_header_count">
            <div class="form-cat">
                <div class="countcat">
                    <p id="block-basket_header_count"> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
                    <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"><img src="../../assets/_9610-12.png" /></a>
                </div>
                <p id="block-basket_header_prise"> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/cart.php?action=oneclick"></a></p>
            </div>
        </div>

        <div class=" blockcat-reg">
            <?php if (isset($_SESSION['auth_name']) != ($_SESSION['auth_login'] == 'admin')) : ?>
                <div class="form-reg" id="auth-user-info">
                    <img src="../../assets/fly_123847-1.png" />
                    <p> <?php echo $_SESSION['auth_name']; ?></p>
                </div>
            <?php elseif ($_SESSION['auth_login'] == 'admin') : ?>
                <div class="form-reg" id="auth-user-info">
                    <img src="../../assets/fly_123847-1.png" />
                    <p> Администратор</p>
                </div>
            <?php else : ?>
                <div class="form-reg">

                    <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/pages/registration.php"> <img src="../../assets/fly_123847-1.png" /><br>Вход|Регистрация</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div id="block-user">
    <ul>
        <?php if ($_SESSION['auth_login'] == 'admin') : ?>
            <li class="ad"> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /admin_control_panel/admin_control_panel.php">Панель <br>управления</a></li>
        <?php else : ?>
            <li class="us"> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /pages/profile.php"> Профиль </a></li>
        <?php endif; ?>
        <p id="logout">Выход</p>
    </ul>
</div>