
-- Dumping data for table `addresses`
INSERT INTO `addresses` VALUES 
(1,'070012525',3,'VARNA - PLANET MALL','бул. Сливница',185,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(2,'070012525',2,'PLOVDIV - KUCHUK PARIS','ул. Македония',95,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(3,'070012525',2,'PLOVDIV - TRAKIA','ул. Георги Данчов',16,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(4,'070012525',2,'PLOVDIV - CENTRAL','ул. Иван Андонов',5,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(5,'070012525',1,'SOFIA - BOROVO','ул. Ген. Стефан Тошев',8,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(6,'070012525',1,'SOFIA - VAPTSAROV','бул. Никола Вапцаров',6,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(7,'070012525',1,'SOFIA - GEO MILEV','ул. Александър Жендов',6,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(8,'070012525',1,'SOFIA - DRUJBA','ул. Проф. Цветан Лазаров',124,NULL,NULL,NULL,NULL,'2019-12-30 11:30:04'),
(9,'070012525',1,'SOFIA - KOSTENSKI VODOPAD','ул. Костенски Водопад',58,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(10,'070012525',1,'SOFIA - KRASNA POLQNA','ул. Пчичня',31,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(11,'070012525',1,'SOFIA - LULIN','ул. Панчо Владигеров',21,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(12,'070012525',1,'SOFIA - MLADOST','бул. Александър Малинов',78,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(13,'070012525',1,'SOFIA - MLADOST 1','бул. Александър Малинов',6,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(14,'070012525',1,'SOFIA - MUSAGENICA','ул. Пловдивско Поле',7,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(15,'070012525',1,'SOFIA - NADEJDA','бул. Ломско Шосе',174,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(16,'070012525',1,'SOFIA - PAVLOVO','ул. Александър Пушкин',38,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(17,'070012525',1,'SOFIA - STUDENT CITY 2','ул. Проф. д-р Иван Странски',1,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(18,'070012525',1,'SOFIA - STUDENT CITY','ул. Йордан Йосифов',4,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(19,'070012525',1,'SOFIA - SUHATA REKA','бул. Владимир Вазов',13,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(20,'070012525',1,'SOFIA - CENTER','ул. Александър Стамболийски',41,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05'),
(21,'070012525',1,'SOFIA - SOUTH PARK','ул. Бяла черква',1,NULL,NULL,NULL,NULL,'2019-12-30 11:30:05');

-- Table structure for table `password_reset`
DROP TABLE IF EXISTS `password_reset`;
CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(100) NOT NULL,
  `exp_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_address_fk_idx` (`address_id`),
  CONSTRAINT `restaurant_address_fk` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table `restaurants`
INSERT INTO `restaurants` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),
(13,13),(14,14),(15,15),(16,16),(17,17),(18,18),(19,19),(20,20),(21,21);

-- New Data For addresses of restaurants
ALTER TABLE `dominos`.`addresses` 
ADD COLUMN `latitude` DOUBLE NULL AFTER `date_created`,
ADD COLUMN `longitude` DOUBLE NULL AFTER `latitude`;

UPDATE `dominos`.`addresses` SET `latitude`='42.717450', `longitude`='23.252440' WHERE `id`='11';
UPDATE `dominos`.`addresses` SET `latitude`='43.221271', `longitude`='27.873374' WHERE `id`='1';
UPDATE `dominos`.`addresses` SET `latitude`='42.129890', `longitude`='24.743910' WHERE `id`='2';
UPDATE `dominos`.`addresses` SET `latitude`='42.141990', `longitude`='24.784860' WHERE `id`='3';
UPDATE `dominos`.`addresses` SET `latitude`='42.141510', `longitude`='24.739880' WHERE `id`='4';
UPDATE `dominos`.`addresses` SET `latitude`='42.672600', `longitude`='23.285360' WHERE `id`='5';
UPDATE `dominos`.`addresses` SET `latitude`='42.697180', `longitude`='23.121410' WHERE `id`='6';
UPDATE `dominos`.`addresses` SET `latitude`='42.679870', `longitude`='23.355980' WHERE `id`='7';
UPDATE `dominos`.`addresses` SET `latitude`='42.126610', `longitude`='24.774030' WHERE `id`='8';
UPDATE `dominos`.`addresses` SET `latitude`='42.665620', `longitude`='23.298760' WHERE `id`='9';
UPDATE `dominos`.`addresses` SET `latitude`='42.694380', `longitude`='23.284690' WHERE `id`='10';
UPDATE `dominos`.`addresses` SET `latitude`='42.636070', `longitude`='23.369710' WHERE `id`='12';
UPDATE `dominos`.`addresses` SET `latitude`='42.623760', `longitude`='23.368460' WHERE `id`='13';
UPDATE `dominos`.`addresses` SET `latitude`='42.655050', `longitude`='23.364780' WHERE `id`='14';
UPDATE `dominos`.`addresses` SET `latitude`='42.734670', `longitude`='23.294600' WHERE `id`='15';
UPDATE `dominos`.`addresses` SET `latitude`='42.661520', `longitude`='23.264910' WHERE `id`='16';
UPDATE `dominos`.`addresses` SET `latitude`='42.643280', `longitude`='23.341030' WHERE `id`='17';
UPDATE `dominos`.`addresses` SET `latitude`='42.653840', `longitude`='23.346120' WHERE `id`='18';
UPDATE `dominos`.`addresses` SET `latitude`='42.702830', `longitude`='23.352890' WHERE `id`='19';
UPDATE `dominos`.`addresses` SET `latitude`='42.708720', `longitude`='23.132000' WHERE `id`='20';
UPDATE `dominos`.`addresses` SET `latitude`='42.674750', `longitude`='23.309700' WHERE `id`='21';

