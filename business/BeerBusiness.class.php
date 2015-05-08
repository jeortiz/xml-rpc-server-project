<?php

require_once "../models/Beer.class.php";
require_once "../data/BeerData.class.php";
require_once "../helpers/constants/Constants.class.php";

class BeerBusiness {

    private $beerData;

    function __construct() {
        $this->beerData = new BeerData();
    }

    public function getPrice($beerName) {
        return $this->beerData->getPrice($beerName);
    }

    public function setPrice($beerName, $price) {
        $beer = $this->beerData->getBeer($beerName);

        if($beer != null) {
            $beer->setPrice($price);
            return $this->beerData->setPrice($beer);
        }

        else {
            return Constants::ERROR;
        }
    }

    public function getAllBeers() {
        $beers = $this->beerData->getAllBeers();
        $beerNames = array();

        foreach($beers as $beer) {
            $beerNames[] = $beer->getName();
        }

        return $beerNames;
    }

    public function getCheapest() {
        $beer = $this->beerData->getCheapestBeer();
        return $beer->getName();
    }

    public function getCostliest() {
        $beer = $this->beerData->getCostliestBeer();
        return $beer->getName();
    }
}