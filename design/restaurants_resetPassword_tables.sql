
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

