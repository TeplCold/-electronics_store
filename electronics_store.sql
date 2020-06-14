DROP DATABASE `electronics_store`; -- удаление БД
CREATE DATABASE IF NOT EXISTS `electronics_store`; -- создание БД
USE `electronics_store`;
--
-- База данных: `electronics_store`
--

--
-- Структура таблицы `brand`
--
CREATE TABLE `brand` (
  `brand_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `brand`
--
INSERT INTO `brand` (`brand_id`, `brand`) VALUES
(1, 'Sony'),
(2, 'Samsung');

--
-- Структура таблицы `buy_products`
--
CREATE TABLE `buy_products` (
  `buy_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `buy_id_order` int(11) NOT NULL,
  `buy_id_product` int(11) NOT NULL,
  `buy_count_product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `category`
--
CREATE TABLE `category` (
  `category_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--
INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Смартфоны и гаджеты'),
(2, 'Ноутбуки и компьютеры'),
(3, 'Телевизоры, аудио-видео, Hi-Fi'),
(4, 'Бытовая техника для дома и кухни'),
(5, 'Товары для красоты, здоровья, активного отдыха'),
(6, 'Фото, видео, системы безопасности'),
(7, 'Автомобильная электроника'),
(8, 'Игровые комплектующие');

--
-- Структура таблицы `subcategory`
--
CREATE TABLE `subcategory` (
  `subcategory_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` int NOT NULL,
  `subcategory` varchar(50) NOT NULL,
  FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subcategory`
--
INSERT INTO `subcategory` (`subcategory_id`, `category_id`, `subcategory`) VALUES
(5, '1', 'Смартфоны'),
(6, '1', 'Планшеты'),
(7, '1', 'Мобильные телефоны'),
(8, '1', 'Наушники'),
(9, '1', 'Power bank'),
(10, '1', 'Аксессуары для наушников'),
(11, '1', 'Зарядные устройства'),
(12, '2', 'Ноутбуки'),
(13, '2', 'Ноутбуки-трансформеры'),
(14, '2', 'Ультрабуки'),
(15, '2', 'Моноблоки'),
(16, '2', 'Мониторы'),
(17, '2', 'Компьютеры'),
(21, '3, Hi-Fi', 'Телевизоры'),
(22, '3, Hi-Fi', 'LED панели'),
(23, '3, Hi-Fi', 'Аксессуары для LFD-панелей'),
(24, '3', 'Аксессуары для телевизоров'),
(25, '3', 'Проекторы и экраны '),
(33, '4', 'Крупная бытовая техника'),
(34, '4', 'Встраиваемая техника'),
(35, '4', 'Вытяжки'),
(36, '4', 'Кофемашины, кофеварки'),
(37, '4', 'Мелкая бытовая техника'),
(38, '4', 'Принадлежности для бытовой техники'),
(39, '4', 'Посуда'),
(40, '4', 'Техника для дома'),
(41, '4', 'Швейное оборудование'),
(42, '4', 'Кондиционеры'),
(43, '4', 'Обогреватели'),
(44, '4', 'Климатическая техника'),
(45, '4', 'Водонагреватели'),
(46, '4', 'Очистка воды'),
(47, '4', 'Сушилки для рук'),
(48, '4', 'Бытовая химия'),
(49, '5', 'Товары для укладки и стрижки'),
(50, '5', 'Товары для здоровья'),
(51, '5', 'Товары для красоты'),
(52, '5', 'Средства личной гигиены'),
(53, '5', 'Антисептики'),
(54, '5', 'Средства защиты'),
(55, '5', 'Бритвы и эпиляторы'),
(56, '5', 'Медицинское оборудование'),
(57, '6', 'Фотоаппараты'),
(58, '6', 'Объективы для фотоаппаратов'),
(59, '6', 'Вспышки для фотоаппаратов'),
(60, '6', 'Видеокамеры'),
(61, '6', 'Экшн камеры'),
(62, '6', 'Стедикамы'),
(63, '6', 'Аксессуары для стедикамов'),
(64, '6', 'Цифровые фоторамки'),
(65, '6', 'Системы безопасности'),
(66, '6', 'Аксессуары'),
(67, '7', 'Автокресла'),
(68, '7', 'Навигаторы'),
(69, '7', 'Автомагнитолы'),
(70, '7', 'Автоакустика'),
(71, '7', 'Телевизоры автомобильные'),
(72, '7', 'Автомобильные мониторы'),
(73, '7', 'Видеорегистраторы с радар-детектором'),
(74, '7', 'Видеорегистраторы'),
(75, '7', 'Радар-детекторы'),
(76, '7', 'Парктроники'),
(77, '7', 'Автомобильные холодильники'),
(78, '7', 'Автомобильные пылесосы'),
(79, '7', 'Автосигнализации'),
(80, '7', 'Камеры заднего вида'),
(81, '7', 'Компрессоры и манометры'),
(82, '7', 'Аксессуары для автомобиля'),
(83, '8', 'Блоки питания'),
(84, '8', 'Видеокарты'),
(85, '8', 'Материнские платы'),
(86, '8', 'Процессоры'),
(87, '8', 'SSD');

--
-- Структура таблицы `products`
--
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `datatime` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `min_description` text NOT NULL,
  `description` text NOT NULL,
  `features` text NOT NULL,
  `type_tovara` varchar(30) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '1',
  `subcategory_id` int NOT NULL,
  `obzor` varchar(20) DEFAULT NULL,
  `title_obzor` text,
FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Структура таблицы `cart`
--
CREATE TABLE `cart` (
  `id_cart` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_products_cart` int(11) NOT NULL,
  `cart_price` int(11) NOT NULL,
  `count_cart` int(11) NOT NULL DEFAULT '1',
  `datetime_cart` datetime NOT NULL,
  `ip_users` varchar(100) NOT NULL,
  FOREIGN KEY (`id_products_cart`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `image_products`
--
CREATE TABLE `image_products` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `products_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `orders`
--
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `order_datetime` datetime NOT NULL,
  `order_confirmed` varchar(10) NOT NULL DEFAULT 'no',
  `order_dostavka` varchar(255) NOT NULL,
  `order_pay` varchar(50) NOT NULL,
  `order_type_pay` varchar(100) NOT NULL,
  `order_fio` text NOT NULL,
  `order_name` text NOT NULL,
  `order_patronymic` text NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` varchar(20) NOT NULL,
  `order_note` text NOT NULL,
  `order_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `reviews_products`
--
CREATE TABLE `reviews_products` (
  `reviews_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `products_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rating` decimal(4,2) NOT NULL,
  `good_reviews` text NOT NULL,
  `bad_reviews` text NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `moderat` int(11) NOT NULL,
  FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Структура таблицы `users`
--
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `login` varchar(15) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `name` varchar(15) NOT NULL,
  `patronymic` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `surname`, `name`, `patronymic`, `email`, `datetime`, `ip`) VALUES
(1, 'admin', '9nm2rv8qcf23307b0df16d25f438e697612e0b46d5ebae022yotykytk6z', 'admin', 'admin', 'admin', 'teplcold@gmail.com', '2020-06-09 00:00:00', '127.0.0.1'),
(43, 'egor1', '9nm2rv8qcf23307b0df16d25f438e697612e0b46d5ebae022yotykytk6z', '1Savd', 'Sadv', '34T', 'ssadvedvg@mail.ru', '2020-06-04 03:59:26', '127.0.0.1');








