<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/2018
 * Time: 16:07
 * php -S localhost:8000 -d display_errors=1 -t public

 */

namespace AppBundle\Service\Calendrier;


class Month {
    public $daysEn = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'];
    public $days = ['L', 'M', 'M', 'J', 'V','S','D'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year ;

    /**
     * Class Month
     * @param int $monthle mois compris entre 1 et 12
     * @param  int $year l'année
     * @throws \Exception
     */

    public function __construct ( int $month = null, int $year = null)
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
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * renvoi le premier jours du mois
     * @return \DateTime
     */
    public function getStartingDay () {
        return new \DateTime("{$this->year}-{$this->month}-01");

    }

    /**
     * retourne le mois en toute lettre (ex:mars 2018)
     * @return string
     */
    public function __toString ()
    {
        return $this->months[$this->month -1].' '.$this->year;


    }

    /**
     * Renvoie le nombre de semaine dans le mois
     * @return int
     */

    public function getWeeks (): int {

        $debutWeek = $this->getStartingDay();
        $fin = (clone $debutWeek)->modify('+1 month -1 day');
        $startWeek = (int)($debutWeek->format('W'));
        $finWeek = (int)($fin->format('W'));
        if($finWeek === 1){
            $finWeek = (int)(clone $fin)->modify('-7 days')->format('W')+1;
        }
        $weeks = $finWeek - $startWeek +1;
        if($weeks < 0){
            $weeks = (int)$fin->format('W');
        }
        return $weeks;
    }

    /**
     * @param DateTime $date
     * @return bool
     */
    public function withinMonth(\DateTime $date):bool{

        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * @return nextMonth
     * @throws Exception
     */

    public function  nextMonth():Month{
        $month = $this->month + 1;
        $year = $this->year;
        if ($month>12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * @return previousMonth
     * @throws Exception
     */

    public function  previousMonth():Month{
        $month = $this->month - 1;
        $year = $this->year;
        if ($month<1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
