<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 25/06/18
 * Time: 16:04
 */

namespace AppBundle\Entity;


class CartePaiement
{

    private $card_type;

   // private $card_owner;

    private $card_number;

    private $card_exp;

    private $card_cvv;

    private $CardRegistrationURL;

    private $PreregistrationData;

    private $AccessKey;

    private $returnUrl;

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }



    /**
     * @return mixed
     */
    public function getCardRegistrationURL()
    {
        return $this->CardRegistrationURL;
    }

    /**
     * @param mixed $CardRegistrationURL
     */
    public function setCardRegistrationURL($CardRegistrationURL)
    {
        $this->CardRegistrationURL = $CardRegistrationURL;
    }

    /**
     * @return mixed
     */
    public function getPreregistrationData()
    {
        return $this->PreregistrationData;
    }

    /**
     * @param mixed $PreregistrationData
     */
    public function setPreregistrationData($PreregistrationData)
    {
        $this->PreregistrationData = $PreregistrationData;
    }

    /**
     * @return mixed
     */
    public function getAccessKey()
    {
        return $this->AccessKey;
    }

    /**
     * @param mixed $AccessKey
     */
    public function setAccessKey($AccessKey)
    {
        $this->AccessKey = $AccessKey;
    }



    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->card_type;
    }

    /**
     * @param mixed $card_type
     */
    public function setCardType($card_type)
    {
        $this->card_type = $card_type;
    }

//    /**
//     * @return mixed
//     */
//    public function getCardOwner()
//    {
//        return $this->card_owner;
//    }
//
//    /**
//     * @param mixed $card_owner
//     */
//    public function setCardOwner($card_owner)
//    {
//        $this->card_owner = $card_owner;
//    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
    }

    /**
     * @return mixed
     */
    public function getCardExp()
    {
        return $this->card_exp;
    }

    /**
     * @param mixed $card_exp
     */
    public function setCardExp($card_exp)
    {
        $this->card_exp = $card_exp;
    }

    /**
     * @return mixed
     */
    public function getCardCvv()
    {
        return $this->card_cvv;
    }

    /**
     * @param mixed $card_cvv
     */
    public function setCardCvv($card_cvv)
    {
        $this->card_cvv = $card_cvv;
    }

}