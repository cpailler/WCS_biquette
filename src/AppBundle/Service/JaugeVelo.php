<?php

namespace AppBundle\Service;

use Doctrine\ORM\Mapping;

class JaugeVelo {
    public function indicativeJaugeVelo($titre, $description, $marque, $modele, $typeVelo, $etatVelo, $couleur, $photo, $localisation)
    {
        $jaugeVelo = 0;

        if(isset($titre)){
            $jaugeVelo = $jaugeVelo + 10;
        }
        if(isset($description)){
            $jaugeVelo = $jaugeVelo + 10;
        }
        if(isset($marque)){
            $jaugeVelo = $jaugeVelo + 10;
        }
        if(isset($modele)){
            $jaugeVelo = $jaugeVelo +10;
        }
        if(isset($typeVelo)){
            $jaugeVelo = $jaugeVelo + 5;
        }
        if(isset($etatVelo)){
            $jaugeVelo = $jaugeVelo + 5;
        }
        if(isset($couleur)){
            $jaugeVelo = $jaugeVelo + 5;
        }
        if(count($photo) > 0){
            $jaugeVelo = $jaugeVelo + 20;
        }
        if(isset($localisation)){
            $jaugeVelo = $jaugeVelo + 25;
        }


        return $jaugeVelo;
    }
}