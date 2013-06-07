-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 07 2013 г., 09:18
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `gemsontime`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bufEvent`
--

DROP TABLE IF EXISTS `bufEvent`;
CREATE TABLE `bufEvent` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(125) NOT NULL,
  `Descr` varchar(500) DEFAULT NULL,
  `Startdate` varchar(32) DEFAULT NULL,
  `Enddate` varchar(32) DEFAULT NULL,
  `Venue` varchar(125) DEFAULT NULL,
  `Url` varchar(125) DEFAULT NULL,
  `Type0` varchar(125) DEFAULT NULL,
  `Type1` varchar(125) DEFAULT NULL,
  `Type2` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Дамп данных таблицы `bufEvent`
--

INSERT INTO `bufEvent` (`ID`, `Name`, `Descr`, `Startdate`, `Enddate`, `Venue`, `Url`, `Type0`, `Type1`, `Type2`) VALUES
(1, 'Идиоты', '', '1.06.2013 20:00', '', 'Гоголь-центр', 'http://www.afisha.ru/msk/schedule_performance_product/94249/', 'Театр', '', ''),
(2, 'Идиоты', '', '2.06.2013 20:00', '', 'Гоголь-центр', 'http://www.afisha.ru/msk/schedule_performance_product/94249/', 'Театр', '', ''),
(3, 'Идиоты', '', '28.06.2013 20:00', '', 'Гоголь-центр', 'http://www.afisha.ru/msk/schedule_performance_product/94249/', 'Театр', '', ''),
(4, 'Ahmad Tea Music Festival', 'Alt-J, Hot Chip, Citizens, The 2 Bears (все - Великобритания)', '1.06.2013 16:00', '', 'Сад Эрмитаж', 'http://www.afisha.ru/concert/859971/', 'Фестиваль', '', ''),
(5, 'World Press Photo 2013', '', '21.05.2013 08:00', '30.06.2013 20:00', 'Красный октябрь', 'http://www.afisha.ru/exhibition/84654/', 'Выставка', 'Фото', ''),
(6, '1/2 Orchestra', '', '7.06.2013 22:00', '', 'Мастерская', 'http://www.afisha.ru/concert/897142/', 'Концерт', 'Джаз', 'Фанк'),
(7, 'OrangeJuice', '', '7.06.2013 21:00', '', 'Bilingua', 'http://www.afisha.ru/msk/schedule_concert/07-06-2013/#cHJvY0dlbnJlRmlsdGVyPTEyNDQ5fNCk0LDQvdC6', 'Концерт', 'Джаз', 'Босса-нова'),
(8, 'Дикая мята-2013', '', '7.06.2013', '9.06.2013', 'Этномир', 'http://www.mintmusic.ru', 'Фестиваль', 'Музыка', ''),
(9, 'Зеленая неделя-2013', '', '3.06.2013', '9.06.2013', 'Парк Горького', 'http://www.park-gorkogo.com/greenweek/', 'Фестиваль', '', ''),
(10, 'Alisa Franka', '', '6.06.2013 21:10', '', 'Парк Горького', 'http://www.afisha.ru/concert/897558/', 'Концерт', 'Фолк', 'Трип-хоп'),
(11, 'Anadi Nad', '', '6.06.2013 20:30', '', 'Парк Горького', 'http://www.afisha.ru/concert/897559/', 'Концерт', 'Этно', ''),
(12, 'Teenage', '', '6.06.2013 20:00', '', 'Формула кино Горизонт', 'http://2013.beatfilmfestival.ru/movies/teenage/', 'Кинопоказ', 'Документальное', ''),
(13, 'Teenage', '', '9.06.2013 17:00', '', 'Формула кино Горизонт', 'http://2013.beatfilmfestival.ru/movies/teenage/', 'Кинопоказ', 'Документальное', ''),
(14, 'Лондон - современный вавилон', 'Нарезка хроник и фильмов', '10.06.2013 19:00', '', 'Центр документального кино', 'http://2013.beatfilmfestival.ru/movies/london-the-modern-babylon/', 'Кинопоказ', 'Документальное', ''),
(15, 'Гластонбери', 'Про британский музыкальный фестиваль', '11.06.2013 17:30', '', 'Центр документального кино', 'http://2013.beatfilmfestival.ru/movies/glastonbury/', 'Кинопоказ', 'Документальное', ''),
(16, 'Beat Film Festival-2013', 'Фестиваль документального кино о музыке', '6.06.2013', '11.06.2013', '', 'http://2013.beatfilmfestival.ru', '', 'Фестиваль', 'Кино'),
(17, 'Дизайн упаковки. Сделано в России', 'Образцы упаковок советского и до-советского периодов', '1.06.2013', '25.06.2013', 'Манеж', 'http://www.afisha.ru/exhibition/84438/', 'Выставка', 'Пром-дизайн', ''),
(18, 'Сны для тех, кто бодрствует', '', '1.06.2013', '24.11.2013', 'ММСИ на Петровке', 'http://www.afisha.ru/exhibition/83466/', 'Выставка', 'Фото', 'Инсталяции');

-- --------------------------------------------------------

--
-- Структура таблицы `event`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Дамп данных таблицы `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `startdate`, `enddate`, `venueid`, `exturl`) VALUES
(29, 'Идиоты', '', '2013-06-01 20:00:00', '2013-06-01 22:00:00', 4, 'http://www.afisha.ru/msk/schedule_performance_product/94249/'),
(30, 'Идиоты', '', '2013-06-02 20:00:00', '2013-06-02 22:00:00', 4, 'http://www.afisha.ru/msk/schedule_performance_product/94249/'),
(31, 'Идиоты', '', '2013-06-28 20:00:00', '2013-06-28 22:00:00', 4, 'http://www.afisha.ru/msk/schedule_performance_product/94249/'),
(32, 'Ahmad Tea Music Festival', 'Alt-J, Hot Chip, Citizens, The 2 Bears (все - Великобритания)', '2013-06-01 16:00:00', '2013-06-01 18:00:00', 8, 'http://www.afisha.ru/concert/859971/'),
(33, 'World Press Photo 2013', '', '2013-05-21 08:00:00', '2013-06-30 20:00:00', 9, 'http://www.afisha.ru/exhibition/84654/'),
(34, '1/2 Orchestra', '', '2013-06-07 22:00:00', '2013-06-08 00:00:00', 10, 'http://www.afisha.ru/concert/897142/'),
(35, 'OrangeJuice', '', '2013-06-07 21:00:00', '2013-06-07 23:00:00', 11, 'http://www.afisha.ru/msk/schedule_concert/07-06-2013/#cHJvY0dlbnJlRmlsdGVyPTEyNDQ5fNCk0LDQvdC6'),
(36, 'Дикая мята-2013', '', '2013-06-07 00:00:00', '2013-06-09 00:00:00', 12, 'http://www.mintmusic.ru'),
(37, 'Зеленая неделя-2013', '', '2013-06-03 00:00:00', '2013-06-09 00:00:00', 3, 'http://www.park-gorkogo.com/greenweek/'),
(38, 'Alisa Franka', '', '2013-06-06 21:10:00', '2013-06-06 23:10:00', 3, 'http://www.afisha.ru/concert/897558/'),
(39, 'Anadi Nad', '', '2013-06-06 20:30:00', '2013-06-06 22:30:00', 3, 'http://www.afisha.ru/concert/897559/'),
(40, 'Teenage', '', '2013-06-06 20:00:00', '2013-06-06 22:00:00', 13, 'http://2013.beatfilmfestival.ru/movies/teenage/'),
(41, 'Teenage', '', '2013-06-09 17:00:00', '2013-06-09 19:00:00', 13, 'http://2013.beatfilmfestival.ru/movies/teenage/'),
(42, 'Лондон - современный вавилон', 'Нарезка хроник и фильмов', '2013-06-10 19:00:00', '2013-06-10 21:00:00', 14, 'http://2013.beatfilmfestival.ru/movies/london-the-modern-babylon/'),
(43, 'Гластонбери', 'Про британский музыкальный фестиваль', '2013-06-11 17:30:00', '2013-06-11 19:30:00', 14, 'http://2013.beatfilmfestival.ru/movies/glastonbury/'),
(44, 'Beat Film Festival-2013', 'Фестиваль документального кино о музыке', '2013-06-06 00:00:00', '2013-06-11 00:00:00', NULL, 'http://2013.beatfilmfestival.ru'),
(45, 'Дизайн упаковки. Сделано в России', 'Образцы упаковок советского и до-советского периодов', '2013-06-01 00:00:00', '2013-06-25 00:00:00', 15, 'http://www.afisha.ru/exhibition/84438/'),
(46, 'Сны для тех, кто бодрствует', '', '2013-06-01 00:00:00', '2013-11-24 00:00:00', 16, 'http://www.afisha.ru/exhibition/83466/');

