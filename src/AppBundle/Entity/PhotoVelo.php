<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PhotoVelo
 * @Vich\Uploadable
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="velo_image", fileNameProperty="image")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "5M",
     *     maxSizeMessage="Votre fichier est trop volumineux, veuillez charger un fichier plus petit",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png"},
     *     mimeTypesMessage = "Veuillez télécharger un fichier au format .jpg ou .png"
     * )
     *
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    protected $image;


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

    /**
     * @return File
     */
    public function getImageFile ()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile ($imageFile)
    {
        $this->imageFile = $imageFile;
    }
}
