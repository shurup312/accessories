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

-- Dumping structure for table accessories.accessory
DROP TABLE IF EXISTS `accessory`;
CREATE TABLE IF NOT EXISTS `accessory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT '0',
  `object_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rights` int(10) NOT NULL,
  `path` varchar(64) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `can_delete` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.accessory: ~0 rows (approximately)
/*!40000 ALTER TABLE `accessory` DISABLE KEYS */;
INSERT INTO `accessory` (`id`, `parent_id`, `object_id`, `type_id`, `name`, `rights`, `path`, `sort`, `can_delete`) VALUES
	(1, 0, 0, 5, 'ad', 0, '0', NULL, 1);
/*!40000 ALTER TABLE `accessory` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
