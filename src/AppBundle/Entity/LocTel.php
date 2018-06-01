<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocTel
 *
 * @ORM\Table(name="loc_tel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocTelRepository")
 */
class LocTel
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
     * @var string
     *
     * @ORM\Column(name="indice", type="string", length=10)
     */
    private $indice;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Pays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pays;


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
     * Set indice.
     *
     * @param string $indice
     *
     * @return LocTel
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * Get indice.
     *
     * @return string
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * Set pays.
     *
     * @param int $pays
     *
     * @return LocTel
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays.
     *
     * @return int
     */
    public function getPays()
    {
        return $this->pays;
    }
}
