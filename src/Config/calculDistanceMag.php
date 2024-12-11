<?php

require_once 'Distance.php';
require_once 'LocationGPS.php';

$magasins = array(
    [48.8580703735351,2.35273385047912],
    [48.8638534545898,2.34648561477661],
    [48.8673133850097,2.34756302833557],
    [48.8554027,2.3251199],
    [48.8702125549316,2.35016703605651],
    [48.8744354248046,2.34184694290161]
);

// dd($magasins);

$location = new LocationGPS(75004);
$locationMag = $location->getGeoLoc();

$locationUser = $location->getGeoLoc();
$location = new LocationGPS(75001);

foreach($magasins as $locationMag)
{   
    // echo 'i';

    $distance = new Distance($locationMag[0], $locationMag[1], $locationUser[0], $locationUser[1]);
    $distance = $distance->calcDistance();
    echo $distance;
    echo '<br>';
}

// dd($distance);