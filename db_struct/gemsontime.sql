# --------------------------------------------------------
# Host:                         192.168.14.45
# Server version:               5.5.22-0ubuntu1
# Server OS:                    debian-linux-gnu
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-12-24 19:16:47
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for gemsontime
DROP DATABASE IF EXISTS `gemsontime`;
CREATE DATABASE IF NOT EXISTS `gemsontime` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gemsontime`;


# Dumping structure for table gemsontime.event
DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.event: ~4 rows (approximately)
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` (`id`, `name`, `date`) VALUES
	(1, 'Событие 1', '2012-12-13 19:51:09'),
	(2, 'Событие 2', '2012-12-13 19:54:11'),
	(3, 'Событие 3', '2012-12-20 20:04:44'),
	(4, 'Событие 4', '2012-12-20 21:04:44');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;


# Dumping structure for table gemsontime.friend
DROP TABLE IF EXISTS `friend`;
CREATE TABLE IF NOT EXISTS `friend` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `friend_user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.friend: ~1 rows (approximately)
/*!40000 ALTER TABLE `friend` DISABLE KEYS */;
INSERT INTO `friend` (`id`, `user_id`, `friend_user_id`) VALUES
	(1, 1, 11);
/*!40000 ALTER TABLE `friend` ENABLE KEYS */;


# Dumping structure for table gemsontime.participant
DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `event_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.participant: ~4 rows (approximately)
/*!40000 ALTER TABLE `participant` DISABLE KEYS */;
INSERT INTO `participant` (`id`, `user_id`, `event_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 11, 2),
	(4, 11, 3);
/*!40000 ALTER TABLE `participant` ENABLE KEYS */;


# Dumping structure for table gemsontime.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_confirmed` int(11) DEFAULT '0',
  `check_sum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `password`, `email`, `is_confirmed`, `check_sum`) VALUES
	(1, 'overmind', NULL, NULL, 0, NULL),
	(11, 'vae', 'd02ebea7e0bbaae74b0b66bd512f79b5', 'vaterloo.inc@gmail.com', 1, '1a2afb232e97c4952cf72bb1dd0f11e1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
