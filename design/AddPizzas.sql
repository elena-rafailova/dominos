INSERT INTO sizes(name, price, slices) VALUES ('Medium', 6.5, 6), ('Large', 8.9, 8), ('Jumbo', 10.5, 12);

INSERT INTO doughs(name, price) VALUES ('Traditional', 0), ('Italian', 0), ('With Philadelphia', 2.25);

INSERT INTO categories(name) VALUES ('Sauses'), ('Herbs'), ('Cheeses'), ('Meats'), ('Vegetables'), ('Miscellaneous');

INSERT INTO ingredients(name, category_id, price) VALUES 
('Tomato Sauce', 1, 0),
('BBQ Sauce', 1, 0),
('Cream Sauce', 1, 0),
('Basil', 2, 0),
('Oregano', 2, 0),
('Parmesan Sprinkles', 2, 0.5),
('Feta Cheese', 3, 2),
('Emmental', 3, 2),
('Smoked Melted Cheese', 3, 2),
('Mozzarella', 3, 2),
('Parmesan', 3, 2),
('Cheddar Cheese', 3, 2),
('Smoked Bacon', 4, 2),
('Smoked Ham', 4, 2),
('Choriso', 4, 2),
('Ventrichina', 4, 2),
('Spicy Beef', 4, 2),
('Tuna', 4, 2),
('Pepperoni', 4, 2),
('Chicken', 4, 2),
('Baby Spinach', 5, 2),
('Fresh Tomato', 5, 2),
('Jalapenos Peppers', 5, 2),
('Fresh Green Peppers', 5, 2),
('Pickless', 5, 2),
('Black Olives', 5, 2),
('Ruccula', 5, 2),
('Fresh mushrooms', 5, 2),
('Pineapple', 5, 2),
('Corn', 5, 2),
('Onion', 5, 2),
('Pesto Sauce', 6, 2),
('Caramelized Onions', 6, 2),
('Burger Sauce', null, 0);


INSERT INTO payment_types(name) VALUES ('cash'), ('card');
INSERT INTO statuses(name) VALUES('pending'), ('finished');

ALTER TABLE `dominos`.`orders` 
DROP FOREIGN KEY `order_status_fk`;
ALTER TABLE `dominos`.`orders` 
CHANGE COLUMN `status_id` `status_id` INT(11) NOT NULL DEFAULT 1 ;
ALTER TABLE `dominos`.`orders` 
ADD CONSTRAINT `order_status_fk`
  FOREIGN KEY (`status_id`)
  REFERENCES `dominos`.`statuses` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

UPDATE `dominos`.`ingredients` SET `category_id`='6' WHERE `id`='34';


-- New Pizzas --
ALTER TABLE pizzas AUTO_INCREMENT=1; 
INSERT INTO pizzas(name, img_url, modified, category) VALUES
('Margarita', 'uploads/margarita.png', 0, 2),
('Riveroni', 'uploads/riveroni.png', 0, 1),
('Beast V2', 'uploads/beast-v2.png', 0, 1),
('Pizza Ventricina', 'uploads/pizza-ventricina.png', 0, 1),
('Mediterraneo', 'uploads/mediterraneo.png', 0, 3),
('Chickenita', 'uploads/chickenita.png', 0, 0),
('Domino\'s Special', 'uploads/dominos-special.png', 0, 0),
('Chick-chi-rik', 'uploads/chikchirik.png', 0, 0),
('Carbonara', 'uploads/carbonara.png', 0, 0),
('American Hot', 'uploads/american-hot.png', 0, 3),
('Garden Classic', 'uploads/garden-classic.png', 0, 2),
('Pepperoni Classic', 'uploads/pepperoni-classic.png', 0, 0),
('Barbecue Chicken', 'uploads/barbecue-chicken.png', 0, 0),
('Barbecue Classic', 'uploads/barbecue-classic.png', 0, 0),
('New York', 'uploads/new-york.png', 0, 0),
('Ham Classic', 'uploads/ham-classic.png', 0, 0),
('Italian Classic', 'uploads/italian-classic.png', 0, 2),
('Hawaii', 'uploads/hawaii.png', 0, 0),
('4 Cheese', 'uploads/4cheese.png', 0, 2),
('Tuna Pizza', 'uploads/tuna-pizza.png', 0, 2),
('Fasting Pizza', 'uploads/fasting-pizza.png', 0, 2),
('Chorizana', 'uploads/chorizana.png', 0, 0),
('Meat Mania', 'uploads/meat-mania.png', 0, 0),
('Extravaganza', 'uploads/extravaganza.png', 0, 0),
('Burger Pizza', 'uploads/burger-pizza.png', 0, 0),
('Master Burger Pizza', 'uploads/masterburger.png', 0, 1),
('Fit Pizza', 'uploads/fit-pizza.png', 0, 1),
('Beyond Pizza', 'uploads/beyond-pizza.png', 0, 2),
('Fasting V2', 'uploads/fasting-v2.png', 0, 2),
('Vegan Margharita', 'uploads/vegan-margharita.png', 0, 2);

