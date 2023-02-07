-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2023 at 03:44 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `functionalrequirements`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `number` varchar(20) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `number`, `description`, `status`) VALUES
(1, 'Система за управление на изисквания', '1', 'Подробно описание на системата', 'незапочнат'),
(26, 'Чат бот', '2', 'Създайте чат бот подобно на ChatGPT, който да може да води разговор за някаква определена област, например готвене или футбол.', 'чернова'),
(27, 'App Store', '3', 'Създайте магазин за приложения, откъдето да могат да се свалят проектите от курса по уеб. Приложението трябва да поддържа както десктоп приложения с различни версии за различните ОС, така и мобилни приложения.', 'незапочнат'),
(28, 'Escape room', '4', 'Създайте игра тип \"Escape room\" във формата на уеб приложение.', 'завършен'),
(29, 'Escape room store', '4.1', 'Създайте уеб приложение, в което потребителите да могат да разглеждат и стартират различни Escape rooms.', 'чернова'),
(30, 'Система за следене на обявления', '5', 'Създайте уеб базирано приложение, което да изпраща нотификация винаги щом се появи обявление в мудъл или друга платформа.', 'чернова');

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `layer` varchar(50) NOT NULL,
  `story` varchar(200) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `tags` varchar(1000) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`id`, `name`, `project_id`, `priority`, `layer`, `story`, `description`, `tags`, `type`) VALUES
(43, 'Регистрация', 27, 'MUST_HAVE', 'Бизнес логика', 'Като нов потребител, искам да се регистрирам в сайта.', 'Регистрацията трябва да стане чрез уникален email и парола.', '#login', 'Функционално'),
(44, 'Availability', 27, 'MUST_HAVE', 'Рутиране', 'Като потребител, трябва да мога да достъпвам приложението по всяко време.', 'Високо ниво на availability: 98%', '#availability', 'Нефункционално'),
(45, 'Изтегляне', 27, 'MUST_HAVE', 'Бизнес логика', 'Като потребител, искам да изтегля приложение от App Store', 'Изтеглянето трябва да става посредством сигурна връзка.', '#stream #download', 'Функционално'),
(46, 'Мобилни приложнения', 27, 'NICE_TO_HAVE', 'Бизнес логика', 'Като потребител, искам да мога да изтегля приложение за мобилни устройства', 'Поддръжка на .apk файлове например', '#mobile', 'Функционално'),
(47, 'Добавяне на изискване', 1, 'MUST_HAVE', 'Бизнес логика', 'Като потребител, трябва да мога да добавям изисквания', 'добави изискване', '#persistence', 'Функционално');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'ADMIN'),
(2, 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` blob NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role_id`, `email`, `id`) VALUES
('bob', 0x243279243130244f4c613469575844326b5274536a5361586d7556414f366b6d39627842707730503953632f416c31496e4a, 1, 'bob@bob.com', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requirements`
--
ALTER TABLE `requirements`
  ADD CONSTRAINT `requirements_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
