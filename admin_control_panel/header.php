<link rel="stylesheet" type="text/css" href="style/header_footer/header.css">


          
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="glavnimg"><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> <img src="../../assets/images.png" /></a></div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

        <ul class="navbar-nav mr-auto">

            <div class="headlinks">
                <a class="linkhead" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php"> в магазин</a>
            </div>


        </ul>

        <div class="blockcat-reg">
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
            <li> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /admin_control_panel/admin_control_panel.php"> Панель <br> управления</a></li>
        <?php else : ?>
            <li> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>  /pages/profile.php"> Профиль</a></li>
        <?php endif; ?>

        <li>
            <p id="logout">Выход</p>
        </li>
    </ul>
</div>