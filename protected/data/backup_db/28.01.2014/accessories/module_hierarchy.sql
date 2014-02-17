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

-- Dumping structure for table accessories.module_hierarchy
DROP TABLE IF EXISTS `module_hierarchy`;
CREATE TABLE IF NOT EXISTS `module_hierarchy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `parent_id_type` int(10) NOT NULL,
  `child_id_type` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table accessories.module_hierarchy: ~4 rows (approximately)
/*!40000 ALTER TABLE `module_hierarchy` DISABLE KEYS */;
INSERT INTO `module_hierarchy` (`id`, `module_id`, `parent_id_type`, `child_id_type`) VALUES
	(1, 1, 1, 4),
	(2, 1, 0, 1),
	(3, 1, 4, 2),
	(4, 1, 2, 3);
/*!40000 ALTER TABLE `module_hierarchy` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
