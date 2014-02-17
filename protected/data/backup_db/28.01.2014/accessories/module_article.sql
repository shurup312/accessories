-- --------------------------------------------------------
-- Host:                         
-- Server version:               5.6.11 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2014-01-31 17:52:35
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table accessories.module_article
DROP TABLE IF EXISTS `module_article`;
CREATE TABLE IF NOT EXISTS `module_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_article: ~2 rows (approximately)
/*!40000 ALTER TABLE `module_article` DISABLE KEYS */;
INSERT INTO `module_article` (`id`, `description`) VALUES
	(1, ''),
	(2, 'Модуль товаров магазина');
/*!40000 ALTER TABLE `module_article` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
