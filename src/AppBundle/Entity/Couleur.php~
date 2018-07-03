<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Couleur
 *
 * @ORM\Table(name="couleur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CouleurRepository")
 */
class Couleur
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
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="code_hexa", type="string", length=7)
     */
    private $codeHexa;


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
     * Set nom.
     *
     * @param string $nom
     *
     * @return Couleur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set codeHexa.
     *
     * @param string $codeHexa
     *
     * @return Couleur
     */
    public function setCodeHexa($codeHexa)
    {
        $this->codeHexa = $codeHexa;

        return $this;
    }

    /**
     * Get codeHexa.
     *
     * @return string
     */
    public function getCodeHexa()
    {
        return $this->codeHexa;
    }

    public function __toString()
    {
        return "";
    }
}