-- --------------------------------------------------------

--
-- Структура таблицы `event_group`
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

DROP TABLE IF EXISTS `event_group_type_relation`;
CREATE TABLE `event_group_type_relation` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) DEFAULT '0',
  `event_type_id` int(10) DEFAULT '0',
  `is_main` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- Дамп данных таблицы `event_group_type_relation`
--

INSERT INTO `event_group_type_relation` (`id`, `event_id`, `event_type_id`, `is_main`) VALUES
(81, 29, 5, 1),
(82, 30, 5, 1),
(83, 31, 5, 1),
(84, 32, 9, 1),
(85, 33, 7, 1),
(86, 34, 1, 1),
(87, 33, 10, 0),
(88, 35, 1, 1),
(89, 36, 9, 1),
(90, 37, 9, 1),
(91, 38, 1, 1),
(92, 39, 1, 1),
(93, 34, 13, 0),
(94, 35, 13, 0),
(95, 36, 14, 0),
(96, 38, 15, 0),
(97, 39, 16, 0),
(98, 40, 12, 1),
(99, 41, 12, 1),
(100, 42, 12, 1),
(101, 43, 12, 1),
(102, 45, 7, 1),
(103, 40, 17, 0),
(104, 41, 17, 0),
(105, 42, 17, 0),
(106, 43, 17, 0),
(107, 44, 9, 0),
(108, 46, 7, 1),
(109, 45, 18, 0),
(110, 46, 10, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `event_participant`
--

DROP TABLE IF EXISTS `event_participant`;
CREATE TABLE `event_participant` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `event_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `event_participant`
--

INSERT INTO `event_participant` (`id`, `user_id`, `event_id`) VALUES
(38, 1, 29),
(39, 1, 30),
(40, 1, 31),
(41, 1, 32),
(42, 1, 33),
(43, 1, 34),
(44, 1, 35),
(45, 1, 36),
(46, 1, 37),
(47, 1, 38),
(48, 1, 39),
(49, 1, 40),
(50, 1, 41),
(51, 1, 42),
(52, 1, 43),
(53, 1, 44),
(54, 1, 45),
(55, 1, 46);

-- --------------------------------------------------------

--
-- Структура таблицы `event_saved`
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

DROP TABLE IF EXISTS `event_type`;
CREATE TABLE `event_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_group_id` int(10) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `event_type`
--

INSERT INTO `event_type` (`id`, `event_group_id`, `name`) VALUES
(1, 1, 'Концерт'),
(2, 1, 'Пикник'),
(3, 2, 'Учеба'),
(4, 2, 'Йога'),
(5, 1, 'Театр'),
(7, 2, 'Выставка'),
(9, 1, 'Фестиваль'),
(10, 1, 'Фото'),
(12, 2, 'Кинопоказ'),
(13, 1, 'Джаз'),
(14, 1, 'Музыка'),
(15, 1, 'Фолк'),
(16, 1, 'Этно'),
(17, 1, 'Документальное'),
(18, 1, 'Пром-дизайн');

-- --------------------------------------------------------

--
-- Структура таблицы `friend`
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

DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `venue` varchar(255) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `venue`
--

INSERT INTO `venue` (`id`, `venue`, `address`) VALUES
(1, 'Клуб "Культ"', 'Москва, Яузская улица, дом 5'),
(2, 'Клуб "Джао Да"', 'Москва, Лубянский проезд, дом 25'),
(3, 'Парк Горького', NULL),
(4, 'Гоголь-центр', NULL),
(8, 'Сад Эрмитаж', NULL),
(9, 'Красный октябрь', NULL),
(10, 'Мастерская', NULL),
(11, 'Bilingua', NULL),
(12, 'Этномир', NULL),
(13, 'Формула кино Горизонт', NULL),
(14, 'Центр документального кино', NULL),
(15, 'Манеж', NULL),
(16, 'ММСИ на Петровке', NULL);
