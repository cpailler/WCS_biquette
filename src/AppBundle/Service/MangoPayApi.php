<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 05/06/18
 * Time: 21:28
 */

namespace AppBundle\Service;
use AppBundle\Entity\Membre;
use Doctrine\ORM\Mapping as ORM;

use MangoPay;


class MangoPayApi
{

    private $connexionApi;

    //Appel a l'API MangoPay
    public function __construct()
    {
        // create object to manage MangoPay API
        $this->connexionApi = new MangoPay\MangoPayApi();
        // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
        $this->connexionApi->Config->ClientId = 'aurelgouilhers';
        $this->connexionApi->Config->ClientPassword = 'wr42AYOg5LU5OE3dn10qNrbfsDC7iYeRHu3N4Gjw3KtGDuSC1V';
        $this->connexionApi->Config->TemporaryFolder = '/home/wilder/BIKERR SYMFONY PROJECT 3/bikerr/TEMP_MANGOPAY';
    }

    /**
     * Create MangoUser
     * @return MangoPayUser $mangoUser
     * @param $email
     * @param $firstname
     * @param $lastname
     * @param $birthday
     * @param $nationality
     * @param $country
     * @paramConverter
     */
    public function CreateNaturalUser(Membre $membre){
        $MangoUser = new MangoPay\UserNatural();  //initialisation MangoPay Object
        //injection parameter necessary
        $MangoUser->Email = $membre->getEmail();
        $MangoUser->FirstName = $membre->getPrenom();
        $MangoUser->LastName = $membre->getNom();
        $MangoUser->Birthday = $membre->getDateNaissance()->getTimestamp();
        $MangoUser->Nationality = $membre->getPays();
        $MangoUser->CountryOfResidence = $membre->getPays();
        $MangoUser = $this->connexionApi->Users->Create($MangoUser); //creation naturalUser with those parameter
        return $MangoUser->Id;
    }

    public function CreateWallet(Membre $membre){
        // CREATION WALLET NATURAL USER
        $Wallet = new \MangoPay\Wallet();
        $Wallet->Owners = array($membre->getIdMangopay());
        $Wallet->Description = "Wallet of ".$membre->getPrenom()." ".$membre->getNom();
        $Wallet->Currency = "EUR";
        return $this->connexionApi->Wallets->Create($Wallet)->Id;
    }

    //creation objet CARD
    public function CardRegistration(Membre $membre){
        $cardRegister = new \MangoPay\CardRegistration();
        $cardRegister->UserId = $membre->getIdMangopay();
        $cardRegister->Currency = "EUR";
        return $this->connexionApi->CardRegistrations->Create($cardRegister);
    }

    // creation objet CardID
    public function CardUpdate(\MangoPay\CardRegistration $carte,$registrationId)
    {
        dump($registrationId);
        dump($carte);
        $CardRegistration = $this->connexionApi->CardRegistrations->Get($carte->Id);
        $CardRegistration->RegistrationData = 'data=' . $registrationId;
        return $this->connexionApi->CardRegistrations->Update($CardRegistration);
        //$this->connexionApi->Cards->Get($result->CardId);
    }

    //création d'une PayIn Card
    public function PayIn(Membre $membre, \MangoPay\CardRegistration $Card, $amount, $fees)
    {
        /*$PayIn = new \MangoPay\PayIn();
        $PayIn->CreditedWalletId = $membre->getIdWallet();
        $PayIn->CreditedUserId = $membre->getIdMangopay();
        $PayIn->AuthorId = $membre->getIdMangopay();
        $PayIn->PaymentType = "CARD";
        $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
        $PayIn->DebitedFunds = new \MangoPay\Money();
        $PayIn->DebitedFunds->Currency = "EUR";
        $PayIn->DebitedFunds->Amount = $amount;
        $PayIn->Fees = new \MangoPay\Money();
        $PayIn->Fees->Currency = "EUR";
        $PayIn->Fees->Amount = $fees;
        $PayIn->ExecutionType = "DIRECT";
        $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $PayIn->ExecutionDetails->SecureMode = "DEFAULT";
        //TODO : ReturnURL à changer et à comprendre
        //$PayIn->ExecutionDetails->SecureModeReturnURL = "http://localhost:8001/cardRegisterForm";
        $PayIn->ExecutionDetails->CardId = $Card->CardId;
        $PayIn->Tag = "blabla";

        return $this->connexionApi->PayIns->Create($PayIn);*/

        $stepId=0;
        $PayIn = new \MangoPay\PayIn();
        $PayIn->CreditedWalletId = $membre->getIdWallet();
        $PayIn->AuthorId = $membre->getIdMangopay();
        $PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
        $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
        $PayIn->DebitedFunds = new \MangoPay\Money();
        $PayIn->DebitedFunds->Currency = "EUR";
        $PayIn->DebitedFunds->Amount = $amount;
        $PayIn->Fees = new \MangoPay\Money();
        $PayIn->Fees->Currency = "EUR";
        $PayIn->Fees->Amount = $fees;
        $PayIn->ExecutionType = \MangoPay\PayInExecutionType::Web;
        $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $PayIn->ExecutionDetails->ReturnURL = "http".(isset($_SERVER['HTTPS']) ? "s" : null)."://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1);
        $PayIn->ExecutionDetails->Culture = "FR";
        //dump($Card->Id);
        $PayIn->ExecutionDetails->CardId = $Card->CardId;
        return $this->connexionApi->PayIns->Create($PayIn);
    }

