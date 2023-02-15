-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2023 at 11:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
(1, ' Система за управление на изисквания', '1', 'Подробно описание на системата; допълнително описание ', 'незапочнат'),
(20, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(21, ' Ime na proekt', '2', 'opisanie novo dopulnenie', 'незапочнат'),
(23, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(29, ' Проект по уеб', '21', 'Много подробно описан проект. Заслужава 6 само заради описанието. Трябва да са изпълнени изискванията.', 'чернова'),
(30, 'Разширение за puffin', '13', '', 'незапочнат'),
(31, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(32, ' Ime na proekt', '2', 'opisanie novo dopulnenie', 'незапочнат'),
(33, ' Система за управление на изисквания', '1', 'Подробно описание на системата; допълнително описание sasssssssssssssssssssssssssssssssssssssssssssssss saaaaaaaaaaaaaaaaaaaan  jk ;ns hka;ssss h hd hwbdhwq 3nxajsnjad hdw yqwd yuwqg dy e wyweyogwgydygewyqweygdgwyevdwehdvgw d dwhgefvv c erh feiy34tro6134trp1tr137irt01371873 wioe', 'незапочнат'),
(34, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(35, ' Ime na proekt', '2', 'opisanie novo dopulnenie', 'незапочнат'),
(36, ' Система за управление на изисквания', '1', 'Подробно описание на системата; допълнително описание sasssssssssssssssssssssssssssssssssssssssssssssss saaaaaaaaaaaaaaaaaaaan  jk ;ns hka;ssss h hd hwbdhwq 3nxajsnjad hdw yqwd yuwqg dy e wyweyogwgydygewyqweygdgwyevdwehdvgw d dwhgefvv c erh feiy34tro6134trp1tr137irt01371873 wioe', 'незапочнат'),
(37, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(38, ' Ime na proekt', '2', 'opisanie novo dopulnenie', 'незапочнат'),
(39, ' Система за управление на изисквания', '1', 'Подробно описание на системата; допълнително описание sasssssssssssssssssssssssssssssssssssssssssssssss saaaaaaaaaaaaaaaaaaaan  jk ;ns hka;ssss h hd hwbdhwq 3nxajsnjad hdw yqwd yuwqg dy e wyweyogwgydygewyqweygdgwyevdwehdvgw d dwhgefvv c erh feiy34tro6134trp1tr137irt01371873 wioe', 'незапочнат'),
(40, ' App Store', '51', 'Създайте приложение с приложения; dopulnitelno', 'чернова'),
(41, ' Ime na proekt', '2', 'opisanie novo dopulnenie', 'незапочнат');

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  `priority` varchar(20) NOT NULL,
  `layer` varchar(30) NOT NULL,
  `story` varchar(200) NOT NULL,
  `number` int(11) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `tags` varchar(1000) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`id`, `name`, `project_id`, `priority`, `layer`, `story`, `number`, `description`, `tags`, `type`) VALUES
(16, '', 21, 'Must Have', 'Бизнес логика', '', 0, '', '', 'Функционално'),
(106, 'Много важно изискване', 29, 'NICE_TO_HAVE', 'Бизнес логика', 'Потребителят иска да има яко нещо', 0, 'Описание на изискването', '#requirement #tag', 'Функционално'),
(107, '', 30, 'Must Have', 'Бизнес логика', '', 0, '', '', 'Нефункционално'),
(108, '', 30, 'Must Have', 'Бизнес логика', '', 0, '', '', 'Нефункционално'),
(109, 'Начална страница', 1, 'Must Have', 'Бизнес логика', 'Като потребител искам да мога да въведа своите данни, с които да вляза в системата и да имам достъп до функционалностите на приложението.', 0, 'Привлекателно изглеждаща страница; подходящи съобщения при валидни/невалидни данни;', '#login #newuser #credentials', 'Функционално'),
(110, 'Високо ниво на сигурност', 1, 'Must Have', 'Клиентски', 'Като потребител искам информацията ми да бъде защитена', 0, 'Защита от хакери и злонамерени атаки', '#security', 'Нефункционално');

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
  `id` int(11) NOT NULL,
  `assigned_project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role_id`, `email`, `id`, `assigned_project_id`) VALUES
('eas@adsa.csda', 0x2432792431302437526a323032385172386e6576455677556444724c2e71424245626567786d5944456c4b5948714b363442, 2, 'ad@adsa.sda', 1, NULL),
('dsad', 0x24327924313024594c32757374303332332e32654a70466b71714f58655549414735566d57334e6837576a6b726a64743571, 2, 'ds@ads.com', 2, NULL),
('dsad', 0x24327924313024516e59694a7534707a735342454c7263456a50715a4f524b57556c514b4e71665162652f35385663556a36, 2, 'ds@ads.com', 3, NULL),
('dsad', 0x24327924313024306b484153435643734876474d5a597a53354c30527536577930386944546d4f6871504e2f70682f495434, 2, 'ds@ads.com', 4, NULL),
('dsadaaaaaa', 0x24327924313024617962476171714772687371426866783831697443657a744e773475364636335248326574384f32694769, 2, 'ds@ads.com', 5, NULL),
('dsad', 0x243279243130243142517566557768765761436d597734752e7178582e384550655a352e7464752f486e6137306259797036, 2, 'ds@ads.com', 6, NULL),
('dsad', 0x243279243130244f4e6d324349574c726e354e79792e35505967773575534e644d72384248513178565575744e6c32725266, 2, 'ds@ads.com', 7, NULL),
('dsaddadas', 0x24327924313024637775786a393053743738676355694f42706377472e473037315670326b6245346256793971736c415957, 2, 'ds@ads.co', 8, NULL),
('dsad', 0x243279243130244a554458765657712f6538472f6652724e71744655652e784a712f677844506a4b617a57536866596b4563, 2, 'ds@ads.com', 9, NULL),
('bob', 0x243279243130244f4c613469575844326b5274536a5361586d7556414f366b6d39627842707730503953632f416c31496e4a, 1, 'bob@bob.com', 10, NULL),
('ina', 0x243279243130244459732e72624b52305369444b6277387a6f763159656137356a4b39645a746f4b53334a5a717645364244, 2, 'ina@ina.com', 11, NULL),
('ina', 0x2432792431302472356e4e314d5347625964485a62486674434162622e4f2f4f354e6c63544c4e772e5945347a334a336745, 2, 'ina@ina.com', 12, NULL),
('ina21', 0x2432792431302435334d66484f7276516362704a595334314a374f724f5a534b5942676a566b5149554a6b674a46577671335a4f657438697378492e, 2, 'ina21@mail.com', 13, NULL),
('user', 0x2432792431302442436c75433142794b77436c52387a76325a465356657865776837666e76692f4a2f56566f4d6130316457694841325732486f7632, 2, 'user@mail.com', 14, NULL),
('admin', 0x2432792431302475577952304d316e784a36597a57397537597763342e744967515473314a572f72666d78674b4c6f52526541596f62546c4137692e, 2, 'admin@gmail.com', 15, NULL),
('ina212', 0x24327924313024632e76507867487a7831443435304e2f584b6d43616565663854635a767a6a367048764d6e455877714a63306c585535514b555a2e, 2, 'ina212@mail.bg', 16, NULL),
('inaina', 0x24327924313024595776496e51367236646951745a6f2f4b786330432e345146432e4a4e4151472f63312f466672414837486a58696f4c2f6a38684f, 2, 'ina@ina.bg', 17, NULL),
('inka', 0x243279243130246f75486472426c575038457a35764a664749684a7075674377365536514f714a7233715770754a52516d4f41596e5238574d505557, 1, 'ina@ina.us', 18, 30),
('i21', 0x24327924313024706f7774336252533232734c435934497754344c424f7734787848514d736759586948426c756974787a42454838776c5547545071, 2, 'i21@21.io', 19, 29);

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
  ADD KEY `role_id` (`role_id`),
  ADD KEY `project_user` (`assigned_project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `project_user` FOREIGN KEY (`assigned_project_id`) REFERENCES `projects` (`id`) ON UPDATE SET NULL,
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
