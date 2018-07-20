<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 20/06/18
 * Time: 11:09
 */

namespace AppBundle\Service;


use AppBundle\Entity\Velo;
use Doctrine\ORM\EntityManagerInterface;

class CautionManager
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Velo $velo
     *
     * @return int
     */
    public function indicativeCautionValue(Velo $velo)
    {
        return round($velo->getTypeVelo()->getPrixMoyen()*$velo->getEtatVelo()->getCoeffCaution());
    }
}