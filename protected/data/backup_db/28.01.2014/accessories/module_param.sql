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

-- Dumping structure for table accessories.module_param
DROP TABLE IF EXISTS `module_param`;
CREATE TABLE IF NOT EXISTS `module_param` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table` varchar(64) NOT NULL DEFAULT '0',
  `field` varchar(64) NOT NULL DEFAULT '0',
  `type` varchar(64) NOT NULL DEFAULT '0',
  `exp` varchar(64) DEFAULT NULL,
  `exp_description` varchar(128) DEFAULT NULL,
  `visible` varchar(64) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_param: ~29 rows (approximately)
/*!40000 ALTER TABLE `module_param` DISABLE KEYS */;
INSERT INTO `module_param` (`id`, `table`, `field`, `type`, `exp`, `exp_description`, `visible`, `description`) VALUES
	(1, 'module', 'id', 'readonly', NULL, NULL, '2', 'ID модуля'),
	(2, 'module', 'type_id', 'readonly', '^[0-9]+$', NULL, '2', 'Тип создаваемого модуля'),
	(3, 'module', 'name', 'small-text', '^.+$', 'Поле не может быть пустым', '7', 'Имя модуля'),
	(4, 'module_article', 'description', 'text', '', NULL, '7', 'Описание модуля'),
	(15, 'module', 'id', 'readonly', NULL, NULL, '2', NULL),
	(16, 'module', 'type_id', 'small-text', NULL, NULL, '2', NULL),
	(17, 'module', 'name', 'small-text', NULL, NULL, '7', NULL),
	(18, 'module_type', 'table_name', 'small-text', NULL, NULL, '7', NULL),
	(19, 'module_type', 'description', 'text', NULL, NULL, '7', NULL),
	(20, 'module', 'id', 'readonly', NULL, NULL, '2', NULL),
	(21, 'module', 'type_id', 'small-text', NULL, NULL, '2', NULL),
	(22, 'module', 'name', 'small-text', NULL, NULL, '7', NULL),
	(23, 'module', 'id', 'readonly', '', '', '2', ''),
	(24, 'module', 'type_id', 'small-text', NULL, NULL, '2', NULL),
	(25, 'module', 'name', 'small-text', NULL, NULL, '7', NULL),
	(26, 'module_param', 'table', 'small-text', NULL, NULL, '7', NULL),
	(27, 'module_param', 'field', 'small-text', NULL, NULL, '7', NULL),
	(28, 'module_param', 'type', 'small-text', NULL, NULL, '7', NULL),
	(29, 'module_param', 'exp', 'small-text', NULL, NULL, '7', NULL),
	(30, 'module_param', 'description', 'text', NULL, NULL, '7', NULL),
	(31, 'module_param', 'visible', 'small-text', NULL, NULL, '7', 'Видимость параметра в формах\r\n0 - нигде\r\n1 - создание\r\n2 - редактирование\r\n3 - редактирование и создание\r\n4 - групповое редактирование\r\n5 - создание и групповое редактирование\r\n6 - редактирование как простое так и групповое\r\n7 - создание, редактирование и групповое переименование'),
	(36, 'module', 'parent_id', 'readonly', NULL, NULL, '2', NULL),
	(48, 'module', 'can_delete', 'small-text', '^[0-1]$', 'Поле может принимать значение 0 или 1.', '7', 'Можно ли удалить элеменент? 1 - да, 0 - нет'),
	(49, 'module', 'sort', 'small-text', '', NULL, '7', ''),
	(50, 'module', 'can_delete', 'small-text', '', NULL, '7', ''),
	(51, 'module_param', 'exp_description', 'text', '', NULL, '7', 'Задает, какое собщение должно выводиться при ошибке валидации поля.'),
	(52, 'accessory', 'id', 'readonly', '', '', '2', ''),
	(53, 'accessory', 'type_id', 'readonly', '^[0-9]+$', 'Тип создаваемого каталога не может быть пустым.', '2', 'Тип каталога'),
	(54, 'accessory', 'name', 'small-text', '^.+$', 'Поле названия раздела не может быть пустым', '7', 'Название раздела');
/*!40000 ALTER TABLE `module_param` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
