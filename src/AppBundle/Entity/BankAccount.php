<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 29/06/18
 * Time: 10:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class BankAccount
{
    private $iban;

    private $bic;

    private $owner_account;

    private $adresse;

    private $postal_code;

    private $pays;

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param mixed $bic
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
    }

    /**
     * @return mixed
     */
    public function getOwnerAccount()
    {
        return $this->owner_account;
    }

    /**
     * @param mixed $owner_account
     */
    public function setOwnerAccount($owner_account)
    {
        $this->owner_account = $owner_account;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }


}