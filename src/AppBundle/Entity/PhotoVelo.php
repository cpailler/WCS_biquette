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
     * @ORM\Column(name="velo_id", type="integer")
     */
    private $veloId;

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
     * @param int $veloId
     *
     * @return PhotoVelo
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
