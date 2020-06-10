DROP DATABASE `electronics_store`; -- удаление БД
CREATE DATABASE IF NOT EXISTS `electronics_store`; -- создание БД
USE `electronics_store`;

CREATE TABLE `brand` (
  `brand_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `brand` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `category` (
  `category_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `categorya` varchar(50) NOT NULL,
  `subcategory` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `visible` int(11) NOT NULL DEFAULT '1',
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `image_products` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `products_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
   FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

INSERT INTO `users` (`id`, `login`, `pass`, `surname`, `name`, `patronymic`, `email`, `datetime`, `ip`) VALUES
(1, 'admin', '9nm2rv8qcf23307b0df16d25f438e697612e0b46d5ebae022yotykytk6z', 'admin', 'admin', 'admin', 'teplcold@gmail.com', '2020-06-09 00:00:00', '127.0.0.1'),
(43, 'egor1', '9nm2rv8qcf23307b0df16d25f438e697612e0b46d5ebae022yotykytk6z', 'Savd', 'Sadv', '34T', 'ssadvedvg@mail.ru', '2020-06-04 03:59:26', '127.0.0.1');

CREATE TABLE `cart` (
  `id_cart` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_products_cart` int(11) NOT NULL,
  `cart_price` int(11) NOT NULL,
  `count_cart` int(11) NOT NULL DEFAULT '1',
  `datetime_cart` datetime NOT NULL,
  `ip_users` varchar(100) NOT NULL,
   FOREIGN KEY (`id_products_cart`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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


