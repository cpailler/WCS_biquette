<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 20/06/18
 * Time: 09:25
 */

namespace AppBundle\Service;


use AppBundle\Entity\Membre;
use AppBundle\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;

class PointsManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @param Membre $from
     * @param Membre $to
     * @param int $nbPts
     *
     * @return bool
     */
    public function transferPoints(Membre $from,Membre $to,int $nbPts)
    {
        try
        {
            $from->setPoints($from->getPoints()-$nbPts);
            $to->setPoints($to->getPoints()+$nbPts);
            $this->em->persist($from);
            $this->em->persist($to);
            $this->em->flush();
            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * @param Membre $to
     * @param Int $nbPts
     *
     * @return bool
     */
    public function givePoints(Membre $to,int $nbPts )
    {
        try
        {
            $to->setPoints($to->getPoints()+$nbPts);
            $this->em->persist($to);
            $this->em->flush();
            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
    /**
     * @param Velo $velo
     *
     * @return int
     */
    public function indicativePointsValue(Velo $velo)
    {
        return round($velo->getTypeVelo()->getPrixMoyen()*$velo->getTypeVelo()->getCoeff()*$velo->getEtatVelo()->getCoeff());
    }
}