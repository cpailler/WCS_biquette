<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * membre
 *
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MembreRepository")
 */
class Membre
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
     * @var int|null
     *
     * @ORM\Column(name="id_mangopay", type="integer", nullable=true)
     */
    private $idMangopay;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_wallet", type="integer", nullable=true)
     */
    private $idWallet;

    /**
     * @var int|null
     *
     * @ORM\Column(name="id_facebook", type="integer", nullable=true)
     */
    private $idFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=45)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=70)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int|null
     *
     * @ORM\Column(name="genre_id", type="integer", nullable=true)
     */
    private $genreId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar_image", type="string", length=255, nullable=true)
     */
    private $avatarImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="date")
     */
    private $dateInscription;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_velo_emprunte", type="integer")
     */
    private $nbVeloEmprunte;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_velo_prete", type="integer")
     */
    private $nbVeloPrete;

    /**
     * @var int
     *
     * @ORM\Column(name="pays_id", type="integer")
     */
    private $paysId;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="code_postal", type="integer")
     */
    private $codePostal;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

    /**
     * @var bool
     *
     * @ORM\Column(name="tel_public", type="boolean")
     */
    private $telPublic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var bool
     *
     * @ORM\Column(name="membre_verifie", type="boolean")
     */
    private $membreVerifie;

    /**
     * @var string
     *
     * @ORM\Column(name="key_mdp", type="string", length=255)
     */
    private $keyMdp;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;


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
     * Set idMangopay.
     *
     * @param int|null $idMangopay
     *
     * @return Membre
     */
    public function setIdMangopay($idMangopay = null)
    {
        $this->idMangopay = $idMangopay;

        return $this;
    }

    /**
     * Get idMangopay.
     *
     * @return int|null
     */
    public function getIdMangopay()
    {
        return $this->idMangopay;
    }

    /**
     * Set idWallet.
     *
     * @param int|null $idWallet
     *
     * @return Membre
     */
    public function setIdWallet($idWallet = null)
    {
        $this->idWallet = $idWallet;

        return $this;
    }

    /**
     * Get idWallet.
     *
     * @return int|null
     */
    public function getIdWallet()
    {
        return $this->idWallet;
    }

    /**
     * Set idFacebook.
     *
     * @param int|null $idFacebook
     *
     * @return Membre
     */
    public function setIdFacebook($idFacebook = null)
    {
        $this->idFacebook = $idFacebook;

        return $this;
    }

    /**
     * Get idFacebook.
     *
     * @return int|null
     */
    public function getIdFacebook()
    {
        return $this->idFacebook;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return Membre
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Membre
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
     * Set password.
     *
     * @param string $password
     *
     * @return Membre
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Membre
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set genreId.
     *
     * @param int|null $genreId
     *
     * @return Membre
     */
    public function setGenreId($genreId = null)
    {
        $this->genreId = $genreId;

        return $this;
    }

    /**
     * Get genreId.
     *
     * @return int|null
     */
    public function getGenreId()
    {
        return $this->genreId;
    }

    /**
     * Set avatarImage.
     *
     * @param string|null $avatarImage
     *
     * @return Membre
     */
    public function setAvatarImage($avatarImage = null)
    {
        $this->avatarImage = $avatarImage;

        return $this;
    }

    /**
     * Get avatarImage.
     *
     * @return string|null
     */
    public function getAvatarImage()
    {
        return $this->avatarImage;
    }

    /**
     * Set dateInscription.
     *
     * @param \DateTime $dateInscription
     *
     * @return Membre
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription.
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set nbVeloEmprunte.
     *
     * @param int $nbVeloEmprunte
     *
     * @return Membre
     */
    public function setNbVeloEmprunte($nbVeloEmprunte)
    {
        $this->nbVeloEmprunte = $nbVeloEmprunte;

        return $this;
    }

    /**
     * Get nbVeloEmprunte.
     *
     * @return int
     */
    public function getNbVeloEmprunte()
    {
        return $this->nbVeloEmprunte;
    }

    /**
     * Set nbVeloPrete.
     *
     * @param int $nbVeloPrete
     *
     * @return Membre
     */
    public function setNbVeloPrete($nbVeloPrete)
    {
        $this->nbVeloPrete = $nbVeloPrete;

        return $this;
    }

    /**
     * Get nbVeloPrete.
     *
     * @return int
     */
    public function getNbVeloPrete()
    {
        return $this->nbVeloPrete;
    }

    /**
     * Set paysId.
     *
     * @param int $paysId
     *
     * @return Membre
     */
    public function setPaysId($paysId)
    {
        $this->paysId = $paysId;

        return $this;
    }

    /**
     * Get paysId.
     *
     * @return int
     */
    public function getPaysId()
    {
        return $this->paysId;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return Membre
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set coedPostal.
     *
     * @param string $codePostal
     *
     * @return Membre
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get coedPostal.
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set tel.
     *
     * @param int $tel
     *
     * @return Membre
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set telPublic.
     *
     * @param bool $telPublic
     *
     * @return Membre
     */
    public function setTelPublic($telPublic)
    {
        $this->telPublic = $telPublic;

        return $this;
    }

    /**
     * Get telPublic.
     *
     * @return bool
     */
    public function getTelPublic()
    {
        return $this->telPublic;
    }

    /**
     * Set dateNaissance.
     *
     * @param \DateTime $dateNaissance
     *
     * @return Membre
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance.
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set membreVerifie.
     *
     * @param bool $membreVerifie
     *
     * @return Membre
     */
    public function setMembreVerifie($membreVerifie)
    {
        $this->membreVerifie = $membreVerifie;

        return $this;
    }

    /**
     * Get membreVerifie.
     *
     * @return bool
     */
    public function getMembreVerifie()
    {
        return $this->membreVerifie;
    }

    /**
     * Set keyMdp.
     *
     * @param string $keyMdp
     *
     * @return Membre
     */
    public function setKeyMdp($keyMdp)
    {
        $this->keyMdp = $keyMdp;

        return $this;
    }

    /**
     * Get keyMdp.
     *
     * @return string
     */
    public function getKeyMdp()
    {
        return $this->keyMdp;
    }

    /**
     * Set points.
     *
     * @param int $points
     *
     * @return Membre
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points.
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }
}