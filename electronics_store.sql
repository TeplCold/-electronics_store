DROP DATABASE `electronics_store`; -- удаление БД
CREATE DATABASE IF NOT EXISTS `electronics_store`; -- создание БД
USE `electronics_store`;
-- --------------------------------------------------------

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
  `vote` int(11) NOT NULL,
  `votes` float NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `brand`, `datatime`, `image`, `min_description`, `description`, `features`, `type_tovara`, `brand_id`, `vote`, `votes`, `count`, `visible`) VALUES
(1, 'Смартфон Sony Xperia 10', 19999, 'Sony', '2020-05-05 19:22:00', 'Sony_Xperia_10/Sony_Xperia_10.jpg', '', '', '', 'mobile', 0, 1, 1, 8, 1),
(2, 'Ноутбук Acer Nitro 5 AN515-52-74NV черный', 70999, 'Acer', '2020-05-14 19:22:00', 'AcerNitro5AN515-52-74NV/AcerNitro5AN515-52-74NV.jpg', '', '', '', 'computers', 0, 1, 1, 8, 1),
(6, 'Ноутбук ACER Aspire 3', 30190, 'ACER', '2020-05-08 19:22:00', 'ACERAspire3/1ACERAspire3.jpg', '', '', '', 'computers', 0, 1, 1, 4, 1),
(7, 'Нетбук Prestigio 141C3 серый', 15499, 'Prestigio', '2020-07-14 19:22:00', 'Prestigio141C3/Prestigio141C3.jpg', '', '', '', 'computers', 0, 1, 1, 32, 1),
(8, 'Смартфон SAMSUNG Galaxy A10 32Gb', 9990, 'Samsung', '2020-07-14 19:23:00', 'SAMSUNGGalaxyA10/1SAMSUNGGalaxyA10.jpg', 'Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века.', 'Samsung Galaxy A10 (2019) оборудован 6,2-дюймовым безрамочным дисплеем, который отлично подходит для полного погружения в просмотр любого контента. Разрешение 1520х720 пикселей обеспечивает чёткое, детализированное изображение.\r\n\r\nДЛЯ ПАМЯТНЫХ МОМЕНТОВ\r\nС этим девайсом вы в любое время дня и ночи сделаете запоминающиеся фотографии одним нажатием кнопки. Для этого предусмотрена 13-мегапиксельная камера с автофокусом и вспышкой. На лицевой панели есть «фронталка», снимающая автопортреты достойного качества. Готовые кадры можно украсить с помощью стикеров, фильтров и штампов.\r\n\r\nПРОСТАЯ РАЗБЛОКИРОВКА\r\nНе надо придумывать и запоминать пароль. В этой модели реализована технология распознавания лица, поэтому достаточно просто посмотреть на него. Это надёжное решение, можете быть уверены: ваши личные данные не попадут в чужие руки.\r\n\r\nВСЕГДА НА СВЯЗИ\r\nЁмкость аккумулятора составляет 3 400 мАч. Этого хватит для долгой работы без подзарядки: по информации от компании-производителя, в режиме разговора устройство продержится до 21 часа.', 'Серия модели\r\nСерия	Galaxy A10\r\nМодель	SM-A105FN\r\nОперационная система\r\nОперационная система	Android 9\r\nЭкран\r\nЭкран	6.2\"/1520x720 Пикс\r\nТехнология экрана	TFT	\r\nЧастота обновления		60 Гц\r\nПроцессор\r\nПроизводитель процессора	Samsung\r\nТип процессора	Exynos 7884B\r\nЧастота процессора		2 x 1.6ГГц + 6 x 1.35ГГц\r\nКоличество ядер		8\r\nОсновная камера\r\nОсновная камера МПикс	13\r\nКоличество основных камер	1 шт\r\nВспышка	Да\r\nФронтальная камера\r\nКоличество фронтальных камер	1 шт\r\nФронтальная камера МПикс	5\r\nОперативная память\r\nОперативная память (RAM)		2 ГБ\r\nВстроенная память\r\nВстроенная память (ROM)	32 ГБ\r\nКарта памяти\r\nМаксимальная емкость карты памяти	512 ГБ\r\nТип карты памяти	microSD, microSDHC, microSDXC', 'mobile', 0, 1, 1, 34, 1),
(11, 'Холодильник Samsung RT35K5410S9/WT серебристый', 899900, 'Samsung', '2020-05-14 19:23:00', 'SamsungRT35K5410S9WT/SamsungRT35K5410S9WT.jpg', '', '', '', 'Appliances', 0, 1, 1, 15, 1);


CREATE TABLE `image_products` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `products_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
   FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- Дамп данных таблицы `image_products`
--
INSERT INTO `image_products` (`id`, `products_id`, `image`) VALUES
(1, 8, 'SAMSUNGGalaxyA10/1SAMSUNGGalaxyA10.jpg'),
(2, 8, 'SAMSUNGGalaxyA10/2SAMSUNGGalaxyA10.jpg'),
(3, 6, 'ACERAspire3/1ACERAspire3.jpg'),
(4, 7, 'Prestigio141C3/Prestigio141C3.jpg'),
(5, 2, 'AcerNitro5AN515-52-74NV/AcerNitro5AN515-52-74NV.jpg'),
(6, 11, 'SamsungRT35K5410S9WT/SamsungRT35K5410S9WT.jpg\r\n'),
(7, 1, 'Sony_Xperia_10/Sony_Xperia_10.jpg');
-- --------------------------------------------------------

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
(40, 'admin', '9nm2rv8q0b70dab76694d6052a836a206977985b49be0ea72yotykytk6z', 'Тепл', 'Гео', 'Конст', 'teplcold@gmail.com', '2020-05-20 22:22:13', '127.0.0.1'),
(43, 'egor1', '9nm2rv8qcf23307b0df16d25f438e697612e0b46d5ebae022yotykytk6z', 'Savd', 'Sadv', 'Sdv', 'ssadvedvg@mail.ru', '2020-06-04 03:59:26', '127.0.0.1');



CREATE TABLE `cart` (
  `id_cart` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_products_cart` int(11) NOT NULL,
  `cart_price` int(11) NOT NULL,
  `count_cart` int(11) NOT NULL DEFAULT '1',
  `datetime_cart` datetime NOT NULL,
  `ip_users` varchar(100) NOT NULL,
   FOREIGN KEY (`id_products_cart`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Структура таблицы `reviews_products`
--

CREATE TABLE `reviews_products` (
  `reviews_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `products_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rating` DECIMAL (4,2) NOT NULL,
  `good_reviews` text NOT NULL,
  `bad_reviews` text NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `moderat` int(11) NOT NULL,
   FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews_products`
--

INSERT INTO `reviews_products` (`reviews_id`, `products_id`, `name`, `rating`,`good_reviews`, `bad_reviews`, `comment`, `date`, `moderat`) VALUES
(1, 8, 'Георгий', 3 ,'Большой экран,ёмкая батарея,32 g', 'Отсутствие NFS,динамик сзади.', 'Купил данный телефон и был приятно удивлен.Наконец то Samsung это сделали,хороший бюджетники по приемлемой цене.Очень шустрый процессор,приложения открываются практически мгновенно, новая удобная оболочка подстраивается под ваши нужды.Камера снимает очень даже хорошо,особенно днём, ночью детализация конечно падает, но не флагман же.Селфи получаются очень чёткие.И конечно экран, это бомба.Смотреть фильмы и прочий медиаконтент одно удовольствие.', '2020-06-04 00:00:00', 1);

-- --------------------------------------------------------


