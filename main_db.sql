-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 23 2018 г., 16:10
-- Версия сервера: 10.1.37-MariaDB-0+deb9u1
-- Версия PHP: 7.0.33-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `main_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `hashs`
--

CREATE TABLE `hashs` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `sname` varchar(25) NOT NULL,
  `lname` varchar(25) DEFAULT NULL,
  `hash` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hashs`
--

INSERT INTO `hashs` (`id`, `name`, `sname`, `lname`, `hash`, `time`, `ip`) VALUES
(33, 'Тимофей', 'Пашков', 'Николаевич', '0x78e2b26453bb156bf06cc1b606daf8ab68de3c56d37a964da7731218d816b95b', '2018-12-23 09:45:22', '77.234.212.37'),
(34, 'Роман', 'Богданов', 'Александрович', '0x0e83360e43b936d5b1e99230af06281e304505b8f3c2245c56c251db676c1ebc', '2018-12-23 09:45:56', '77.234.212.37'),
(35, 'Игорь', 'Тагин', 'Юрьевич', '0xac31f8edcc4064f55db97d726d502e48596a58f6c3d6897e7834b6b48e17ad45', '2018-12-23 09:46:25', '77.234.212.37'),
(36, 'Владимир', 'Путин', 'Владимирович', '0xf19b8cf0c1f6ba5871fe4bd61efa4914e80efd5a011f6694aa047e1049d1b2c7', '2018-12-23 09:49:27', '77.234.212.37'),
(38, 'Igor', 'Tagin', 'Yurievich', '0x8c63270c9c12e51b0229a79f3ba7ac38324e94d24ceea6f72dc584e589b54047', '2018-12-23 12:25:19', '77.234.212.37'),
(39, 'Igor', 'Tagin', 'Yurievich', '0xdc87701a30f3a94f5191fee78bb5eb5491e658f97a13c809c0808b84d2e4ed2a', '2018-12-23 12:27:16', '77.234.212.37'),
(40, 'Ivan', 'Ivanov', 'Ivanovic', '0x783b1f2df830b55e6b53bae4f273b006467fe64c8f11eb33225483896acd4a0f', '2018-12-23 12:41:58', '77.234.212.34');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `pass` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`) VALUES
(1, 'wadaadmin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
(2, 'user1', 'b3daa77b4c04a9551b8781d03191fe098f325e67'),
(3, 'user2', 'a1881c06eec96db9901c7bbfe41c42a3f08e9cb4'),
(4, 'user3', '0b7f849446d3383546d15a480966084442cd2193');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `hashs`
--
ALTER TABLE `hashs`
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
-- AUTO_INCREMENT для таблицы `hashs`
--
ALTER TABLE `hashs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
