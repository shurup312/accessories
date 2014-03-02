-- --------------------------------------------------------
-- Host:                         
-- Server version:               5.6.11 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2014-03-02 18:34:25
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.accessory: ~3 rows (approximately)
/*!40000 ALTER TABLE `accessory` DISABLE KEYS */;
INSERT INTO `accessory` (`id`, `parent_id`, `object_id`, `type_id`, `name`, `rights`, `path`, `sort`, `can_delete`) VALUES
	(1, 0, 1, 5, 'Первый раздел данного магазина', 0, '0', 10, 0),
	(2, 1, 1, 6, 'Сережки золотые', 0, '1', NULL, 0),
	(4, 0, 2, 5, 'Брошки', 0, '0', 10, 1);
/*!40000 ALTER TABLE `accessory` ENABLE KEYS */;


-- Dumping structure for table accessories.accessory_catalog
DROP TABLE IF EXISTS `accessory_catalog`;
CREATE TABLE IF NOT EXISTS `accessory_catalog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table accessories.accessory_catalog: ~2 rows (approximately)
/*!40000 ALTER TABLE `accessory_catalog` DISABLE KEYS */;
INSERT INTO `accessory_catalog` (`id`) VALUES
	(1),
	(2);
/*!40000 ALTER TABLE `accessory_catalog` ENABLE KEYS */;


-- Dumping structure for table accessories.accessory_hierarchy
DROP TABLE IF EXISTS `accessory_hierarchy`;
CREATE TABLE IF NOT EXISTS `accessory_hierarchy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_id` int(10) NOT NULL DEFAULT '0',
  `parent_id_type` int(10) NOT NULL,
  `child_id_type` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table accessories.accessory_hierarchy: ~2 rows (approximately)
/*!40000 ALTER TABLE `accessory_hierarchy` DISABLE KEYS */;
INSERT INTO `accessory_hierarchy` (`id`, `module_id`, `parent_id_type`, `child_id_type`) VALUES
	(1, 240, 0, 5),
	(2, 240, 5, 6);
/*!40000 ALTER TABLE `accessory_hierarchy` ENABLE KEYS */;


-- Dumping structure for table accessories.accessory_item
DROP TABLE IF EXISTS `accessory_item`;
CREATE TABLE IF NOT EXISTS `accessory_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `price` varchar(10) DEFAULT '0',
  `discount` varchar(10) DEFAULT '0',
  `description` text CHARACTER SET utf8,
  `photo` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table accessories.accessory_item: ~1 rows (approximately)
/*!40000 ALTER TABLE `accessory_item` DISABLE KEYS */;
INSERT INTO `accessory_item` (`id`, `price`, `discount`, `description`, `photo`) VALUES
	(1, '15.95', '0', 'Такие себе золотые сережки', '1393236013(vwti037).jpg');
/*!40000 ALTER TABLE `accessory_item` ENABLE KEYS */;


