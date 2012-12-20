# --------------------------------------------------------
# Host:                         192.168.14.45
# Server version:               5.5.22-0ubuntu1
# Server OS:                    debian-linux-gnu
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-12-20 19:35:39
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for gemsontime
CREATE DATABASE IF NOT EXISTS `gemsontime` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gemsontime`;


# Dumping structure for table gemsontime.event
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.event: ~2 rows (approximately)
DELETE FROM `event`;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` (`id`, `user_id`, `name`, `date`) VALUES
	(1, 1, 'Событие 1', '2012-12-13 19:51:09'),
	(2, 1, 'Событие 2', '2012-12-13 19:54:11');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;


# Dumping structure for table gemsontime.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_confirmed` int(11) DEFAULT '0',
  `check_sum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

# Dumping data for table gemsontime.user: ~1 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `password`, `email`, `is_confirmed`, `check_sum`) VALUES
	(1, 'overmind', NULL, NULL, 0, NULL),
	(11, 'vae', 'd02ebea7e0bbaae74b0b66bd512f79b5', 'vaterloo.inc@gmail.com', 1, '1a2afb232e97c4952cf72bb1dd0f11e1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
