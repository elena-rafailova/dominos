INSERT INTO sizes(name, price, slices) VALUES ('Medium', 6.5, 6), ('Large', 8.9, 8), ('Jumbo', 10.5, 12);

INSERT INTO doughs(name, price) VALUES ('Traditional', 0), ('Italian', 0), ('With Philadelphia', 2.25);

INSERT INTO categories(name) VALUES ('Sauses'), ('Spices'), ('Cheeses'), ('Meats'), ('Vegetables'), ('Miscellaneous');

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
('Caramelized Onions', 6, 2);


INSERT INTO pizzas(name, img_url, modified, category) VALUES
('Margarita', 'Uploads/margarita.png', 0, 2),
('Master Burger Pizza', 'Uploads/masterburger.png', 0, 1),
('Chick-chi-rik', 'Uploads/chikchirik.png', 0, 1);

INSERT INTO pizzas_have_ingredients VALUES
(1, 1),
(1, 10),
(2, 2),
(2, 10),
(2, 33),
(2, 20),
(2, 22),
(2, 34),
(3, 1),
(3, 22),
(3, 20),
(3, 9),
(3, 30);

