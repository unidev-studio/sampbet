-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Фев 02 2020 г., 11:15
-- Версия сервера: 5.7.28-0ubuntu0.18.04.4
-- Версия PHP: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `samp-bet`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL DEFAULT 'N/A',
  `password` varchar(128) NOT NULL DEFAULT 'N/A',
  `ip` varchar(42) NOT NULL DEFAULT '127.0.0.1',
  `keydash` varchar(256) NOT NULL DEFAULT 'N/A',
  `username` varchar(32) NOT NULL DEFAULT 'N/A',
  `welcome` varchar(256) NOT NULL DEFAULT '',
  `sum` decimal(10,2) NOT NULL DEFAULT '1.00',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `promo` varchar(32) NOT NULL DEFAULT 'SYSTEM',
  `commission_draw` int(11) NOT NULL DEFAULT '7',
  `commission_withdraw` int(11) NOT NULL DEFAULT '10',
  `last_online` datetime DEFAULT NULL,
  `moder` int(11) NOT NULL DEFAULT '0',
  `moder_catid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `moderator` varchar(32) NOT NULL DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `position`, `moderator`) VALUES
(1, '[C/B] Evolve-Rp 01', 0, 'vk.com/tellarion'),
(2, '[C/B] Evolve-Rp 02', 0, 'vk.com/tellarion'),
(3, '[C/B] Evolve-Rp 03', 0, 'vk.com/tellarion'),
(4, '[Capture] Diamond Ruby', 0, 'vk.com/tellarion'),
(5, '[Capture] Diamond Sapphire', 0, 'vk.com/tellarion'),
(6, '[Capture] Advance Red', 0, 'vk.com/tellarion');

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `interkassa` varchar(20) NOT NULL DEFAULT 'N/A',
  `hash` varchar(50) NOT NULL DEFAULT 'N/A',
  `email` varchar(128) NOT NULL DEFAULT 'N/A',
  `type` int(11) NOT NULL DEFAULT '0',
  `username` varchar(32) NOT NULL,
  `content` varchar(256) NOT NULL,
  `sum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `method` varchar(48) NOT NULL DEFAULT 'N/A',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cur` varchar(12) NOT NULL DEFAULT 'RUB',
  `alert` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `datefirst` datetime NOT NULL DEFAULT '2019-04-14 00:00:00',
  `datesecond` datetime NOT NULL DEFAULT '2019-04-14 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `data` varchar(1024) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `bank` int(11) NOT NULL,
  `zp` int(11) NOT NULL DEFAULT '0',
  `timeref` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `alert` int(11) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `winner_id` int(11) NOT NULL DEFAULT '-1',
  `name` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `about` varchar(5000) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `min_value` int(11) NOT NULL DEFAULT '50',
  `variations` varchar(1024) CHARACTER SET utf8 NOT NULL DEFAULT '[]',
  `coff` varchar(1024) CHARACTER SET utf8 NOT NULL DEFAULT '[]',
  `bets` varchar(10000) CHARACTER SET utf8 NOT NULL DEFAULT '[]',
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_chat`
--

CREATE TABLE `sessions_chat` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `username` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `message` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `date_post` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_online`
--

CREATE TABLE `sessions_online` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL DEFAULT '-1',
  `user_id` int(11) NOT NULL DEFAULT '-1',
  `date_last` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `share`
--

CREATE TABLE `share` (
  `id` int(11) NOT NULL,
  `alert` int(11) NOT NULL DEFAULT '0',
  `author` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `message` text CHARACTER SET utf8 NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `share_vk`
--

CREATE TABLE `share_vk` (
  `id` int(11) NOT NULL,
  `peer_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `members` int(11) NOT NULL DEFAULT '0',
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `admins` varchar(1024) CHARACTER SET utf8 NOT NULL DEFAULT 'N/A',
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(56) NOT NULL DEFAULT '127.0.0.1',
  `unixtime` int(11) NOT NULL,
  `verif` int(11) NOT NULL DEFAULT '0',
  `verif_code` varchar(72) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int(11) NOT NULL,
  `interkassa` varchar(32) NOT NULL DEFAULT 'N/A',
  `email` varchar(128) NOT NULL DEFAULT 'N/A',
  `method` varchar(20) NOT NULL DEFAULT 'N/A',
  `addr` varchar(32) NOT NULL DEFAULT 'N/A',
  `input` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(11) NOT NULL DEFAULT '0',
  `datefirst` datetime NOT NULL DEFAULT '2019-04-14 00:00:00',
  `datesecond` datetime NOT NULL DEFAULT '2019-04-14 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions_chat`
--
ALTER TABLE `sessions_chat`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `sessions_online`
--
ALTER TABLE `sessions_online`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `share_vk`
--
ALTER TABLE `share_vk`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sessions_chat`
--
ALTER TABLE `sessions_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sessions_online`
--
ALTER TABLE `sessions_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `share`
--
ALTER TABLE `share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `share_vk`
--
ALTER TABLE `share_vk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