-- Dumping structure for table accessories.module
DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT '0',
  `object_id` int(10) NOT NULL,
  `type_id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rights` int(10) NOT NULL,
  `path` varchar(64) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `can_delete` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module: ~66 rows (approximately)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `parent_id`, `object_id`, `type_id`, `name`, `rights`, `path`, `sort`, `can_delete`) VALUES
	(1, 0, 1, 1, 'Модуль по созданию модулей', 0, '0', 0, 0),
	(2, 1, 1, 4, 'Модуль', 0, '1', 0, 0),
	(3, 2, 1, 2, 'Главные свойства модулей', 0, '1,2', 0, 0),
	(31, 3, 1, 3, 'ID', 0, '1,2,3', 10, 0),
	(32, 3, 2, 3, 'Тип создаваемого модуля', 0, '1,2,3', 20, 0),
	(33, 3, 3, 3, 'Название создаваемого модуля', 0, '1,2,3', 30, 0),
	(34, 3, 4, 3, 'Описание создаваемого модуля', 0, '1,2,3', 40, 0),
	(37, 1, 4, 4, 'Тип', 0, '1', NULL, 0),
	(38, 37, 0, 2, 'Главные свойства типов', 0, '1,37', NULL, 0),
	(39, 38, 15, 3, 'ID', 0, '1,37,38', 10, 0),
	(40, 38, 16, 3, 'Тип создаваемого типа', 0, '1,37,38', 20, 0),
	(41, 38, 17, 3, 'Название создаваемого типа', 0, '1,37,38', 30, 0),
	(42, 38, 19, 3, 'Описание создаваемого типа', 0, '1,37,38', 50, 0),
	(43, 38, 18, 3, 'Таблица для типа', 0, '1,37,38', 50, 0),
	(44, 1, 2, 4, 'Вкладка', 0, '1', NULL, 0),
	(45, 44, 0, 2, 'Главные свойства вкладок', 0, '1,44', NULL, 0),
	(46, 45, 20, 3, 'ID', 0, '1,44,45', 10, 0),
	(47, 45, 21, 3, 'Тип создаваемой вкладки', 0, '1,44,45', 20, 0),
	(48, 45, 22, 3, 'Название создаваемой вкладки', 0, '1,44,45', 30, 0),
	(49, 1, 3, 4, 'Параметр', 0, '1', NULL, 0),
	(50, 49, 0, 2, 'Главные свойства параметров', 0, '1,49', NULL, 0),
	(51, 50, 23, 3, 'ID', 0, '1,49,50', 10, 0),
	(52, 50, 24, 3, 'Тип параметра', 0, '1,49,50', 20, 0),
	(53, 50, 25, 3, 'Название параметра', 0, '1,49,50', 30, 0),
	(54, 50, 26, 3, 'Таблица параметра', 0, '1,49,50', 40, 0),
	(55, 50, 27, 3, 'Поле в таблице для параметра', 0, '1,49,50', 50, 0),
	(56, 50, 28, 3, 'Тип визуального элемента', 0, '1,49,50', 60, 0),
	(57, 50, 29, 3, 'Регулярка для валидации', 0, '1,49,50', 70, 0),
	(58, 50, 30, 3, 'Описание параметра', 0, '1,49,50', 90, 0),
	(60, 50, 31, 3, 'Видимость параметра', 0, '1,49,50', 80, 0),
	(219, 50, 36, 3, 'Родительский раздел', 0, '1,49,50', 15, 0),
	(231, 3, 48, 3, 'Можно ли удалить', 0, '1,2,3', 50, 0),
	(232, 50, 49, 3, 'Сортировка', 0, '1,49,50', 100, 0),
	(239, 50, 51, 3, 'Описание ошибки валидации', 0, '1,49,50', 75, 0),
	(240, 0, 2, 1, 'Товары', 0, '0', NULL, 0),
	(241, 240, 5, 4, 'Раздел', 0, '240', NULL, 1),
	(242, 240, 6, 4, 'Аксессуар', 0, '240', NULL, 1),
	(243, 241, 0, 2, 'Свойства раздела', 0, '240,241', NULL, 1),
	(244, 243, 52, 3, 'ID', 0, '240,241,243', 10, 0),
	(245, 243, 53, 3, 'Тип раздела', 0, '240,241,243', 20, 0),
	(246, 243, 54, 3, 'Название раздела', 0, '240,241,243', 30, 0),
	(247, 243, 55, 3, 'Можно ли удалить', 0, '240,241,243', 40, 0),
	(249, 243, 57, 3, 'Сортировка', 0, '240,241,243', 50, 0),
	(250, 242, 0, 2, 'Свойства товара', 0, '240,242', 10, 0),
	(251, 38, 58, 3, 'Можно ли удалить', 0, '1,37,38', 60, 0),
	(252, 45, 59, 3, 'Можно ли удалить', 0, '1,44,45', 50, 0),
	(253, 250, 60, 3, 'ID', 0, '240,242,250', 10, 0),
	(254, 49, 0, 2, 'Дополнительные свойства', 0, '1,49', NULL, 0),
	(255, 254, 61, 3, 'Можно ли удалить данный параметр', 0, '1,49,254', 140, 0),
	(256, 250, 62, 3, 'Родительский раздел', 0, '240,242,250', 20, 0),
	(257, 250, 63, 3, 'Название товара', 0, '240,242,250', 30, 0),
	(258, 242, 0, 2, 'Скидки, акции', 0, '240,242', 20, 0),
	(259, 258, 64, 3, 'Скидка на товар', 0, '240,242,258', 50, 0),
	(260, 250, 65, 3, 'Цена товара', 0, '240,242,250', 40, 0),
	(261, 250, 66, 3, 'Описание товара', 0, '240,242,250', 60, 0),
	(262, 242, 0, 2, 'Дополнительные свойства', 0, '240,242', 30, 0),
	(264, 45, 68, 3, 'Сортировка', 0, '1,44,45', 40, 0),
	(266, 262, 70, 3, 'Можно ли товар удалить', 0, '240,242,262', 60, 0),
	(267, 242, 0, 2, 'Фото аксессуара', 0, '240,242', 40, 0),
	(268, 267, 71, 3, 'Фото', 0, '240,242,267', 10, 0),
	(270, 2, 0, 2, 'Дополнительные параметры', 0, '1,2', 20, 0),
	(271, 270, 72, 3, 'Картинка для модуля', 0, '1,2,270', 60, 0),
	(273, 37, 0, 2, 'Дополнительные свойства', 0, '1,37', 120, 0),
	(274, 273, 73, 3, 'Коллбэк на создание/изменение типа', 0, '1,37,273', 100, 0),
	(276, 254, 74, 3, 'Коллбэк', 0, '1,49,254', 130, 0),
	(277, 50, 75, 3, 'Может ли параметр быть пустым', 0, '1,49,50', 65, 0);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;


