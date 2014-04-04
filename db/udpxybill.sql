-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 04 2014 г., 11:49
-- Версия сервера: 5.6.15-log
-- Версия PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `udpxybill`
--

-- --------------------------------------------------------

--
-- Структура таблицы `allowed_list`
--

CREATE TABLE IF NOT EXISTS `allowed_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descr` varchar(32) NOT NULL,
  `ip_start` int(11) NOT NULL,
  `ip_end` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `allowed_list`
--

INSERT INTO `allowed_list` (`id`, `descr`, `ip_start`, `ip_end`) VALUES
(1, 'BaydarLan 10.10.10.0/24', 168430080, 168430334);

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`contact`,`ip`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `name`, `contact`, `ip`) VALUES
(1, 'Илья', '0991234567', '10.10.10.254');

-- --------------------------------------------------------

--
-- Структура таблицы `operators`
--

CREATE TABLE IF NOT EXISTS `operators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `login` varchar(64) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65002 ;

--
-- Дамп данных таблицы `operators`
--

INSERT INTO `operators` (`id`, `name`, `login`, `pass`, `status`) VALUES
(1, 'Исаков А. Г.', 'intel', '$2a$13$0N53q56p53C/yCuct2axbeJRzTCO/Oy6X.8zMdspwRgHf.30Ohs6y', 1),
(65000, 'Система', 'system', 'y43gvy7rngv3y7gnvt37ngv37gv6twbrfvdd', 0),
(65001, 'Пусько Илья', 'illya', '$2a$13$w483bPl.AQzCOJKcohoYwuOKxnGRajWAGViykN5BD1Y7c3ryx72te', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_allowed` bigint(20) unsigned NOT NULL,
  `id_tvpack` int(10) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `start_operator` int(10) unsigned NOT NULL,
  `end_operator` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `id_allowed`, `id_tvpack`, `start_date`, `end_date`, `status`, `start_operator`, `end_operator`) VALUES
(1, 1, 0, 1, '2014-03-26 00:00:00', '2014-04-30 07:21:58', 1, 65001, 65000),
(2, 1, 0, 2, '2014-03-26 00:00:00', '2014-03-26 19:23:22', 0, 65001, 65001),
(3, 0, 1, 1, '2014-04-03 00:00:00', '2014-04-04 16:48:30', 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tvpack`
--

CREATE TABLE IF NOT EXISTS `tvpack` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `descr` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tvpack`
--

INSERT INTO `tvpack` (`id`, `name`, `descr`) VALUES
(1, 'Тест', 'Тестовый тариф'),
(2, 'FreeTV', 'Свободные каналы');

-- --------------------------------------------------------

--
-- Структура таблицы `tvpack_list`
--

CREATE TABLE IF NOT EXISTS `tvpack_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tvpack` int(10) unsigned NOT NULL,
  `ch_name` varchar(32) NOT NULL,
  `m_ip` varchar(15) NOT NULL,
  `m_port` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tvpack_list`
--

INSERT INTO `tvpack_list` (`id`, `id_tvpack`, `ch_name`, `m_ip`, `m_port`) VALUES
(1, 1, 'НТВ+ Теннис', '233.191.133.14', 1234),
(2, 2, 'СТВ', '238.1.1.4', 1234);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
