-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Окт 21 2024 г., 17:18
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
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` text,
  `allowCreate` int(11) DEFAULT NULL,
  `allowDelete` int(11) DEFAULT NULL,
  `allowWriteComm` int(11) DEFAULT NULL,
  `editPermission` int(11) DEFAULT NULL,
  `allowBan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `allowCreate`, `allowDelete`, `allowWriteComm`, `editPermission`, `allowBan`) VALUES
(3, 'SuperAdmin', 1, 1, 1, 1, 1);

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
(1, 'YalpYasis', '$2y$10$brZPG41LfraUQP2dHyCG7ujRuJ2V7B.96ZMiaJ0jrI979087ZkIya', '123@qwe.xz', 3, '../uploads/1_1729430971.jpg');

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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
