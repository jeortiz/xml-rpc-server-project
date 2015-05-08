<?php
require_once "IBeverage.php";

class Beer implements IBeverage {

    private $name;
    private $price;

    function __construct($_name, $_price) {
        $this->setName($_name);
        $this->setPrice($_price);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($_name) {
        $this->name = $_name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($_price) {
        if(is_numeric($_price) && $_price > 0)
            $this->price = $_price;
    }
}

?>