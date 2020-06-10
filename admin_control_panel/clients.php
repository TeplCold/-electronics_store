<?php
session_start();

if ($_SESSION['auth_login'] == 'admin') { //выводим эту страницу только когда пользователь не авторизирован
    include("../pages/db_connect.php");
    include("../pages/reg_aunt/functions.php");
    include("../pages/reg_aunt/auth_cooke.php");

    $id = clear_string($_GET["id"]); //подключаем функцию очистки строк
    $id = mb_strtolower($id, 'UTF-8'); //Приведение строки к нижнему регистру
    $id = mysqli_real_escape_string($link, $id); //Экранируемые символы NUL (ASCII 0), \n, \r, \, ', ", и Control-Z.

    $action = $_GET["action"];
    if (isset($action)) {
        switch ($action) {
            case 'delete':
                $delete = mysqli_query($link, "DELETE FROM users WHERE id = '$id'");
                break;
        }
    }
?>

    <!DOCTYPE html>
    <html lang="ru">

    <head>

        <title>Панель управления</title>
        <link rel="shortcut icon" href="../assets/player.ico" type="image/iso">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="style/clients/clients.css">
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="jquery_confirm/jquery_confirm.css">

    </head>

    <body>

        <?php include("header.php"); ?>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_control_panel.php">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">Клиенты/администраторы</li>
            </ol>
        </nav>

        <?php include("panelyprav.php"); ?>




        <?php
        $all_client = mysqli_query($link, "SELECT * FROM users WHERE login != 'admin' ");
        $result_count = mysqli_num_rows($all_client);

        $all_admin = mysqli_query($link, "SELECT * FROM users WHERE login = 'admin'");
        $admin_count = mysqli_num_rows($all_admin);
        ?>


        <p id="count-clients">Клиенты - <strong><?php echo $result_count; ?></strong></p>
        <p id="count-admin">Администраторы - <strong><?php echo  $admin_count; ?></strong></p>


        <div class="container-fluid">
            <?php

            $num = 2;
            $page = (int) $_GET['page'];

            $count = mysqli_query($link, "SELECT COUNT(*) FROM users ");
            $temp = mysqli_fetch_array($count);

            if ($temp[0] > 0) {
                $tempcount = $temp[0];

                // находим общее число страниц 
                $total = (($tempcount - 1) / $num) + 1;
                $total =  intval($total);
                $page = intval($page);

                if (empty($page) or $page < 0) {
                    $page = 1;
                }
                if ($page > $total) {
                    $page = $total;
                }
                // вычисляем с какого номера начинать следует выводить товар
                $start = $page * $num - $num;
                $qury_start_num = " LIMIT $start, $num";
            }


            $result = mysqli_query($link, "SELECT * FROM users    ORDER BY id DESC LIMIT $start, $num");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {
                    $datetime = strtotime($row["datetime"]);
                    echo '
                    <div class="block-clients">
                    -----------------------------------------------------------------------
                    <p class="client-login" ><strong>' . $row["login"] . '</strong></p>
                   
                  
                    <ul>
                        <li><strong>E-Mail</strong> - ' . $row["email"] . '</>
                        <li><strong>Фамилия</strong> - ' . $row["surname"] . '</li>
                        <li><strong>Имя</strong> -  ' . $row["name"] . '</li>
                        <li><strong>Отчество</strong> - ' . $row["patronymic"] . '</li>
                        <li><strong>IP</strong> - ' . $row["ip"] . '</li>
                        <li><strong>Дата регистрации</strong> - ' .  date("d.m.Y h:i:s", $datetime) . '</li>
                    </ul>
                    <div><p class="client-links" ><a class="delete3" rel="clients.php?id=' . $row["id"] . '&action=delete" >Удалить</a></p></div> 
                    </div>
                    ';
                } while ($row = mysqli_fetch_array($result));
            }


            ?>
        </div>

        <div class="container-fluid" id="pagination">
            <?php
            if ($page != 1) {
                $pstr_prev = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page - 1) . '">    <   </a></li>';
            }
            if ($page != $total) {
                $pstr_next = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page + 1) . '">    >   </a></li>';
            }

            // Формируем ссылки со страницами

            if ($page - 4 > 0) $page4left = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
            if ($page - 3 > 0) $page3left = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
            if ($page - 2 > 0) $page2left = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
            if ($page - 1 > 0) $page1left = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';
            if ($page + 4 <= $total) $page4right = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
            if ($page + 3 <= $total) $page3right = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
            if ($page + 2 <= $total) $page2right = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
            if ($page + 1 <= $total) $page1right = '<li class="page-item"><a class="page-link" href="clients.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';

            if ($page + 5 == $total) {
                $strtotal1 = '<li><a class="page-link" href="clients.php?page=' . $total . '">' . $total . '</a></li>';
            } elseif ($page + 4 < $total) {
                $strtotal1 = '<li class="page-item"><a class="page-link">...</a></li><li><a class="page-link" href="clients.php?page=' . $total . '">' . $total . '</a></li>';
            } else {
                $strtotal1 = "";
            }

            if ($page == 6) {
                $strtotal2 = '<li><a class="page-link" href="clients.php?page=' . 1 . '">' . 1 . '</a></li>';
            } elseif ($page - 4 > 1) {
                $strtotal2 = '<li><a class="page-link" href="clients.php?page=' . 1 . '">' . 1 . '</a></li> <li class="page-item"><a class="page-link">...</a></li>';
            } else {
                $strtotal2 = "";
            }

            if ($total > 1) {
                echo '
            <nav class="container_pagination" aria-label="Page navigation example">
            <ul class="pagination">
            ';
                echo $pstr_prev . $strtotal2  . $page4left . $page3left . $page2left . $page1left .
                    "<li class='page-item active' ><p class='page-link' href='tovar.php?sort=" . $_GET["sort"] . " &page=" . $page . "'>" . $page . "</p></li>" . $page1right . $page2right . $page3right . $page4right  . $strtotal1 . $pstr_next;
                echo '
            </ul>
            </nav>
            ';
            }
            ?>
        </div>


        <script defer type="text/javascript" src="../javascript/jquery-3.5.1.js"> </script>
        <script defer type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

        <script defer type="text/javascript" src="../javascript/jquery-3.4.1.js"></script>
        <script defer type="text/javascript" src="js/script.js"></script>
        <script defer type="text/javascript" src="jquery_confirm/jquery_confirm.js"></script>
        <script defer type="text/javascript" src="../javascript/header_footer.js"></script>

    </body>

    </html>

<?php
} else {
    header(("Location: ../index.php"));
} ?>