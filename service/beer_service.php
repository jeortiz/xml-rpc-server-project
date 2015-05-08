<?php
include_once "../lib/xmlrpc.inc";
include_once "../lib/xmlrpcs.inc";
include_once "../lib/xmlrpc_wrappers.inc";

require_once "../data/BeerData.class.php";
require_once "../business/BeerBusiness.class.php";
require_once "BeerService.class.php";

function getMethods() {
    $beerService = new BeerService();
    return $beerService->getMethods();
}

function getPrice($params) {
    $beerService = new BeerService();
    return $beerService->getPrice($params);
}

function setPrice($params) {
    $beerService = new BeerService();
    return $beerService->setPrice($params);
}

function getBeers() {
    $beerService = new BeerService();
    return $beerService->getBeers();
}

function getCheapest() {
    $beerService = new BeerService();
    return $beerService->getCheapest();
}

function getCostliest() {
    $beerService = new BeerService();
    return $beerService->getCostliest();
}

//$beerService->go();

// Declare our signature and provide some information
//   in a "dispatch map".
// The PHP server supports "remote introspection".
// Signature: array of signatures, where each is an array
//   that includes the return type and one or more
//   param types
$getMethods_sig   = array( array( $xmlrpcArray ) );
$getPrice_sig     = array( array( $xmlrpcDouble, $xmlrpcString) );
$setPrice_sig     = array( array( $xmlrpcBoolean, $xmlrpcString ,$xmlrpcDouble) );
$getBeers_sig     = array( array( $xmlrpcArray ) );
$getCheapest_sig  = array( array( $xmlrpcString ) );
$getCostliest_sig = array( array( $xmlrpcString ) );

$getMethods_doc   = "Returns all the methods available in the service.";
$getPrice_doc     = "Gets the price of a certain beer.";
$setPrice_doc     = "Sets the price of a given beer.";
$getBeers_doc     = "Returns all the names of all beers in database.";
$getCheapest_doc  = "Returns the beer with the lower sale price.";
$getCostliest_doc = "Returns the beer with the higher sale price.";

new xmlrpc_server( array(
    "BeerService.getMethods" =>
        array( "function" => 'getMethods',
            "signature" => $getMethods_sig,
            "docstring" => $getMethods_doc ),
    "BeerService.getPrice" =>
        array( "function" => "getPrice",
            "signature" => $getPrice_sig,
            "docstring" => $getPrice_doc ),
    "BeerService.setPrice" =>
        array( "function" => "setPrice",
            "signature" => $setPrice_sig,
            "docstring" => $setPrice_doc ),
    "BeerService.getBeers" =>
        array( "function" => "getBeers",
            "signature" => $getBeers_sig,
            "docstring" => $getBeers_doc ),
    "BeerService.getCheapest" =>
        array( "function" => "getCheapest",
            "signature" => $getCheapest_sig,
            "docstring" => $getCheapest_doc ),
    "BeerService.getCostliest" =>
        array( "function" => "getCostliest",
            "signature" => $getCostliest_sig,
            "docstring" => $getCostliest_doc )
));
?>