<?php

class Distance
{
    private float $radius;

    private $latDest;
    private $lonDest;

    private $latOrigin;
    private $lonOrigin;

    function __construct($latDest, $lonDest, $latOrigin, $lonOrigin)
    {
        $this->radius = 6371;

        $this->latDest = $latDest;
        $this->lonDest = $lonDest;

        $this->latOrigin = $latOrigin;
        $this->lonOrigin = $lonOrigin;
    }

    public function calcDistance()
    {   
        $latDestRad = $this->latDest * M_PI / 180;
        $latOriginRad = $this->latOrigin * M_PI / 180;

        $difLatRad = ($this->latOrigin - $this->latDest) * M_PI / 180;
        $difLonRad = ($this->lonOrigin - $this->lonDest) * M_PI / 180;

        // moitié du carré de la longueur de la corde
        $a = (sin($difLatRad/2) * sin($difLatRad/2)) + (cos($latDestRad) * cos($latOriginRad) * sin($difLonRad/2) * sin($difLonRad));

        // distance angulaire
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        // distance réelle
        $distance = round($this->radius * $c, 2);

        return $distance;
    }
}