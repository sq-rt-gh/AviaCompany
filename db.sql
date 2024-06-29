-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Июн 19 2024 г., 08:14
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `AviaCompany`
--

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` int NOT NULL,
  `from` varchar(20) NOT NULL,
  `destination` varchar(20) NOT NULL,
  `departure` timestamp NOT NULL,
  `arrival` timestamp NOT NULL,
  `plane_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `flights`
--

INSERT INTO `flights` (`id`, `from`, `destination`, `departure`, `arrival`, `plane_id`) VALUES
(1, 'Москва', 'Санкт-Петербург', '2024-07-01 15:00:00', '2024-07-01 17:00:00', 3),
(2, 'Москва', 'Санкт-Петербург', '2024-06-28 08:30:00', '2024-06-28 10:30:00', 1),
(3, 'Санкт-Петербург', 'Екатеринбург', '2024-06-30 06:00:00', '2024-06-30 10:30:00', 2),
(4, 'Новосибирск', 'Красноярск', '2024-06-13 11:45:00', '2024-06-13 14:45:00', 3),
(5, 'Казань', 'Уфа', '2024-06-14 11:30:00', '2024-06-14 14:00:00', 4),
(6, 'Владивосток', 'Хабаровск', '2024-06-15 07:00:00', '2024-06-15 09:00:00', 3),
(7, 'Сочи', 'Москва', '2024-06-16 12:00:00', '2024-06-16 16:00:00', 2),
(8, 'Новосибирск', 'Екатеринбург', '2024-06-17 04:00:00', '2024-06-17 09:00:00', 4),
(9, 'Санкт-Петербург', 'Москва', '2024-06-16 06:00:00', '2024-06-16 08:45:00', 2),
(10, 'Хабаровск', 'Владивосток', '2024-06-20 08:00:00', '2024-06-20 10:00:00', 3),
(11, 'Екатеринбург', 'Сочи', '2024-06-13 11:00:00', '2024-06-13 18:00:00', 1),
(12, 'Москва', 'Сочи', '2024-06-14 13:00:00', '2024-06-14 17:00:00', 3),
(13, 'Казань', 'Уфа', '2024-06-17 18:00:00', '2024-06-17 20:00:00', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `planes`
--

CREATE TABLE `planes` (
  `id` int NOT NULL,
  `model` varchar(20) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `planes`
--

INSERT INTO `planes` (`id`, `model`, `img`) VALUES
(1, 'ИЛ-62', 'il-62.jpg'),
(2, 'МС-21', 'mc-21.jpg'),
(3, 'Суперджет-100', 'superjet-100.jpg'),
(4, 'ТУ-204', 'tu-204.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `flight_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `is_admin`) VALUES
(1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1); -- password: 'admin'

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_plane` (`plane_id`);

--
-- Индексы таблицы `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `planes`
--
ALTER TABLE `planes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `FK_plane` FOREIGN KEY (`plane_id`) REFERENCES `planes` (`id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
