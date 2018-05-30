<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="velo_id", type="integer")
     */
    private $veloId;

    /**
     * @var int
     *
     * @ORM\Column(name="locataire_id", type="integer")
     */
    private $locataireId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="date")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="date")
     */
    private $fin;

    /**
     * @var int
     *
     * @ORM\Column(name="cout_pts", type="integer")
     */
    private $coutPts;

    /**
     * @var int
     *
     * @ORM\Column(name="caution", type="integer")
     */
    private $caution;

    /**
     * @var bool
     *
     * @ORM\Column(name="assurance", type="boolean")
     */
    private $assurance;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set veloId.
     *
     * @param int $veloId
     *
     * @return Reservation
     */
    public function setVeloId($veloId)
    {
        $this->veloId = $veloId;

        return $this;
    }

    /**
     * Get veloId.
     *
     * @return int
     */
    public function getVeloId()
    {
        return $this->veloId;
    }

    /**
     * Set locataireId.
     *
     * @param int $locataireId
     *
     * @return Reservation
     */
    public function setLocataireId($locataireId)
    {
        $this->locataireId = $locataireId;

        return $this;
    }

    /**
     * Get locataireId.
     *
     * @return int
     */
    public function getLocataireId()
    {
        return $this->locataireId;
    }

    /**
     * Set debut.
     *
     * @param \DateTime $debut
     *
     * @return Reservation
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut.
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin.
     *
     * @param \DateTime $fin
     *
     * @return Reservation
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin.
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set coutPts.
     *
     * @param int $coutPts
     *
     * @return Reservation
     */
    public function setCoutPts($coutPts)
    {
        $this->coutPts = $coutPts;

        return $this;
    }

    /**
     * Get coutPts.
     *
     * @return int
     */
    public function getCoutPts()
    {
        return $this->coutPts;
    }

    /**
     * Set caution.
     *
     * @param int $caution
     *
     * @return Reservation
     */
    public function setCaution($caution)
    {
        $this->caution = $caution;

        return $this;
    }

    /**
     * Get caution.
     *
     * @return int
     */
    public function getCaution()
    {
        return $this->caution;
    }

    /**
     * Set assurance.
     *
     * @param bool $assurance
     *
     * @return Reservation
     */
    public function setAssurance($assurance)
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * Get assurance.
     *
     * @return bool
     */
    public function getAssurance()
    {
        return $this->assurance;
    }
}