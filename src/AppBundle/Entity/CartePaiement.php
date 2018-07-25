<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 25/06/18
 * Time: 16:04
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CartePaiement
{
    /**
     * @Assert\NotBlank()
     */
    private $card_type;

    /**
     * @Assert\NotBlank()
     */
    private $cardNumber;

    /**
     * @Assert\NotBlank()
     */
    private $cardExpirationDate;

    /**
     * @Assert\NotBlank()
     */
    private $cardCvx;

    private $CardRegistrationURL;

    private $data;

    private $accessKeyRef;

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
    public function getAccessKeyRef()
    {
        return $this->accessKeyRef;
    }

    /**
     * @param mixed $accessKeyRef
     */
    public function setAccessKeyRef($accessKeyRef)
    {
        $this->accessKeyRef = $accessKeyRef;
    }



    /**
     * @return mixed
     */
    public function getCardRegistrationURL()
    {
        return $this->CardRegistrationURL;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
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

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param mixed $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return mixed
     */
    public function getCardExpirationDate()
    {
        return $this->cardExpirationDate;
    }

    /**
     * @param mixed $cardExpirationDate
     */
    public function setCardExpirationDate($cardExpirationDate)
    {
        $this->cardExpirationDate = $cardExpirationDate;
    }

    /**
     * @return mixed
     */
    public function getCardCvx()
    {
        return $this->cardCvx;
    }

    /**
     * @param mixed $cardCvx
     */
    public function setCardCvx($cardCvx)
    {
        $this->cardCvx = $cardCvx;
    }

}