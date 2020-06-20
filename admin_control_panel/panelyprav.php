<?php
$resultt1 = mysqli_query($link, "SELECT * FROM orders WHERE order_confirmed='no'");
$countt1 = mysqli_num_rows($resultt1);

if ($countt1 > 0) {
    $countt_str1 = '+' . $countt1;
} else {
    $countt_str1 = '';
}

$resultt2 = mysqli_query($link, "SELECT * FROM reviews_products WHERE moderat='0'");
$countt2 = mysqli_num_rows($resultt2);

if ($countt2 > 0) {
    $countt_str2 = '+' . $countt2;
} else {
    $countt_str2 = '';
}

?>





<div class="container" id="left-nav">
<div class="panelyprav_name">Панель управления</div>
    <ul>
        <li><a href="admin_control_panel.php">Главная</a></li>
        <li><a href="tovar.php">Товары</a></li>
        <li><a href="reviews.php">Отзывы</a><?php echo $countt_str2; ?></li>
        <li><a href="orders.php">Заказы</a><?php echo $countt_str1; ?></li>
        <li><a href="clients.php">Клиенты/администраторы</a></li>
        <li><a href="category_brand.php">Категории/брэнды</a></li>
        <!-- <li><a href="news.php">Новости</a></li> -->
    </ul>
</div>