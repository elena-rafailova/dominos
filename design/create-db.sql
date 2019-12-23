-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema dominos
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dominos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dominos` DEFAULT CHARACTER SET utf8 ;
USE `dominos` ;

-- -----------------------------------------------------
-- Table `dominos`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`cities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `zip_number` CHAR(4) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`addresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`addresses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `phone_number` VARCHAR(45) NOT NULL,
  `city_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `street_name` VARCHAR(100) NOT NULL,
  `street_number` INT NOT NULL,
  `building_number` VARCHAR(45) NULL,
  `entrance` VARCHAR(10) NULL,
  `floor` INT NULL,
  `apartment_number` VARCHAR(45) NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `address_city_fk_idx` (`city_id` ASC),
  CONSTRAINT `address_city_fk`
    FOREIGN KEY (`city_id`)
    REFERENCES `dominos`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`statuses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`statuses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`restaurants`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`restaurants` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `address_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `restaurant_address_fk_idx` (`address_id` ASC),
  CONSTRAINT `restaurant_address_fk`
    FOREIGN KEY (`address_id`)
    REFERENCES `dominos`.`addresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`payment_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`payment_types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` INT NOT NULL,
  `comment` VARCHAR(255) NULL,
  `delivery_address_id` INT NULL,
  `restaurant_id` INT NULL,
  `payment_type_id` INT NOT NULL,
  `total_price` DOUBLE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `order_status_fk_idx` (`status_id` ASC),
  INDEX `order_user_fk_idx` (`user_id` ASC),
  INDEX `order_address_fk_idx` (`delivery_address_id` ASC),
  INDEX `order_restaurant_fk_idx` (`restaurant_id` ASC),
  INDEX `order_type_fk_idx` (`payment_type_id` ASC),
  CONSTRAINT `order_status_fk`
    FOREIGN KEY (`status_id`)
    REFERENCES `dominos`.`statuses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_user_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `dominos`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_address_fk`
    FOREIGN KEY (`delivery_address_id`)
    REFERENCES `dominos`.`addresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_restaurant_fk`
    FOREIGN KEY (`restaurant_id`)
    REFERENCES `dominos`.`restaurants` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `order_type_fk`
    FOREIGN KEY (`payment_type_id`)
    REFERENCES `dominos`.`payment_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`pizzas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`pizzas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `img_url` VARCHAR(200) NULL,
  `modified` TINYINT(1) NOT NULL DEFAULT 1,
  `category` TINYINT NOT NULL DEFAULT '1',
  `date_created` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`sizes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`sizes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `price` DOUBLE NOT NULL,
  `slices` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`doughs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`doughs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `price` DOUBLE NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`orders_have_pizzas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`orders_have_pizzas` (
  `order_id` INT NOT NULL,
  `pizza_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `size_id` INT NOT NULL,
  `dough_id` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`order_id`, `pizza_id`),
  INDEX `item_pizza_id_fk_idx` (`pizza_id` ASC),
  INDEX `orders_have_pizzas_size_fk_idx` (`size_id` ASC),
  INDEX `orders_have_pizzas_dough_fk_idx` (`dough_id` ASC),
  CONSTRAINT `order_has_item_fk`
    FOREIGN KEY (`order_id`)
    REFERENCES `dominos`.`orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `item_pizza_id_fk`
    FOREIGN KEY (`pizza_id`)
    REFERENCES `dominos`.`pizzas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `orders_have_pizzas_size_fk`
    FOREIGN KEY (`size_id`)
    REFERENCES `dominos`.`sizes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `orders_have_pizzas_dough_fk`
    FOREIGN KEY (`dough_id`)
    REFERENCES `dominos`.`doughs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`ingredients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `category_id` INT NULL,
  `price` DOUBLE NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `ingredient_category_fk_idx` (`category_id` ASC),
  CONSTRAINT `ingredient_category_fk`
    FOREIGN KEY (`category_id`)
    REFERENCES `dominos`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`pizzas_have_ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`pizzas_have_ingredients` (
  `pizza_id` INT NOT NULL,
  `ingredient_id` INT NOT NULL,
  PRIMARY KEY (`pizza_id`, `ingredient_id`),
  INDEX `ingredient_on_pizza_fk_idx` (`ingredient_id` ASC),
  CONSTRAINT `pizza_has_ingredient_fk`
    FOREIGN KEY (`pizza_id`)
    REFERENCES `dominos`.`pizzas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ingredient_on_pizza_fk`
    FOREIGN KEY (`ingredient_id`)
    REFERENCES `dominos`.`ingredients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `dominos`.`users_have_addresses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dominos`.`users_have_addresses` (
  `user_id` INT NOT NULL,
  `address_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `address_id`),
  INDEX `address_of_user_fk_idx` (`address_id` ASC),
  CONSTRAINT `user_has_address_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `dominos`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `address_of_user_fk`
    FOREIGN KEY (`address_id`)
    REFERENCES `dominos`.`addresses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
