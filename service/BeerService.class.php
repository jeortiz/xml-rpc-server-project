<?php
require_once "../models/Beer.class.php";
require_once "../business/BeerBusiness.class.php";

include_once "../lib/xmlrpc.inc";
include_once "../lib/xmlrpcs.inc";
include_once "../lib/xmlrpc_wrappers.inc";

class BeerService {

    private $beerBusiness;

    function __construct() {
        $this->beerBusiness = new BeerBusiness();
    }

    public function getMethods() {

        $methods = array("double getPrice(string)", "boolean setPrice(string, double)",
            "array getBeers()", "string getCheapest()", "string getCostliest()");

        return $this->processResultArray($methods);
    }

    public function getPrice( $params ) {

        $beerName = $params->getParam( 0 )->scalarval();

        if(!empty($beerName)) {
            $price = $this->beerBusiness->getPrice($beerName);

            if( $price != Constants::NON_EXISTENT_BEVERAGE ) {
                return new xmlrpcresp(new xmlrpcval($price, "double"));
            }
            else if( $price == Constants::NON_EXISTENT_BEVERAGE ) {
                return new xmlrpcresp(new xmlrpcval("Error: beer not in database"));
            }
            else {
                return new xmlrpcresp(new xmlrpcval("Error"));
            }
        }
        else {
            return new xmlrpcresp(new xmlrpcval("Error: beer name is required"));
        }
    }

    public function setPrice( $params ) {

        $beerName = $params->getParam( 0 )->scalarval();
        $newPrice = $params->getParam( 1 )->scalarval();

        $success = $this->beerBusiness->setPrice($beerName, $newPrice);

        if($success) {
            return new xmlrpcresp(new xmlrpcval(true, "boolean"));
        }
        else {
            return new xmlrpcresp(new xmlrpcval(false, "boolean"));
        }
    }

    public function getBeers() {

        $beers = $this->beerBusiness->getAllBeers();

        return $this->processResultArray($beers);
    }

    public function getCheapest( ) {

        $cheapestBeer = $this->beerBusiness->getCheapest();

        return new xmlrpcresp(new xmlrpcval($cheapestBeer));

    }

    public function getCostliest( ) {

        $costliestBeer = $this->beerBusiness->getCostliest();

        return new xmlrpcresp(new xmlrpcval($costliestBeer));

    }

    private function processResultArray($resultArray, $resultType = "string") {

        foreach($resultArray as $key=>$result) {
            $resultArray[$key] = new xmlrpcval( $result, $resultType );
        }

        return new xmlrpcresp( new xmlrpcval( $resultArray, "array" ) );
    }
}