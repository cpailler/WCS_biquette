<?php

namespace AppBundle\Service;

use Doctrine\ORM\Mapping;

class JaugeVelo {
    public function indicativeJaugeVelo($description, $photo, $equipement, $antivol, $localisation, $calendrier)
    {
        $jaugeVelo = 0;

        if(isset($description)){
            $jaugeVelo = $jaugeVelo + 20;
        }
        if(isset($photo)){
            $jaugeVelo = $jaugeVelo + 20;
        }
        if(isset($equipement)){
            $jaugeVelo = $jaugeVelo + 10;
        }
        if(isset($antivol)){
            $jaugeVelo = $jaugeVelo + 10;
        }
        if(isset($localisation)){
            $jaugeVelo = $jaugeVelo + 20;
        }
        if(isset($calendrier)){
            $jaugeVelo = $jaugeVelo + 20;
        }

        return $jaugeVelo;
    }
}