<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item  "> <a class="nav-link" href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/../../index.php">в магазин</a> </li>


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
</nav>