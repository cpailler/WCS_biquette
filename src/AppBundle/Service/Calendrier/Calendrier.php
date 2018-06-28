<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 27/06/18
 * Time: 09:55
 */

namespace AppBundle\Service\Calendrier;


use AppBundle\Entity\Velo;
use AppBundle\Service\Calendrier\Month;

class Calendrier
{
    /**
     * @return mixed
     */
    public function getMonths()
    {
        return $this->months;
    }
    const NBMONTHS = 6;
    public $initMonth ;
    public $initYear ;
    private $months;

    public function __construct( int $month = null, int $year = null)
    {
        if ($month === null){
            $month = (int)date('m');
        }

        if ($year === null){
            $year = (int)date('Y');
        }

        if ($month < 1 || $month >12){
            throw new Exception("Le mois  $month n'est pas valide");
        }
        if ($year < 1970) {
            throw new Exception("L'année est inferieur à 1970");
        }
        if ($year < 1970) {
            throw new \Exception("L'année est inferieur à 1970");
        }
        $this->initMonth = $month;
        $this->initYear = $year;
        $this->months[0] = new Month($month, $year);
        for ($i=1;$i<$this::NBMONTHS;$i++)
        {
            $this->months[$i] = $this->months[$i-1]->nextMonth();
        }
    }

    /**
     * @return nextMonth
     * @throws Exception
     */

    public function  nextCalendar(){
        $month = $this->initMonth + 6;
        $year = $this->initYear;
        if ($month>12){
            $month = $month%12;
            $year += 1;
        }
        return new Calendrier($month, $year);
    }

    /**
     * @return previousMonth
     * @throws Exception
     */

    public function  previousCalendar(){
        $month = $this->initMonth - 6;
        $year = $this->initYear;
        if ($month<1){
            $month = ($month+12)%13;
            $year -= 1;
        }
        return new Calendrier($month, $year);
    }

    public function getStatus(Velo $velo, \DateTime $date){
        $dispo = 'Non';
        if ($velo->getDispoTotale()==1){
            $dispo = 'disponible';
        }
        else {
            $disponibilites = $velo->getDisponibilites();
            foreach ($disponibilites as $disponibilite){
                if ($disponibilite->getDebut()<=$date && $date<=$disponibilite->getFin()){
                    $dispo = 'disponible';
                    break;
                }
            }
        }
        $reservations = $velo->getReservations();
        foreach ($reservations as $reservation){
            if ($reservation->getDebut()<=$date && $date<=$reservation->getFin()){
                $dispo = 'reserve';
                break;
            }
        }
        return $dispo;
    }
}