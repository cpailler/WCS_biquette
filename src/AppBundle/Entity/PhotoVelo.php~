<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoVelo
 *
 * @ORM\Table(name="photo_velo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoVeloRepository")
 */
class PhotoVelo
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Velo", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $velo;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * @param int $velo
     *
     * @return PhotoVelo
     */
    public function setVelo($velo)
    {
        $this->velo = $velo;

        return $this;
    }

    /**
     * Get veloId.
     *
     * @return int
     */
    public function getVelo()
    {
        return $this->velo;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return PhotoVelo
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
