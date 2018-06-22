<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Velo
 *
 * @ORM\Table(name="velo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VeloRepository")
 */
class Velo
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Membre", inversedBy="velos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proprio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="marque", type="string", length=50, nullable=true)
     */
    private $marque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modele", type="string", length=50, nullable=true)
     */
    private $modele;

    /**
     * @var int|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeVelo", inversedBy="velos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $typeVelo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PhotoVelo", mappedBy="velo")
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Disponibilite", mappedBy="velo")
     */
    private $disponibilites;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reservation", mappedBy="velo")
     */
    private $reservations;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Equipement")
     */
    private $equipements;

    /**
     * @var int|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Couleur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $couleur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titre", type="string", length=35, nullable=true)
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EtatVelo")
     * @ORM\JoinColumn(nullable=true)
     */
    private $etatVelo;

    /**
     * @var bool
     *
     * @ORM\Column(name="neuf", type="boolean")
     */
    private $neuf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_facture", type="string", length=255, nullable=true)
     */
    private $numFacture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="magasin", type="string", length=255, nullable=true)
     */
    private $magasin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_achat", type="date", nullable=true)
     */
    private $dateAchat;

    /**
     * @var int
     *
     * @ORM\Column(name="antivol_key", type="integer")
     */
    private $antivolKey;

    /**
     * @var int
     *
     * @ORM\Column(name="antivol_code", type="integer")
     */
    private $antivolCode;

    /**
     * @var int|null
     *
     * @ORM\Column(name="bicycode", type="bigint", nullable=true)
     */
    private $bicycode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_velo", type="string", length=255, nullable=true)
     */
    private $adresseVelo;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var int|null
     *
     * @ORM\Column(name="caution", type="integer", nullable=true)
     */
    private $caution;

    /**
     * @var bool
     *
     * @ORM\Column(name="assur_oblig", type="boolean")
     */
    private $assurOblig = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="cout_pts", type="integer")
     */
    private $coutPts = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="dispo_totale", type="boolean")
     */
    private $dispoTotale = 0;


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
     * Set proprioId.
     *
     * @param int $proprio
     *
     * @return Velo
     */
    public function setProprio($proprio)
    {
        $this->proprio = $proprio;

        return $this;
    }

    /**
     * Get proprioId.
     *
     * @return int
     */
    public function getProprio()
    {
        return $this->proprio;
    }

    /**
     * Set marque.
     *
     * @param string $marque
     *
     * @return Velo
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque.
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set modele.
     *
     * @param string|null $modele
     *
     * @return Velo
     */
    public function setModele($modele = null)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele.
     *
     * @return string|null
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set typeVeloId.
     *
     * @param int|null $typeVelo
     *
     * @return Velo
     */
    public function setTypeVelo($typeVelo = null)
    {
        $this->typeVelo = $typeVelo;

        return $this;
    }

    /**
     * Get typeVeloId.
     *
     * @return int|null
     */
    public function getTypeVelo()
    {
        return $this->typeVelo;
    }

    /**
     * Set couleurId.
     *
     * @param int|null $couleur
     *
     * @return Velo
     */
    public function setCouleur($couleur = null)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleurId.
     *
     * @return int|null
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set titre.
     *
     * @param string|null $titre
     *
     * @return Velo
     */
    public function setTitre($titre = null)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string|null
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Velo
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set etatVeloId.
     *
     * @param int|null $etatVelo
     *
     * @return Velo
     */
    public function setEtatVelo($etatVelo = null)
    {
        $this->etatVelo = $etatVelo;

        return $this;
    }

    /**
     * Get etatVeloId.
     *
     * @return int|null
     */
    public function getEtatVelo()
    {
        return $this->etatVelo;
    }

    /**
     * Set neuf.
     *
     * @param bool $neuf
     *
     * @return Velo
     */
    public function setNeuf($neuf)
    {
        $this->neuf = $neuf;

        return $this;
    }

    /**
     * Get neuf.
     *
     * @return bool
     */
    public function getNeuf()
    {
        return $this->neuf;
    }

    /**
     * Set numFacture.
     *
     * @param string|null $numFacture
     *
     * @return Velo
     */
    public function setNumFacture($numFacture = null)
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    /**
     * Get numFacture.
     *
     * @return string|null
     */
    public function getNumFacture()
    {
        return $this->numFacture;
    }

    /**
     * Set magasin.
     *
     * @param string|null $magasin
     *
     * @return Velo
     */
    public function setMagasin($magasin = null)
    {
        $this->magasin = $magasin;

        return $this;
    }

    /**
     * Get magasin.
     *
     * @return string|null
     */
    public function getMagasin()
    {
        return $this->magasin;
    }

    /**
     * Set dateAchat.
     *
     * @param \DateTime|null $dateAchat
     *
     * @return Velo
     */
    public function setDateAchat($dateAchat = null)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat.
     *
     * @return \DateTime|null
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set antivolKey.
     *
     * @param int $antivolKey
     *
     * @return Velo
     */
    public function setAntivolKey($antivolKey)
    {
        $this->antivolKey = $antivolKey;

        return $this;
    }

    /**
     * Get antivolKey.
     *
     * @return int
     */
    public function getAntivolKey()
    {
        return $this->antivolKey;
    }

    /**
     * Set antivolCode.
     *
     * @param int $antivolCode
     *
     * @return Velo
     */
    public function setAntivolCode($antivolCode)
    {
        $this->antivolCode = $antivolCode;

        return $this;
    }

    /**
     * Get antivolCode.
     *
     * @return int
     */
    public function getAntivolCode()
    {
        return $this->antivolCode;
    }

    /**
     * Set bicycode.
     *
     * @param int|null $bicycode
     *
     * @return Velo
     */
    public function setBicycode($bicycode = null)
    {
        $this->bicycode = $bicycode;

        return $this;
    }

    /**
     * Get bicycode.
     *
     * @return int|null
     */
    public function getBicycode()
    {
        return $this->bicycode;
    }

    /**
     * Set adresseVelo.
     *
     * @param string|null $adresseVelo
     *
     * @return Velo
     */
    public function setAdresseVelo($adresseVelo = null)
    {
        $this->adresseVelo = $adresseVelo;

        return $this;
    }

    /**
     * Get adresseVelo.
     *
     * @return string|null
     */
    public function getAdresseVelo()
    {
        return $this->adresseVelo;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
     *
     * @return Latitude
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float|null $longitude
     *
     * @return Longitude
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set ville.
     *
     * @param string|null $ville
     *
     * @return Ville
     */
    public function setVille($ville = null)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * Get ville.
     *
     * @return string|null
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set caution.
     *
     * @param int|null $caution
     *
     * @return Velo
     */
    public function setCaution($caution = null)
    {
        $this->caution = $caution;

        return $this;
    }

    /**
     * Get caution.
     *
     * @return int|null
     */
    public function getCaution()
    {
        return $this->caution;
    }

    /**
     * Set assurOblig.
     *
     * @param bool $assurOblig
     *
     * @return Velo
     */
    public function setAssurOblig($assurOblig)
    {
        $this->assurOblig = $assurOblig;

        return $this;
    }

    /**
     * Get assurOblig.
     *
     * @return bool
     */
    public function getAssurOblig()
    {
        return $this->assurOblig;
    }

    /**
     * Set coutPts.
     *
     * @param int $coutPts
     *
     * @return Velo
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
     * Set dispoTotale.
     *
     * @param bool $dispoTotale
     *
     * @return Velo
     */
    public function setDispoTotale($dispoTotale)
    {
        $this->dispoTotale = $dispoTotale;

        return $this;
    }

    /**
     * Get dispoTotale.
     *
     * @return bool
     */
    public function getDispoTotale()
    {
        return $this->dispoTotale;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->disponibilites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photo.
     *
     * @param \AppBundle\Entity\PhotoVelo $photo
     *
     * @return Velo
     */
    public function addPhoto(\AppBundle\Entity\PhotoVelo $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo.
     *
     * @param \AppBundle\Entity\PhotoVelo $photo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePhoto(\AppBundle\Entity\PhotoVelo $photo)
    {
        return $this->photos->removeElement($photo);
    }

    /**
     * Get photos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add disponibilite.
     *
     * @param \AppBundle\Entity\Disponibilite $disponibilite
     *
     * @return Velo
     */
    public function addDisponibilite(\AppBundle\Entity\Disponibilite $disponibilite)
    {
        $this->disponibilites[] = $disponibilite;

        return $this;
    }

    /**
     * Remove disponibilite.
     *
     * @param \AppBundle\Entity\Disponibilite $disponibilite
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDisponibilite(\AppBundle\Entity\Disponibilite $disponibilite)
    {
        return $this->disponibilites->removeElement($disponibilite);
    }

    /**
     * Get disponibilites.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisponibilites()
    {
        return $this->disponibilites;
    }

    /**
     * Add reservation.
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Velo
     */
    public function addReservation(\AppBundle\Entity\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation.
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeReservation(\AppBundle\Entity\Reservation $reservation)
    {
        return $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Add equipement.
     *
     * @param \AppBundle\Entity\Equipement $equipement
     *
     * @return Velo
     */
    public function addEquipement(\AppBundle\Entity\Equipement $equipement)
    {
        $this->equipements[] = $equipement;

        return $this;
    }

    /**
     * Remove equipement.
     *
     * @param \AppBundle\Entity\Equipement $equipement
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeEquipement(\AppBundle\Entity\Equipement $equipement)
    {
        return $this->equipements->removeElement($equipement);
    }

    /**
     * Get equipements.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipements()
    {
        return $this->equipements;
    }

    public function __toString()
    {
        if(isset($this->titre)){
            return $this->titre;
        }
        return 'Vélo n° '.$this->id;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
