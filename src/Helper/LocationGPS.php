<?php

namespace App\Helper;

class LocationGPS
{
    private string $codePostal;

    private string $apiKey;

    private array $geoLoc;

    function __construct(string $codePostal)
    {
        $this->codePostal = $codePostal;
        $this->apiKey     = '675818647ee47646159666ictc52bbf';
    }

    public function getGeoLocByPostalCode()
    {
        $json = file_get_contents("https://geocode.maps.co/search?postalcode=$this->codePostal&country=FR&api_key=".$this->apiKey);
        $json = json_decode($json);

        $lat = $json[0]->lat;
        $long = $json[0]->lon;
        return $this->geoLoc = [$lat, $long];
    }

    public function getGeoLocByAddress()
    {
        $json = file_get_contents("https://geocode.maps.co/search?postalcode=$this->codePostal&country=FR&api_key=".$this->apiKey);
        $json = json_decode($json);

        $lat = $json[0]->lat;
        $long = $json[0]->lon;
        return $this->geoLoc = [$lat, $long];
    }
}

// $loc = new LocationGPS(95310);
// $loc = $loc->getGeoLoc();
// dd($loc);