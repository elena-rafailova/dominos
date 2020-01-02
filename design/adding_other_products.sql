
--
-- Table structure for table `orders_have_others`
--

DROP TABLE IF EXISTS `orders_have_others`;
CREATE TABLE `orders_have_others` (
  `order_id` int(11) NOT NULL,
  `other_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`other_id`),
  KEY `item_other_id_fk_idx` (`other_id`),
  CONSTRAINT `item_other_id_fk` FOREIGN KEY (`other_id`) REFERENCES `others` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_item_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table `others`
--

DROP TABLE IF EXISTS `others`;
CREATE TABLE `others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `img_url` varchar(200) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `modified` tinyint(1) NOT NULL DEFAULT 1,
  `filter` tinyint(4) NOT NULL DEFAULT 1,
  `others_category_id` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `others_category_fk_idx` (`others_category_id`),
  CONSTRAINT `others_category_fk` FOREIGN KEY (`others_category_id`) REFERENCES `others_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `others`
--
INSERT INTO `others` VALUES (1,'CHEESY BREAD','uploads/cheesy_bread.png','Freshly baked, topped with mozzarella and the special Domino\'s seasoning, served with tomato dip',0,2,1,3.5,'2020-01-02 13:07:29'),
(2,'MOZZARELLA STICKS','uploads/mozzarella_sticks.png','Five crispy mozzarella sticks with BBQ dip',0,1,1,6,'2020-01-02 13:07:29'),
(7,'CHICKEN KICKERS SINGLE PORTION','uploads/chicken_1.png','Oven baked chicken nuggets in a spicy breadcrumb coating. Served with Barbecue dip',0,3,2,6.5,'2020-01-02 13:14:51'),
(8,'CHICKEN STRIPPERS SINGLE PORTION','uploads/chicken_2.png','Succulent pieces of white chicken breast, not spicy, coated in breadcrumbs cooked in the oven. Served with sweet chilli sauce',0,0,2,6.5,'2020-01-02 13:14:51'),
(9,'BUFFALO WINGS SINGLE PORTION','uploads/chicken_3.png','8 freshly baked chicken wings covered in Domino\'s barbecue sauce',0,0,2,6.5,'2020-01-02 13:14:51'),
(10,'HOT BUFFALO WINGS','uploads/chicken_4.png','8 freshly baked chicken wings in Franks sauce',0,3,2,6.5,'2020-01-02 13:14:51'),
(11,'CARBONARA PASTA','uploads/pasta_1.png','Cream Sauce, Parmesan, Smoked Bacon, Fresh mushrooms',0,0,3,6.8,'2020-01-02 14:25:04'),
(12,'NAPOLITEN','uploads/pasta_2.png','Tomato Sauce, Parmesan, Pesto Sauce',0,0,3,6.8,'2020-01-02 14:25:04'),
(13,'PASTA PEPPERONI','uploads/pasta_3.png','Cream Sauce, Tomato Sauce, Parmesan, Pepperoni',0,3,3,6.8,'2020-01-02 14:25:04'),
(14,'MAC AND CHEESE','uploads/pasta_4.png','Cream Sauce, Cheddar Cheese, Emmental, Parmesan',0,1,3,6.8,'2020-01-02 14:25:04'),
(15,'ROCKET SALAD','uploads/salad_1.png','Parmesan, Fresh tomato, Ruccula',0,2,4,5.3,'2020-01-02 14:31:53'),
(16,'CAESAR\'S BACON','uploads/salad_2.png','Croutons, Parmesan, Smoked Bacon, Corn',0,0,4,5.8,'2020-01-02 14:31:53'),
(17,'CAESAR\'S CHICKEN','uploads/salad_3.png','Croutons, Parmesan, Chicken, Corn',0,0,4,5.8,'2020-01-02 14:31:53'),
(18,'TUNA SALAD','uploads/salad_4.png','Tuna, Corn, Black Olives',0,0,4,5.8,'2020-01-02 14:31:53'),
(19,'PEPPERONI SANDWICH','uploads/sandwich_1.png','Tomato Sauce, Pepperoni',0,0,5,6.5,'2020-01-02 14:36:59'),
(20,'BBQ CHICKEN SANDWICH','uploads/sandwich_2.png','BBQ Sauce, Chicken, Smoked Bacon',0,0,5,6.5,'2020-01-02 14:36:59'),
(21,'MEDITERRANEO SANDWICH','uploads/sandwich_3.png','Ranch Dressing, Feta Cheese, Black Olives, Fresh tomato, Fresh green peppers',0,0,5,6.5,'2020-01-02 14:36:59'),
(22,'FRANK\'S HOT SAUCE DIP','uploads/dip_1.png',NULL,0,3,6,1,'2020-01-02 14:48:20'),
(23,'HONEY-MUSTARD DIP','uploads/dip_2.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(24,'GARLIC & HERBS DIP','uploads/dip_3.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(25,'BARBECUE DIP','uploads/dip_4.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(26,'SWEET CHILLI DIP','uploads/dip_5.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(27,'TOMATO DIP','uploads/dip_6.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(28,'MILK BASED SAUCE','uploads/dip_7.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(29,'RANCH DIP','uploads/dip_8.png',NULL,0,0,6,1,'2020-01-02 14:48:20'),
(30,'CAESAR DIP','uploads/dip_9.png','Caesar dip',0,1,6,1,'2020-01-02 14:48:20'),
(31,'ITALIAN DIP','uploads/dip_10.png','Italian dip',0,1,6,1,'2020-01-02 14:48:20'),
(32,'CHOCO PIE WITH NUTELLA','uploads/dessert_1.png','Freshly oven baked puff pastry filled with Nutella spread and sprinkled with icing sugar',0,4,7,5.5,'2020-01-02 15:00:44'),
(33,'CHOCOLATE SOUFFLE','uploads/dessert_2.png','Chocolate lava cake filled with melted warm chocolate',0,4,7,5.5,'2020-01-02 15:00:44'),
(34,'NIRVANA PRALINES & CREAM','uploads/dessert_3.png','Nirvana Pralines & Cream',0,5,7,2.99,'2020-01-02 15:00:44'),
(35,'NIRVANA COOKIES & CREAM','uploads/dessert_4.png','Nirvana Cookies & Cream',0,5,7,2.99,'2020-01-02 15:00:44'),
(36,'BROWNIE BITES','uploads/dessert_5.png','Chocolate brownie with white chocolate chips',0,4,7,3,'2020-01-02 15:00:44'),
(37,'NIRVANA CHOCOLATE & CHOCO CHIPS','uploads/dessert_6.png','Chocolate ice cream with chocolate chips',0,5,7,2.99,'2020-01-02 15:00:44'),
(38,'CHOCO PIZZA','uploads/dessert_7.png','Puffy dessert with nutella and ricotta cheese filling, freshly oven-baked and sprinkled with powder sugar',0,4,7,10.5,'2020-01-02 15:00:44'),
(39,'ARYAN 0.5L','uploads/drink_1.png',NULL,0,0,8,1.6,'2020-01-02 15:27:59'),
(40,'COCA-COLA ZERO','uploads/drink_2.png',NULL,0,0,8,2,'2020-01-02 15:27:59'),
(41,'COCA-COLA','uploads/drink_3.png',NULL,0,0,8,2,'2020-01-02 15:27:59'),
(42,'SPRITE','uploads/drink_4.png',NULL,0,0,8,2,'2020-01-02 15:27:59'),
(43,'MINERAL WATER','uploads/drink_5.png',NULL,0,0,8,1.5,'2020-01-02 15:27:59'),
(44,'FANTA','uploads/drink_6.png',NULL,0,0,8,2,'2020-01-02 15:27:59'),
(45,'ZAGORKA','uploads/drink_7.png',NULL,0,0,8,2.6,'2020-01-02 15:27:59'),
(46,'HEINEKEN BEER 330ML','uploads/drink_8.png',NULL,0,0,8,2.2,'2020-01-02 15:27:59'),
(47,'FUZZTEA','uploads/drink_9.png',NULL,0,0,8,2.2,'2020-01-02 15:27:59'),
(48,'MALEE','uploads/drink_10.png',NULL,0,0,8,2.4,'2020-01-02 15:27:59');


--
-- Table structure for table `others_categories`
--

DROP TABLE IF EXISTS `others_categories`;
CREATE TABLE `others_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `others_categories`
--

INSERT INTO `others_categories` VALUES (1,'Starters'),(2,'Chicken'),(3,'Pasta'),(4,'Salads'),(5,'Sandwiches'),(6,'Dips'),(7,'Desserts'),(8,'Drinks');

