-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Ноя 03 2024 г., 15:33
-- Версия сервера: 5.7.24
-- Версия PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `project_m`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `author` text,
  `content` text NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `author`, `content`, `date`) VALUES
(16, '1223', 'YalpYasis', '123123', '2024-09-28'),
(17, 'New Article', 'YalpYasis', '<p><strong>Salam <em>малейкум)</em></strong></p>\r\n\r\n<p><s>Пидоры</s></p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>хехе</td>\r\n			<td>хаха</td>\r\n		</tr>\r\n		<tr>\r\n			<td>hehe</td>\r\n			<td>haha</td>\r\n		</tr>\r\n		<tr>\r\n			<td>ХАХАХАХХА</td>\r\n			<td>ХУХУХУХУ</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>', '2024-10-01'),
(18, 'ТЕСТ', 'YalpYasis', '<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТТЕСТТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>м</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>ТЕСТТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>ТЕСТ</p>\r\n\r\n<p>&nbsp;</p>', '2024-10-06');

-- --------------------------------------------------------

--
-- Структура таблицы `article_pictures`
--

CREATE TABLE `article_pictures` (
  `id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `picture` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `article_pictures`
--

INSERT INTO `article_pictures` (`id`, `article_id`, `picture`) VALUES
(11, 16, './uploads/1727530302popa.png'),
(12, 16, './uploads/1727530302sigma.png'),
(13, 16, './uploads/1727530302фффффффффффф1.png'),
(14, 17, './uploads/1727785030джидай.png'),
(15, 17, './uploads/1727785030Дулас2.png'),
(16, 18, './uploads/1728214877dulas.png'),
(17, 18, './uploads/1728214877NG.png'),
(18, 18, './uploads/1728214877popa.png'),
(19, 18, './uploads/1728214877sigma.png'),
(20, 18, './uploads/1728214877джидай.png'),
(21, 18, './uploads/1728214877сиджей.png'),
(22, 18, './uploads/1728214877фффффффффффф.png'),
(23, 18, './uploads/1728214877фффффффффффф1.png'),
(24, 18, './uploads/1728214877фффффффффффф2.png');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `article_id`, `parent_id`, `content`, `created_at`) VALUES
(1, 1, 18, NULL, 'test1', '2024-11-01 10:22:56'),
(2, 1, 18, NULL, 'test2', '2024-11-01 10:23:32'),
(3, 1, 18, NULL, 'test3', '2024-11-01 10:24:12'),
(4, 1, 18, 3, 'ответ1', '2024-11-01 10:30:41'),
(5, 1, 18, 4, 'ответ2', '2024-11-01 10:34:41'),
(6, 1, 18, 2, 'бууу', '2024-11-01 10:34:59'),
(7, 1, 18, 5, 'МНОООГО\nСТРОООК\nХЕХЕХЕ', '2024-11-01 10:41:41'),
(8, 1, 18, 7, 'ТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТТЕСТ', '2024-11-01 10:42:01'),
(9, 3, 18, NULL, 'new test', '2024-11-01 10:57:33'),
(10, 3, 18, 1, 'ответ', '2024-11-01 10:57:48');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` text,
  `allowRead` int(11) DEFAULT NULL,
  `allowCreate` int(11) DEFAULT NULL,
  `allowDelete` int(11) DEFAULT NULL,
  `allowWriteComm` int(11) DEFAULT NULL,
  `editPermission` int(11) DEFAULT NULL,
  `allowBan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `allowRead`, `allowCreate`, `allowDelete`, `allowWriteComm`, `editPermission`, `allowBan`) VALUES
(0, 'Default', 1, 0, 0, 1, 0, 0),
(3, 'SuperAdmin', 1, 1, 1, 1, 1, 1),
(4, 'Creator', 1, 1, 1, 1, 0, 0),
(5, 'Ban', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(55) DEFAULT NULL,
  `password` text,
  `email` text,
  `role` int(11) DEFAULT NULL,
  `picture` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `picture`) VALUES
(1, 'YalpYasis', '$2y$10$brZPG41LfraUQP2dHyCG7ujRuJ2V7B.96ZMiaJ0jrI979087ZkIya', '123@qwe.xz', 3, '../uploads/1_1729430971.jpg'),
(3, 'test', '$2y$10$IHrGH/H0BF1bG24hx3B0vuudcyT4EleYgLlH6Xxs9bqGYcv2K4JyG', 'test@aa.cz', 0, '../uploads/3_1729848703.jpeg'),
(4, 'test2', '$2y$10$RqVPBTgDzYYbwmaeIC697.IIbyspeUOL0AiHKGFFavtw9EsCxum32', 'test@aa.cz1', 4, 'assets/img/usericon.png'),
(5, 'test3', '$2y$10$KXRsYJoCSdbcsiKv5Bj2JOva4cxDU6qEUi2g/888kk51en5MNv6ri', 'test@aa.cz', 3, 'assets/img/usericon.png'),
(6, 'test4', '$2y$10$oEqrtMYHzmdILeKbbYTLMusZo5GvSoxsfaOs8J.2Ry1QzRMgFexfm', 'test@aa.cz', 0, 'assets/img/usericon.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `article_pictures`
--
ALTER TABLE `article_pictures`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
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
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `article_pictures`
--
ALTER TABLE `article_pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
