-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 15 2024 г., 21:38
-- Версия сервера: 8.0.40-0ubuntu0.20.04.1
-- Версия PHP: 7.4.3-4ubuntu2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myHome`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `text` varchar(2500) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `title`, `text`, `state`, `date`, `category`) VALUES
(18, 'mam problem so svetlom', 'qqqqqqqqqqqqq', 'Vyhotovené', '07.10.24', 'light'),
(19, 'qqqqqqqq', 'qqqqqqqqqqqqq', 'Nová', '09.10.24', 'none');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`) VALUES
(1, 'Dispečer (výtah)', '', '227-28-55'),
(2, 'Havarijná služba (výtah)', '', '209-19-38'),
(3, 'Predsedníčka predstavenstva Gorbunová Oleksandra  ', '', '098-718-34-39'),
(4, 'Hlavná účtovníčka JBK Sidorenková Ľubov Stepanivna', '', '067-492-11-24');

-- --------------------------------------------------------

--
-- Структура таблицы `mainInfo`
--

CREATE TABLE `mainInfo` (
  `title` varchar(150) DEFAULT NULL,
  `text` varchar(3500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `mainInfo`
--

INSERT INTO `mainInfo` (`title`, `text`) VALUES
('OSBB domu na adrese: Kyjev, ul. N. Užvij, 4a', 'Vitáme vás na stránke nášho domu!');

-- --------------------------------------------------------

--
-- Структура таблицы `meter_readings`
--

CREATE TABLE `meter_readings` (
  `id` int NOT NULL,
  `id_u` int NOT NULL,
  `id_t` int NOT NULL,
  `value` double NOT NULL,
  `day` int NOT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `meter_readings`
--

INSERT INTO `meter_readings` (`id`, `id_u`, `id_t`, `value`, `day`, `month`, `year`) VALUES
(1, 1, 1, 52, 11, 12, 24),
(2, 1, 11, 30, 11, 12, 24),
(3, 1, 11, 30, 11, 12, 24),
(4, 1, 2, 5.16, 11, 12, 24),
(5, 1, 11, 30, 15, 12, 24),
(6, 1, 11, 30, 15, 12, 24),
(7, 1, 11, 30, 15, 12, 24),
(8, 1, 11, 30, 15, 12, 24);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int NOT NULL,
  `title` varchar(5000) DEFAULT NULL,
  `text` varchar(5000) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `title`, `text`, `date`) VALUES
(3, 'Vážení obyvatelia!', 'Webová stránka začala fungovať!', '24.10.22'),
(4, 'Vážení obyvatelia!', 'Oznamujeme vám, že prijímanie členov družstva (obyvateľov domu) sa koná každý utorok o 19:00.', '24.10.22'),
(5, 'Vážení obyvatelia!', 'Harmonogram výpadkov elektrickej energie bude pridaný po zverejnení oficiálnych informácií na stránke NЕК \"Ukrenergo\".', '25.10.22');

-- --------------------------------------------------------

--
-- Структура таблицы `question`
--

CREATE TABLE `question` (
  `id` int NOT NULL,
  `question` varchar(500) DEFAULT NULL,
  `fVariantAnswear` varchar(200) DEFAULT NULL,
  `sVariantAnswear` varchar(200) DEFAULT NULL,
  `fData` varchar(10) DEFAULT NULL,
  `sData` varchar(10) DEFAULT NULL,
  `users` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `question`
--

INSERT INTO `question` (`id`, `question`, `fVariantAnswear`, `sVariantAnswear`, `fData`, `sData`, `users`) VALUES
(1, 'Питання?', 'так', 'нет', '2', '4', 'Vlad');

-- --------------------------------------------------------

--
-- Структура таблицы `rule`
--

CREATE TABLE `rule` (
  `id` int NOT NULL,
  `state` varchar(1000) DEFAULT NULL,
  `name` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `rule`
--

INSERT INTO `rule` (`id`, `state`, `name`) VALUES
(9, 'Predseda predstavenstva', 'Gorbunová Oleksandra Leonidovna'),
(10, 'Zástupca predsedu predstavenstva', 'Martinčenko Volodymyr Mykolajovyč'),
(11, 'Člen predstavenstva', 'Babiaková Oľga Mykolajivna'),
(12, 'Člen predstavenstva', 'Hyryščenko Oleksandr Hryhorovyč'),
(13, 'Člen predstavenstva', 'Tonkodubová Ľubov Vasylivna');

-- --------------------------------------------------------

--
-- Структура таблицы `tariffs`
--

CREATE TABLE `tariffs` (
  `id` int NOT NULL,
  `name` varchar(1000) NOT NULL,
  `ms` varchar(100) NOT NULL,
  `tariff` double NOT NULL,
  `hasMeter` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tariffs`
--

INSERT INTO `tariffs` (`id`, `name`, `ms`, `tariff`, `hasMeter`) VALUES
(1, 'Elektrická energia', 'kWh', 1.789, 1),
(2, 'Údržba domu', 'м²', 5.16, 0),
(11, 'Wifi', 'Gb', 30, 0),
(12, 'tarifa', 'tt', 19, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `isAdmin`) VALUES
(4, 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 1),
(6, 'test user', 'testuser@gmail.com', '05a671c66aefea124cc08b76ea6d30bb', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `meter_readings`
--
ALTER TABLE `meter_readings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rule`
--
ALTER TABLE `rule`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `meter_readings`
--
ALTER TABLE `meter_readings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `question`
--
ALTER TABLE `question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `rule`
--
ALTER TABLE `rule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
