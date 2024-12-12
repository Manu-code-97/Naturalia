<?php

namespace App\Repository;

use App\Helper\Distance;
use App\Helper\LocationGPS;

class CalculDistanceMag
{   
    public function calculDistance($magasins, $cp){
        $location = new LocationGPS($cp);
        $locationUser = $location->getGeoLocByPostalCode();
        
        $magasins = array_splice($magasins, 0, 5);
        // $magasins = $magasins[0]->getAdresse();
        // dd($magasins);
        foreach($magasins as $key => $locationMag)
        {   
            $distance = new Distance($locationMag->getLatitude(), $locationMag->getLongitude(), $locationUser[0], $locationUser[1]);

            $distance = $distance->calcDistance();
            
            $magasins[$key]->distance = $distance;
            // $magasins[$key]->n = rand(0, 100);
        }

        // Filtrer les magasins à 20km du client
        $magasins = array_filter($magasins, function($magasin){
            return $magasin->distance <= 20;
        });

        // Ranger les magasins du plus proche au plus loin
        usort($magasins, function($a, $b){
            return $a->distance <=> $b->distance;
        });

        // dd($magasins);
        return $magasins;
    }
}