    //transferer l'argent d'un wallet a un autre wallet
    public function transfert(Membre $membre, Membre $membre2, $amount, $fees)
    {
        $Transfer = new \MangoPay\Transfer();
        $Transfer->AuthorId = $membre->getIdMangopay();
        $Transfer->DebitedFunds = new \MangoPay\Money();
        $Transfer->DebitedFunds->Currency = "EUR";
        $Transfer->DebitedFunds->Amount = round($amount, 2) * 100 - round($fees, 2) * 100;
        $Transfer->Fees = new \MangoPay\Money();
        $Transfer->Fees->Currency = "EUR";
        $Transfer->Fees->Amount = 0;
        $Transfer->DebitedWalletID = $membre->getIdWallet();
        $Transfer->CreditedWalletId = $membre2->getIdWallet();
        return $this->connexionApi->Transfers->Create($Transfer);
    }

    //cloturer transfert d'argent
    public function PayOut()
    {
        $PayOut = new \MangoPay\PayOut();
        $PayOut->AuthorId = $_SESSION["MangoPayDemo"]["UserLegal"];
        $PayOut->DebitedWalletId = $_SESSION["MangoPayDemo"]["WalletForLegalUser"];
        $PayOut->DebitedFunds = new \MangoPay\Money();
        $PayOut->DebitedFunds->Currency = "EUR";
        $PayOut->DebitedFunds->Amount = 610;
        $PayOut->Fees = new \MangoPay\Money();
        $PayOut->Fees->Currency = "EUR";
        $PayOut->Fees->Amount = 125;
        $PayOut->PaymentType = \MangoPay\PayOutPaymentType::BankWire;
        $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
        $PayOut->MeanOfPaymentDetails->BankAccountId = $_SESSION["MangoPayDemo"]["BankAccount"];
        $result = $mangoPayApi->PayOuts->Create($PayOut);
    }

    // remboursement
    public function Refund()
    {
        $PayInId = $_SESSION["MangoPayDemo"]["PayInCardWeb"];
        $Refund = new \MangoPay\Refund();
        $Refund->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
        $Refund->DebitedFunds = new \MangoPay\Money();
        $Refund->DebitedFunds->Currency = "EUR";
        $Refund->DebitedFunds->Amount = 650;
        $Refund->Fees = new \MangoPay\Money();
        $Refund->Fees->Currency = "EUR";
        $Refund->Fees->Amount = -50;
        $result = $mangoPayApi->PayIns->CreateRefund($PayInId, $Refund);
    }

    //executer le remboursement
    public function DoARefund()
    {
        $TransferId = $_SESSION["MangoPayDemo"]["Transfer"];
        $Refund = new \MangoPay\Refund();
        $Refund->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
        $Refund->DebitedFunds = new \MangoPay\Money();
        $Refund->DebitedFunds->Currency = "EUR";
        $Refund->DebitedFunds->Amount = 760;//Note that partial Refunds for Transfers are not possible
        $Refund->Fees = new \MangoPay\Money();
        $Refund->Fees->Currency = "EUR";
        $Refund->Fees->Amount = -150;
        $result = $mangoPayApi->Transfers->CreateRefund($TransferId, $Refund);
    }
}