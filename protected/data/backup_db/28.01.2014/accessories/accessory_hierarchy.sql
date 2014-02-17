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

-- Dumping structure for table accessories.accessory_hierarchy
DROP TABLE IF EXISTS `accessory_hierarchy`;
CREATE TABLE IF NOT EXISTS `accessory_hierarchy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `parent_id_type` int(10) NOT NULL,
  `child_id_type` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table accessories.accessory_hierarchy: ~0 rows (approximately)
/*!40000 ALTER TABLE `accessory_hierarchy` DISABLE KEYS */;
INSERT INTO `accessory_hierarchy` (`id`, `module_id`, `parent_id_type`, `child_id_type`) VALUES
	(1, 240, 0, 5),
	(2, 240, 5, 6);
/*!40000 ALTER TABLE `accessory_hierarchy` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
