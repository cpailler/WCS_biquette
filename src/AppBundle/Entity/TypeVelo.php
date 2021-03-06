<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVelo
 *
 * @ORM\Table(name="type_velo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeVeloRepository")
 */
class TypeVelo
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Velo", mappedBy="typeVelo")
     */
    private $velos;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(name="prix_moyen", type="integer")
     */
    private $prixMoyen;

    /**
     * @ORM\Column(name="coeff", type="float")
     */
    private $coeff;

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
     * Set type.
     *
     * @param string $type
     *
     * @return TypeVelo
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->velos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add velo.
     *
     * @param \AppBundle\Entity\Velo $velo
     *
     * @return TypeVelo
     */
    public function addVelo(\AppBundle\Entity\Velo $velo)
    {
        $this->velos[] = $velo;

        return $this;
    }

    /**
     * Remove velo.
     *
     * @param \AppBundle\Entity\Velo $velo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeVelo(\AppBundle\Entity\Velo $velo)
    {
        return $this->velos->removeElement($velo);
    }

    /**
     * Get velos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVelos()
    {
        return $this->velos;
    }

    public function __toString()
    {
        return $this->type;
    }

    /**
<<<<<<< HEAD
     * Set prixMoyen.
     *
     * @param int $prixMoyen
=======
     * Set prixMoyen
     *
     * @param integer $prixMoyen
>>>>>>> dev
     *
     * @return TypeVelo
     */
    public function setPrixMoyen($prixMoyen)
    {
        $this->prixMoyen = $prixMoyen;

        return $this;
    }

    /**
<<<<<<< HEAD
     * Get prixMoyen.
     *
     * @return int
=======
     * Get prixMoyen
     *
     * @return integer
>>>>>>> dev
     */
    public function getPrixMoyen()
    {
        return $this->prixMoyen;
    }

    /**
<<<<<<< HEAD
     * Set coeff.
=======
     * Set coeff
>>>>>>> dev
     *
     * @param float $coeff
     *
     * @return TypeVelo
     */
    public function setCoeff($coeff)
    {
        $this->coeff = $coeff;

        return $this;
    }

    /**
<<<<<<< HEAD
     * Get coeff.
=======
     * Get coeff
>>>>>>> dev
     *
     * @return float
     */
    public function getCoeff()
    {
        return $this->coeff;
    }
}
