-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: MySQL-8.0
-- Generation Time: Oct 04, 2026 at 06:10 PM
-- Server version: 8.0.43
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sever_corp`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_info`
--

CREATE TABLE `additional_info` (
  `info_id` int UNSIGNED NOT NULL,
  `FK_good` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `additional_info`
--

INSERT INTO `additional_info` (`info_id`, `FK_good`, `name`, `value`) VALUES
(1, 1, 'Тип заправки', 'чернила'),
(2, 1, 'Запас', '0.5 мл'),
(3, 1, 'Цвет чернил', 'Синий'),
(4, 1, 'Толщина стержня', '0.2 мм'),
(5, 1, 'Колпачок', 'присудствует'),
(6, 6, 'Грифель', 'HB'),
(7, 6, 'Длинна', '20 см'),
(8, 7, 'Тип грифеля', 'HB'),
(9, 7, 'Количество карандашей', '8'),
(10, 7, 'Цвета', 'Красный, Ораньжевый, Жёлтый, Зелёный, Голубой, Синий, Фиолетовый, Розовый'),
(11, 7, 'Материал упаковки', 'картон'),
(12, 8, 'Количество в упаковке', '100 штук'),
(13, 8, 'Размер листа', 'A4'),
(14, 8, 'Материал упаковки', 'бумага'),
(15, 9, 'Материал', 'Эпоксидная смола'),
(16, 9, 'Цвет', 'Зелёный'),
(17, 9, 'Измеряемый угол', '180 градусов'),
(18, 9, 'Штрихи угла', '45 градусов, 1 градус'),
(19, 9, 'Радиус измерительной шкалы', '7 см'),
(20, 9, 'Длинна линейки', '15 см'),
(21, 9, 'Штрихи линейки', '1см, 1мм'),
(22, 10, 'Тип заправки', 'чернила'),
(23, 10, 'Запас', '0.5 мл'),
(24, 10, 'Цвет чернил', 'чёрный'),
(25, 10, 'Толщина стержня', '0.2 мм'),
(26, 10, 'Колпачок', 'присудствует'),
(30, 8, 'Материал', 'Древесина'),
(31, 15, 'Размер', '100x70x14 мм'),
(32, 15, 'Модель', 'MC-2000'),
(33, 15, 'Разрядность', '8'),
(34, 15, 'Имеет память', 'да'),
(35, 16, 'Цвет', 'красный'),
(36, 16, 'Материал', 'кожезаменитель'),
(37, 16, 'Вид крепления', 'кольца'),
(38, 17, 'Материал обложки', 'полиэтилен'),
(39, 17, 'Тип крепления', 'кольца'),
(40, 17, 'Цвет', 'синий'),
(41, 17, 'Размер', 'А4'),
(42, 18, 'Цвет', 'чёрный'),
(43, 18, 'Количество пробиваемых отверстий', '2'),
(44, 18, 'Материал', 'металл'),
(45, 18, 'Диаметр отверстий', '6 мм'),
(46, 18, 'Поддон для конфети', 'да'),
(47, 18, 'Линейка', 'да'),
(48, 18, 'Отметки линейки', 'А5, А4, А3'),
(61, 27, 'Материал', 'древесина'),
(62, 27, 'Лакировка', 'отсутствует'),
(63, 27, 'Штрихи', '1 см, 1 мм'),
(64, 27, 'Максимальное деление', '15 см'),
(65, 28, 'Цвет', 'одноцветный жёлтый'),
(66, 28, 'Узор', 'нет'),
(67, 28, 'Материал', 'оптоволокно'),
(68, 28, 'Крепление', 'лямки'),
(69, 28, 'Объём основного отсека', '0.4 м³'),
(70, 28, 'Боковые отсеки', '2'),
(71, 28, 'Передний отсек', '1'),
(72, 29, 'Длинна', '60 м'),
(73, 29, 'Диаметр', '20 см'),
(74, 29, 'Тип', 'прозрачный'),
(75, 29, 'Клейких сторон', 'одна'),
(76, 29, 'Втулка', 'разумеется');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Бумажная продукция'),
(2, 'Бумага'),
(3, 'Альбомы'),
(4, 'Презентационное оборудование'),
(5, 'Офисные принадлежности'),
(6, 'Папки'),
(7, 'Расходные материалы для печати'),
(8, 'Письменные принадлежности'),
(9, 'Принадлежности для лепки'),
(10, 'Принадлежности для рисования'),
(11, 'Товары для творчества'),
(12, 'Компьютерные аксесуары'),
(13, 'Чертёжные принадлежности'),
(14, 'Школьный текстиль'),
(15, 'Средства индивидуальной защиты');

-- --------------------------------------------------------

--
-- Table structure for table `collab_offers`
--

CREATE TABLE `collab_offers` (
  `collab_offer_id` int UNSIGNED NOT NULL,
  `FK_user` int UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `collab_offers`
--

INSERT INTO `collab_offers` (`collab_offer_id`, `FK_user`, `full_name`, `company_name`, `phone_number`) VALUES
(1, 1, 'Лонов Дмитрий Семёнович', 'ООО \"ПЕРВАЯ ЛИНИЯ\"', '+7(903)809-23-70'),
(3, 4, 'Карантинов Глеб Фёдорович', 'АО \"ЖикЖекЖог\"', '8(906)552-78-13'),
(4, 3, 'Ян Амал Викторович', 'ИП \"Ян Амал\"', '+79012230123');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_lists`
--

CREATE TABLE `favorite_lists` (
  `FK_user` int UNSIGNED NOT NULL,
  `FK_good` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorite_lists`
--

INSERT INTO `favorite_lists` (`FK_user`, `FK_good`) VALUES
(4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `good_id` int UNSIGNED NOT NULL,
  `article_num` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `wholesale_price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `FK_category` int UNSIGNED NOT NULL,
  `FK_shipper` int UNSIGNED NOT NULL,
  `country` varchar(255) NOT NULL,
  `FK_special_offer` int UNSIGNED DEFAULT NULL,
  `images_count` int NOT NULL DEFAULT '0',
  `supply_left` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`good_id`, `article_num`, `name`, `price`, `wholesale_price`, `description`, `FK_category`, `FK_shipper`, `country`, `FK_special_offer`, `images_count`, `supply_left`) VALUES
(1, 647190, 'Ручка шариковая', 12.99, 11.83, 'Ручка для письма от извесной компании \"Beluga\"', 8, 2, 'Германия', NULL, 3, 84),
(6, 874562, 'Карандаш простой HB', 8.99, 8.27, 'Простой карандаш. Проще некуда.', 8, 1, 'Россия', 1, 3, 486),
(7, 130998, 'Набор цветных карандашей 8шт.', 10.00, 6.00, 'Набор карандашей для детей от 3-х лет. Содержит в себе 8 карандашей в картонной упаковке.', 8, 3, 'Россия', NULL, 1, 60),
(8, 345001, 'Набор бумаги A4 100 листов', 379.99, 340.90, 'Чистая белая бумага высшего качества. Подходит как для печати, так и для прочих целей.', 2, 1, 'Россия', 1, 1, 5),
(9, 378912, 'Транспортир зелёный прозрачный', 45.00, 43.66, 'Транспортир и линейка в одном инструменте. Имеет прозрачный, легкогнущийся материал. Предназначен для использования в школе.', 13, 2, 'Германия', 2, 2, 8),
(10, 453782, 'Ручка шариковая чёрная', 15.68, 14.01, 'Ручка шариковая для письма с чёрными чернилами от известной компании.', 8, 2, 'Германия', NULL, 2, 478),
(15, 1924623, 'Школьный калькулятор', 670.00, 590.00, 'Калькулятор малоразмерный для применения в школе и в офисе. Поддерживает все базовые операции, а также имеет память.', 5, 3, 'Россия', NULL, 1, 29),
(16, 436237, 'Папка для документов', 896.00, 867.00, 'Папка красная для документов, с железными кольцами для скрепления файлов. Идеальное решение для вашего имиджа.', 6, 2, 'Германия', 2, 2, 129),
(17, 432513, 'Папка синяя', 896.00, 876.00, 'Папка синего цвета. Предназначена для скрепления документов либо в файлах, либо с проделанными дырами.', 6, 3, 'Россия', NULL, 4, 334),
(18, 837123, 'Дырокол с двумя отверстиями', 570.02, 534.65, 'Дырокол - классическая вещь в любом офисе. Имеет невероятно лёгкую конструкцию, от того и более выгодную цену. Проделывает 2 дырки. Имеется съёмная линейка, для выравнивания листов А5, А4 и А3 для проделывания отверстий в стандартизованных местах.', 5, 1, 'Россия', 10, 2, 193),
(27, 731040, 'Линейка', 35.80, 30.97, 'Линейка для школы. Лучший выбор во всём - от материала до производителя.', 13, 12, 'Россия', NULL, 3, 400),
(28, 900617, 'Школьный рюкзак', 1240.00, 1447.99, 'Традиционный школьный рюкзак для вашего ребёнка. Помогает нести в школу учебники, тетради, письменные принадлежности и многое другое!', 14, 3, 'Россия', 1, 2, 7),
(29, 810425, 'Скотч прозрачный', 168.83, 140.12, 'Клейкая лента для различных нужд, будь то строительные или офисные дела.', 5, 2, 'Германия', NULL, 4, 700);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int UNSIGNED NOT NULL,
  `FK_user` int UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'basket',
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `FK_user`, `status`, `date`) VALUES
(1, 4, 'done', '2025-11-16'),
(3, 3, 'done', '2025-11-01'),
(5, 1, 'done', '2025-08-12'),
(6, 1, 'ordered', '2024-11-14'),
(7, 1, 'basket', NULL),
(8, 6, 'done', '2025-11-16'),
(9, 3, 'basket', NULL),
(10, 4, 'ordered', '2025-11-16'),
(11, 6, 'done', '2025-11-16'),
(12, 6, 'done', '2025-11-16'),
(13, 6, 'ordered', '2025-11-16'),
(14, 6, 'ordered', '2025-12-18'),
(15, 4, 'ordered', '2025-11-16'),
(16, 4, 'ordered', '2025-11-16'),
(17, 4, 'basket', NULL),
(18, 31, 'ordered', '2025-12-18'),
(19, 6, 'basket', NULL),
(20, 31, 'basket', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `entry_id` int UNSIGNED NOT NULL,
  `FK_order` int UNSIGNED NOT NULL,
  `FK_good` int UNSIGNED NOT NULL,
  `count` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`entry_id`, `FK_order`, `FK_good`, `count`) VALUES
(4, 5, 6, 5),
(5, 5, 7, 1),
(6, 5, 9, 1),
(9, 6, 9, 1),
(19, 3, 15, 1),
(20, 3, 18, 1),
(21, 3, 1, 20),
(22, 1, 8, 5),
(23, 8, 1, 1),
(24, 8, 16, 1),
(25, 11, 9, 3),
(26, 12, 7, 20),
(27, 13, 7, 20),
(28, 13, 9, 1),
(31, 10, 9, 2),
(32, 10, 10, 2),
(33, 15, 17, 6),
(34, 15, 18, 6),
(35, 16, 6, 2),
(36, 16, 1, 7),
(37, 7, 28, 1),
(43, 14, 7, 20),
(50, 14, 1, 1),
(51, 18, 28, 1),
(58, 17, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rewiew_id` int UNSIGNED NOT NULL,
  `FK_good` int UNSIGNED NOT NULL,
  `FK_user` int UNSIGNED NOT NULL,
  `rating` int NOT NULL,
  `review_text` text NOT NULL,
  `review_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rewiew_id`, `FK_good`, `FK_user`, `rating`, `review_text`, `review_date`) VALUES
(2, 8, 1, 4, 'Качество бумаги хорошее, но листов не досчитался(', '2025-12-01'),
(3, 8, 3, 5, 'Я не в себе, простите', '2025-12-17'),
(4, 7, 3, 1, 'Чушь полная!\r\nВнучка недовольная, качество отвратительно, низа что не покупайте эту дрянь, они горькие на вкус!\r\nДеньги на ветер! Лучше хлеба купите!\r\n', '2025-09-16'),
(5, 7, 1, 3, 'Вроде карандаши как карандаши, но чего-то не хватает', '2025-06-16'),
(6, 7, 4, 4, 'Дорогущие, но за качество можно и заплатить', '2025-10-22'),
(7, 6, 4, 5, 'Карандаш  просто супер!!!', '2025-09-22'),
(9, 10, 3, 5, '', '2025-11-27'),
(10, 9, 3, 4, 'Реально прозрачный!', '2025-12-14'),
(11, 28, 4, 5, 'Ребёнок в восторге! Рюкзак налазит, ка влитой!\r\nНадеемся, ваша компания будет и дальше развиваться и процветать.', '2024-12-02'),
(12, 29, 3, 5, 'Клейкий, прочный, прозрачный - всё, как заявляли!', '2025-12-12'),
(16, 16, 31, 2, 'Оотчего цена такая? Она из чистого рубина?????', '2025-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `shippers`
--

CREATE TABLE `shippers` (
  `shipper_id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `site` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shippers`
--

INSERT INTO `shippers` (`shipper_id`, `name`, `site`) VALUES
(1, 'Собственного производства', 'sever_corp.org'),
(2, 'Beluga', NULL),
(3, 'Уралпром', 'uralprom.org'),
(12, 'Завод \"Сибирь\"', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `offer_id` int UNSIGNED NOT NULL,
  `partner` varchar(255) NOT NULL,
  `offer_value` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `special_offers`
--

INSERT INTO `special_offers` (`offer_id`, `partner`, `offer_value`) VALUES
(1, 'ГосБанк', 0.33),
(2, 'ЧернНефтьБанк', 1.20),
(10, 'Страхбанк', 0.70);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `login`, `email`, `password`) VALUES
(1, 'Dima', 'dima_ne_dima@tutubox.su', '25d55ad283aa400af464c76d713c07ad'),
(3, 'Yanamal', 'ya@manal.ty', '202cb962ac59075b964b07152d234b70'),
(4, 'Gleb', 'slime@turtle.all', '202cb962ac59075b964b07152d234b70'),
(6, 'admin', 'adminium_material@irrational.you', '84d27a29afe8769f343fb6d7bcf6fe66'),
(31, 'Alice', 'my_own_mail@x-box.org', '25d55ad283aa400af464c76d713c07ad');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_info`
--
ALTER TABLE `additional_info`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `additional_info_ibfk_1` (`FK_good`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `collab_offers`
--
ALTER TABLE `collab_offers`
  ADD PRIMARY KEY (`collab_offer_id`),
  ADD KEY `FK_user` (`FK_user`);

--
-- Indexes for table `favorite_lists`
--
ALTER TABLE `favorite_lists`
  ADD PRIMARY KEY (`FK_user`,`FK_good`) USING BTREE,
  ADD UNIQUE KEY `FK_good` (`FK_good`,`FK_user`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`good_id`),
  ADD UNIQUE KEY `article_num` (`article_num`),
  ADD KEY `FK_category` (`FK_category`),
  ADD KEY `FK_shipper` (`FK_shipper`),
  ADD KEY `goods_ibfk_3` (`FK_special_offer`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_user` (`FK_user`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`entry_id`),
  ADD UNIQUE KEY `unique_item` (`FK_good`,`FK_order`) USING BTREE,
  ADD KEY `FK_order` (`FK_order`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`rewiew_id`),
  ADD KEY `FK_good` (`FK_good`),
  ADD KEY `FK_user` (`FK_user`);

--
-- Indexes for table `shippers`
--
ALTER TABLE `shippers`
  ADD PRIMARY KEY (`shipper_id`);

--
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login_unique` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_info`
--
ALTER TABLE `additional_info`
  MODIFY `info_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `collab_offers`
--
ALTER TABLE `collab_offers`
  MODIFY `collab_offer_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `good_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `entry_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `rewiew_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `shippers`
--
ALTER TABLE `shippers`
  MODIFY `shipper_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `offer_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_info`
--
ALTER TABLE `additional_info`
  ADD CONSTRAINT `additional_info_ibfk_1` FOREIGN KEY (`FK_good`) REFERENCES `goods` (`good_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `collab_offers`
--
ALTER TABLE `collab_offers`
  ADD CONSTRAINT `collab_offers_ibfk_1` FOREIGN KEY (`FK_user`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `favorite_lists`
--
ALTER TABLE `favorite_lists`
  ADD CONSTRAINT `favorite_lists_ibfk_1` FOREIGN KEY (`FK_good`) REFERENCES `goods` (`good_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `favorite_lists_ibfk_2` FOREIGN KEY (`FK_user`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`FK_category`) REFERENCES `categories` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `goods_ibfk_2` FOREIGN KEY (`FK_shipper`) REFERENCES `shippers` (`shipper_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `goods_ibfk_3` FOREIGN KEY (`FK_special_offer`) REFERENCES `special_offers` (`offer_id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`FK_user`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`FK_order`) REFERENCES `orders` (`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`FK_good`) REFERENCES `goods` (`good_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`FK_good`) REFERENCES `goods` (`good_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`FK_user`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
