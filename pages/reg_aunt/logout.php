<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['auth']);
    setcookie('rememberme', '', 0, '/');
    echo 'logout';
}
