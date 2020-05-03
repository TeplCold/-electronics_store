<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

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
                <a class="nav-link disabled" href="#">Категори</a>
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

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>