INSERT INTO pizzas_have_ingredients VALUES
(1, 1),
(1, 10),
(2, 1),
(2, 10),
(2, 16),
(2, 19),
(3, 1),
(3,10),
(3, 13),
(3, 14),
(3, 15),
(4, 1),
(4, 16),
(4, 11),
(5, 1),
(5, 10),
(5, 22),
(5, 24),
(5, 7),
(5, 26),
(6, 1),
(6, 10),
(6, 20),
(6, 19),
(6, 22),
(6, 8),
(7, 1),
(7, 10),
(7, 14),
(7, 13),
(7, 28),
(7, 24),
(7, 31),
(8, 1),
(8, 22),
(8, 20),
(8, 9),
(8, 30),
(9, 3),
(9, 10),
(9, 13),
(9, 28),
(10, 1),
(10, 10),
(10, 19),
(10, 23),
(10, 31),
(11, 1),
(11, 10),
(11, 26),
(11, 24),
(11, 31),
(11, 28),
(11, 22),
(12, 1),
(12, 10),
(12, 19),
(13, 2),
(13, 10),
(13, 20),
(13, 13),
(14, 2),
(14, 10),
(14, 13),
(14, 17),
(15, 1),
(15, 10),
(15, 13),
(15, 12),
(15, 28),
(16, 1),
(16, 10),
(16, 14),
(16, 24),
(16, 28),
(17, 1),
(17, 10),
(17, 32),
(17, 11),
(17, 22),
(17, 4),
(18, 1),
(18, 10),
(18, 14),
(18, 19),
(19, 1),
(19, 10),
(19, 12),
(19, 7),
(19, 11),
(20, 1),
(20, 10),
(20, 18),
(20, 22),
(20, 31),
(21, 1),
(21, 26),
(21, 28),
(21, 22),
(22, 1),
(22, 10),
(22, 15),
(22, 20),
(22, 7),
(22, 22),
(23, 1),
(23, 10),
(23, 14),
(23, 13),
(23, 20),
(23, 15),
(24, 1),
(24, 10),
(24, 14),
(24, 31),
(24, 19),
(24, 24),
(24, 28),
(24, 26),
(25, 34),
(25, 10),
(25, 22),
(25, 12),
(25, 25),
(25, 17),
(25, 31),
(26, 2),
(26, 10),
(26, 33),
(26, 20),
(26, 22),
(26, 34),
(27, 1),
(27, 10),
(27, 20),
(27, 24),
(27, 26),
(28, 1),
(28, 10),
(28, 28),
(28, 24),
(29, 1),
(29, 10),
(29, 22),
(29, 28),
(29, 26),
(30, 1),
(30, 10),
(30, 4);

































