-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 28 2013 г., 15:47
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP DATABASE `gemsontime`;
CREATE DATABASE `gemsontime` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gemsontime`;

--
-- База данных: `gemsontime`
--

-- --------------------------------------------------------

--
-- Структура таблицы `event`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `venueid` int(10) DEFAULT '0',
  `exturl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `startdate`, `enddate`, `venueid`, `exturl`) VALUES
(1, 'Событие 1', NULL, '2013-04-27 18:51:09', NULL, 1, NULL),
(2, 'Событие 2', NULL, '2013-04-24 10:54:11', NULL, 2, NULL),
(3, 'Событие 3', NULL, '2013-04-24 18:04:44', NULL, 1, NULL),
(4, 'Событие 4', NULL, '2013-04-24 21:04:44', NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `event_group`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `event_group`;
CREATE TABLE `event_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `css` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `event_group`
--

INSERT INTO `event_group` (`id`, `name`, `css`) VALUES
(1, 'Отдых', 'leasure'),
(2, 'Развитие', 'advance');

-- --------------------------------------------------------

--
-- Структура таблицы `event_group_type_relation`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `event_group_type_relation`;
CREATE TABLE `event_group_type_relation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) DEFAULT '0',
  `event_type_id` int(10) DEFAULT '0',
  `is_main` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `event_group_type_relation`
--

INSERT INTO `event_group_type_relation` (`id`, `event_id`, `event_type_id`, `is_main`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1),
(4, 4, 4, 1),
(5, 1, 4, 0),
(6, 3, 4, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `event_participant`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `event_participant`;
CREATE TABLE `event_participant` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `event_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `event_participant`
--

INSERT INTO `event_participant` (`id`, `user_id`, `event_id`) VALUES
(1, 1, 1),
(3, 11, 2),
(4, 11, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `event_saved`
--
-- Создание: Апр 27 2013 г., 19:09
--

DROP TABLE IF EXISTS `event_saved`;
CREATE TABLE `event_saved` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `event_saved`
--

INSERT INTO `event_saved` (`id`, `event_id`, `user_id`) VALUES
(1, 1, 1),
(3, 3, 11),
(4, 4, 12),
(6, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `event_type`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE `event_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_group_id` int(10) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `event_type`
--

INSERT INTO `event_type` (`id`, `event_group_id`, `name`) VALUES
(1, 1, 'Прогулки'),
(2, 1, 'Пикник'),
(3, 2, 'Учеба'),
(4, 2, 'Йога');

-- --------------------------------------------------------

--
-- Структура таблицы `friend`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `friend_user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `friend`
--

INSERT INTO `friend` (`id`, `user_id`, `friend_user_id`) VALUES
(1, 1, 11),
(2, 1, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_confirmed` int(11) DEFAULT '0',
  `check_sum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `is_confirmed`, `check_sum`) VALUES
(1, 'overmind', NULL, NULL, 0, NULL),
(11, 'vae', 'd02ebea7e0bbaae74b0b66bd512f79b5', 'vaterloo.inc@gmail.com', 1, '1a2afb232e97c4952cf72bb1dd0f11e1'),
(12, 'alexzo', '384fdbc7ac263a6b2c86203da63be7a6', 'leshazotov@gmail.com', 1, 'ab6fc1f4ed469be4ab1ab6874b8f890c');

-- --------------------------------------------------------

--
-- Структура таблицы `venue`
--
-- Создание: Мар 05 2013 г., 04:11
--

DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `venue` varchar(255) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `venue`
--

INSERT INTO `venue` (`id`, `venue`, `address`) VALUES
(1, 'Клуб "Культ"', 'Москва, Яузская улица, дом 5'),
(2, 'Клуб "Джао Да"', 'Москва, Лубянский проезд, дом 25');