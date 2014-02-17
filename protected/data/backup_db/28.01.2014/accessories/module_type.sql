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

-- Dumping structure for table accessories.module_type
DROP TABLE IF EXISTS `module_type`;
CREATE TABLE IF NOT EXISTS `module_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(50) NOT NULL,
  `description` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_type: ~6 rows (approximately)
/*!40000 ALTER TABLE `module_type` DISABLE KEYS */;
INSERT INTO `module_type` (`id`, `table_name`, `description`) VALUES
	(1, 'module_article', 'Модуль'),
	(2, 'module_article', 'Модуль'),
	(3, 'module_param', 'Параметр'),
	(4, 'module_type', 'Тип'),
	(5, 'accessory_catalog', 'Каталог для товаров магазина'),
	(6, 'accessory_item', 'Аксессуары, которые будут продаваться в магазине');
/*!40000 ALTER TABLE `module_type` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
