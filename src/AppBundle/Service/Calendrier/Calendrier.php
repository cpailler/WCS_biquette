<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 27/06/18
 * Time: 09:55
 */

namespace AppBundle\Service\Calendrier;


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
    private $firstMonth ;
    private $initialYear ;
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
        $this->firstMonth = $month;
        $this->initialYear = $year;
        $this->months[0] = new Month($month, $year);
        for ($i=1;$i<$this::NBMONTHS;$i++)
        {
            $this->months[$i] = $this->months[$i-1]->nextMonth();
        }
    }
}