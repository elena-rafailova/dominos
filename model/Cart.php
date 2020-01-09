<?php


namespace model;


class Cart implements \JsonSerializable {
    private $products;
    private $price = 0;

    public function __construct($products = [], $price = 0) {
        $this->products = $products;
        $this->price = $price;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getProducts() {
        return $this->products;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    /** @var Product $product */
    public function addProduct($product) {
        foreach ($this->products as $original_product) {
            if (($original_product instanceof Pizza && $product instanceof Pizza &&
                $original_product->getName() === $product->getName() &&
                $original_product->getIngredients() == $product->getIngredients() &&
                $original_product->getSize() == $product->getSize() &&
                $original_product->getDough() == $product->getDough()) ||
                ($original_product instanceof Other && $product instanceof Other &&
                $original_product == $product)
            ) {
                $original_product_quantity = $original_product->getQuantity();
                $original_product->setQuantity($original_product_quantity + $product->getQuantity());
                $this->price += $product->getPrice() * $product->getQuantity();
                return;
            }
        }
        $this->products[] = $product;
        $this->price += $product->getPrice() * $product->getQuantity();
    }

    public function decreaseQuantity($key) {
        $this->products[$key]->subtractOneFromQuantity();
        $this->price -= $this->products[$key]->getPrice();
        if ($this->products[$key]->getQuantity() == 0) {
            $this->removeProduct($this->products[$key]);
        }
    }

    public function increaseQuantity($key) {
        $this->products[$key]->addOneToQuantity();
        $this->price += $this->products[$key]->getPrice();
    }

    /** @var Product $product */
    public function removeProduct($product) {
        foreach ($this->products as $key=>$prod) {
            if ($prod == $product) {
                unset($this->products[$key]);
                $this->price -= $product->getPrice() * $product->getQuantity();
                return;
            }
        }
    }

    public function isCartEmpty() {
        if (empty($this->products)) {
            return true;
        }
        foreach ($this->products as $product) {
            if ($product->getQuantity() != 0) {
                return false;
            }
        }
        return true;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}