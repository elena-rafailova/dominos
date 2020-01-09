<?php


namespace model;


class Cart implements \JsonSerializable {
    private $products;
    private $price = 0;

    public function __construct($products = [], $price = 0) {
        $this->products = $products;
        $this->price = $price;
    }
    
    public function getProducts() {
        return $this->products;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    /** @var Product $product */
    public function addProduct($product) {
        $this->products[] = $product;
        $this->price += $product->getPrice();
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
                $this->price -= $product->getPrice();
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