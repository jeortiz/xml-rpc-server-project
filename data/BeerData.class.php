<?php
require_once "../models/Beer.class.php";
require_once "../helpers/constants/Constants.class.php";

class BeerData {

    private $mysqli;

    function __construct() {
        $this->mysqli = new mysqli(Constants::DB_HOSTNAME, Constants::DB_USER, Constants::DB_PASSWORD,
            Constants::DB_NAME);
    }

    public function getPrice($beerName) {

        $query_string = "SELECT price FROM beer WHERE name=?";

        if ($select_stmt = $this->mysqli->prepare($query_string)) {
            $select_stmt->bind_param("s", $beerName);
            $select_stmt->execute();
            $select_stmt->bind_result($price);
            $select_stmt->store_result();

            $result = $select_stmt->affected_rows;

            $select_stmt->fetch();

            $select_stmt->close();

            if($result > 0)
                return $price;
            else
                return Constants::NON_EXISTENT_BEVERAGE;
        }

        return Constants::ERROR;
    }

    public function setPrice(Beer $beer) {

        $query_string = "UPDATE beer SET price=? WHERE name=?";

        if ($stmt = $this->mysqli->prepare($query_string)) {
            $stmt->bind_param("ds", $beer->getPrice(), $beer->getName());
            $stmt->execute();
            $stmt->store_result();

            $resultCount = $stmt->affected_rows;

            $stmt->close();

            return $resultCount > 0 ? true : false;
        }

        return false;
    }

    public function getAllBeers() {

        $beers = array();

        $query_string = "SELECT name, price FROM beer";

        if ($select_stmt = $this->mysqli->prepare($query_string)) {
            $select_stmt->execute();
            $select_stmt->bind_result($name, $price);

            while($select_stmt->fetch()) {
                $beers[] = new Beer($name, $price);
            }
            $select_stmt->close();
        }

        return $beers;
    }

    public function getBeer($beerName) {

        $query_string = "SELECT name, price FROM beer WHERE name=?";

        $beer = null;

        if ($select_stmt = $this->mysqli->prepare($query_string)) {
            $select_stmt->bind_param("s", $beerName);
            $select_stmt->execute();
            $select_stmt->bind_result($name, $price);

            $select_stmt->store_result();

            $resultCount = $select_stmt->affected_rows;

            $select_stmt->fetch();

            if($resultCount > 0)
                $beer = new Beer($name, $price);

            $select_stmt->close();
        }

        return $beer;
    }

    public function getCheapestBeer() {

        $query_string = "SELECT name, price FROM beer ORDER BY price LIMIT 1";
        return $this->getBeerWithQuery($query_string);
    }

    public function getCostliestBeer() {

        $query_string = "SELECT name, price FROM beer ORDER BY price DESC LIMIT 1";
        return $this->getBeerWithQuery($query_string);

    }

    private function getBeerWithQuery( $query ) {

        if ($select_stmt = $this->mysqli->prepare($query)) {

            $select_stmt->execute();
            $select_stmt->bind_result($name, $price);
            $select_stmt->fetch();

            $beer = new Beer($name, $price);

            $select_stmt->close();
        }

        return isset($beer) ? $beer : null;
    }

}