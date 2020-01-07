<?php


namespace model;


class Cart implements \JsonSerializable {
    private $products;
    private $price = 0;

    public function __construct($products = []) {
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
        $this->products[] = $product;
        $this->price += $product->getPrice();
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
        return empty($this->products);
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
}