-- Dumping structure for table accessories.module_article
DROP TABLE IF EXISTS `module_article`;
CREATE TABLE IF NOT EXISTS `module_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(256) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_article: ~2 rows (approximately)
/*!40000 ALTER TABLE `module_article` DISABLE KEYS */;
INSERT INTO `module_article` (`id`, `description`, `image`) VALUES
	(1, '', ''),
	(2, 'Модуль товаров магазина', '');
/*!40000 ALTER TABLE `module_article` ENABLE KEYS */;


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
  `available_null` int(3) NOT NULL,
  `callback` varchar(64) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_param: ~46 rows (approximately)
/*!40000 ALTER TABLE `module_param` DISABLE KEYS */;
INSERT INTO `module_param` (`id`, `table`, `field`, `type`, `exp`, `exp_description`, `visible`, `available_null`, `callback`, `description`) VALUES
	(1, 'module', 'id', 'readonly', NULL, NULL, '2', 1, '', 'ID модуля'),
	(2, 'module', 'type_id', 'readonly', '^[0-9]+$', NULL, '2', 1, '', 'Тип создаваемого модуля'),
	(3, 'module', 'name', 'small-text', '^.+$', 'Поле не может быть пустым', '7', 0, '', 'Имя модуля'),
	(4, 'module_article', 'description', 'text', '', NULL, '7', 1, '', 'Описание модуля'),
	(15, 'module', 'id', 'readonly', NULL, NULL, '2', 1, '', NULL),
	(16, 'module', 'type_id', 'small-text', NULL, NULL, '2', 1, '', NULL),
	(17, 'module', 'name', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(18, 'module_type', 'table_name', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(19, 'module_type', 'description', 'text', NULL, NULL, '7', 1, '', NULL),
	(20, 'module', 'id', 'readonly', NULL, NULL, '2', 1, '', NULL),
	(21, 'module', 'type_id', 'small-text', NULL, NULL, '2', 1, '', NULL),
	(22, 'module', 'name', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(23, 'module', 'id', 'readonly', '', '123', '2', 1, '', ''),
	(24, 'module', 'type_id', 'small-text', NULL, NULL, '2', 1, '', NULL),
	(25, 'module', 'name', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(26, 'module_param', 'table', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(27, 'module_param', 'field', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(28, 'module_param', 'type', 'small-text', NULL, NULL, '7', 0, '', NULL),
	(29, 'module_param', 'exp', 'small-text', NULL, NULL, '7', 1, '', NULL),
	(30, 'module_param', 'description', 'text', NULL, NULL, '7', 1, '', NULL),
	(31, 'module_param', 'visible', 'select', '^[0-7]{1}$', 'Поле может принимать значения 0-7.', '7', 0, 'setVisibleOptions', 'Видимость параметра в формах\r\n0 - нигде\r\n1 - создание\r\n2 - редактирование\r\n3 - редактирование и создание\r\n4 - групповое редактирование\r\n5 - создание и групповое редактирование\r\n6 - редактирование как простое так и групповое\r\n7 - создание, редактирование и групповое переименование'),
	(36, 'module', 'parent_id', 'readonly', NULL, NULL, '2', 1, '', NULL),
	(48, 'module', 'can_delete', 'checkbox', '', '', '7', 1, '', 'Можно ли удалить элеменент?'),
	(49, 'module', 'sort', 'small-text', '', NULL, '7', 1, '', ''),
	(51, 'module_param', 'exp_description', 'text', '', NULL, '7', 1, '', 'Задает, какое собщение должно выводиться при ошибке валидации поля.'),
	(52, 'accessory', 'id', 'readonly', '', '', '2', 1, '', ''),
	(53, 'accessory', 'type_id', 'readonly', '^[0-9]+$', 'Тип создаваемого каталога не может быть пустым.', '2', 1, '', 'Тип каталога'),
	(54, 'accessory', 'name', 'small-text', '^.+$', 'Поле названия раздела не может быть пустым', '7', 0, '', 'Название раздела'),
	(55, 'accessory', 'can_delete', 'small-text', '[0-1]+', 'Значение параметра "Можно удалить" может быть 0 в смысле если элемент удалить нельзя или 1 если элемент удалить можно.', '7', 0, '', 'Можно ли удалить данную запись или нет.'),
	(57, 'accessory', 'sort', 'small-text', '\\d*', 'Поле "сортировка" может содержать только число.', '7', 1, '', 'Обозначает, на какой позиции будет находиться раздел относительно других разделов. Чем больше число, тем ниже в таблицу списка разделов будет находиться раздел.'),
	(58, 'module', 'can_delete', 'checkbox', '', '', '7', 1, '', ''),
	(59, 'module', 'can_delete', 'checkbox', '', '', '7', 1, '', ''),
	(60, 'accessory', 'id', 'readonly', '', '', '2', 1, '', 'ID товара в таблице товаров'),
	(61, 'module', 'can_delete', 'checkbox', '', '', '7', 1, '', 'Можно ли удалить данный параметр. 0 - можно, 1 - нельзя'),
	(62, 'accessory', 'parent_id', 'readonly', '', '', '2', 1, '', ''),
	(63, 'accessory', 'name', 'small-text', '^.+$', 'Название товара не может быть пустым, может состоять из цифр и букв.', '3', 0, '', 'Название товара указывает на то, как будет озаглавливаться данный товар при выводе его конечным покупателям.'),
	(64, 'accessory_item', 'discount', 'small-text', '^[0-100]+$', 'Скидка на товар может быть от 0 до 100 процентов', '7', 0, '', 'Скидка на товар указывается в процентах и показывает, на сколько (в процентах) в данный момент товар стоит меньше своей базовой цены.'),
	(65, 'accessory_item', 'price', 'small-text', '^[0-9\\.]+$', 'Цена на товар может быть числом от 0 и выше.', '7', 0, '', 'Цена на товар указывает примерную стоимость, по которой конечный покупатель может рассчитывать получить товар.'),
	(66, 'accessory_item', 'description', 'text', '^.*$', 'Поле с описанием товара может содержать только печатные символы.', '7', 1, '', 'Описание товара показывает пользователю. просматривающему сайт краткую информацию о товаре.'),
	(68, 'module', 'sort', 'small-text', '^\\d*$', 'Поле сортировка может содержать только числа.', '7', 1, '', ''),
	(70, 'accessory', 'can_delete', 'small-text', '^[0-1]{1}$', 'Поле "можно ли удалить товав" может содержать только значения 0 или 1.', '7', 0, '', 'Параметр указывает, можно ли будет удалить товар. Всегда значение можно поменять и товар сделать удаляемым или не удаляемым. Допустимые значения: 0 - нельзя удалить, 1 - можно удалить.'),
	(71, 'accessory_item', 'photo', 'file', '', '', '7', 1, '', 'Фотография аксессуара'),
	(72, 'module_article', 'image', 'file', '', '', '7', 1, '', 'Изображение для модуля'),
	(73, 'module_type', 'callback', 'small-text', '^[a-zA-Z]*$', 'Название коллбэка может содержать только латинские буквы', '7', 1, '', 'Функция, которая выполняется после создания или редактирования типа.'),
	(74, 'module_param', 'callback', 'small-text', '^[a-zA-Z]*$', 'Параметр может содержать в своей названии только латинские буквы.', '7', 1, '', 'Функция-коллбэк, которая срабатывает перед показом поля в формах. Может использоваться, допустим, для присвоения доп.параметров в массиве параметров.'),
	(75, 'module_param', 'available_null', 'checkbox', '', '', '7', 1, '', 'Указывает на то, может ли быть параметр пустым.');
/*!40000 ALTER TABLE `module_param` ENABLE KEYS */;


-- Dumping structure for table accessories.module_tab
DROP TABLE IF EXISTS `module_tab`;
CREATE TABLE IF NOT EXISTS `module_tab` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_tab: ~0 rows (approximately)
/*!40000 ALTER TABLE `module_tab` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_tab` ENABLE KEYS */;


-- Dumping structure for table accessories.module_type
DROP TABLE IF EXISTS `module_type`;
CREATE TABLE IF NOT EXISTS `module_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(50) NOT NULL,
  `callback` varchar(64) DEFAULT NULL,
  `description` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table accessories.module_type: ~6 rows (approximately)
/*!40000 ALTER TABLE `module_type` DISABLE KEYS */;
INSERT INTO `module_type` (`id`, `table_name`, `callback`, `description`) VALUES
	(1, 'module_article', NULL, 'Модуль'),
	(2, 'module_article', '', 'Модуль'),
	(3, 'module_param', NULL, 'Параметр'),
	(4, 'module_type', NULL, 'Тип'),
	(5, 'accessory_catalog', NULL, 'Каталог для товаров магазина'),
	(6, 'accessory_item', NULL, 'Аксессуары, которые будут продаваться в магазине');
/*!40000 ALTER TABLE `module_type` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
