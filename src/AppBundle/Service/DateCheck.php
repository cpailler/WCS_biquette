<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 02/07/18
 * Time: 15:15
 */

namespace AppBundle\Service;


use AppBundle\Entity\Disponibilite;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Velo;
use AppBundle\Service\Calendrier\Calendrier;

class DateCheck
{

    /**
     * @param Disponibilite $dispo
     * @param Velo $velo
     * @return bool
     */

    public function noCrossDispos(Disponibilite $dispo,Velo $velo){
        if ($dispo->getDebut()>$dispo->getFin()){
            return false;
        }
        foreach ($velo->getDisponibilites() as $disponibilite){
            if($dispo->getDebut()<=$disponibilite->getFin()
                &&$dispo->getFin()>=$disponibilite->getDebut()
                &&$dispo->getId()!=$disponibilite->getId())
            {
                return false;
            }
        }
        return true;
    }

    public function isLegalReservation(Reservation $reservation,Velo $velo, Calendrier $calendrier){
        $now = new \DateTime();
        $now->modify('-1 day');
        if ($reservation->getDebut()<$now){
            return false;
        }
        if ($reservation->getDebut()>$reservation->getFin()){
            return false;
        }
        $date = clone $reservation->getDebut();
        while ($date<=$reservation->getFin()){
            if ($calendrier->getStatus($velo,$date)!='disponible'){
                return false;
            }
            $date->modify('+1 day');
        }

        return true;
    }
}