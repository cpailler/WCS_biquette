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
use MangoPay\Libraries\Exception;
use MangoPay\Libraries\ResponseException;


class MangoPayApi
{

    private $connexionApi;

    //Appel a l'API MangoPay
    public function __construct()
    {
        // create object to manage MangoPay API
        $this->connexionApi = new MangoPay\MangoPayApi();
        // login : password : temp directory
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
    public function CreateNaturalUser(Membre $membre)
    {
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

    public function CreateWallet(Membre $membre)
    {
        // CREATION WALLET NATURAL USER
        $Wallet = new \MangoPay\Wallet();
        $Wallet->Owners = array($membre->getIdMangopay());
        $Wallet->Description = "Wallet of " . $membre->getPrenom() . " " . $membre->getNom();
        $Wallet->Currency = "EUR";
        return $this->connexionApi->Wallets->Create($Wallet)->Id;
    }

    //creation objet CARD
    public function CardRegistration(Membre $membre)
    {
        $cardRegister = new \MangoPay\CardRegistration();
        $cardRegister->UserId = $membre->getIdMangopay();
        $cardRegister->CardType = "CB_VISA_MASTERCARD";
        $cardRegister->Currency = "EUR";
        return $this->connexionApi->CardRegistrations->Create($cardRegister);

    }

    // creation objet CardID
    public function CardUpdate(\MangoPay\CardRegistration $carte, $registrationId)
    {
        //dump($registrationId);
        //dump($carte);
        $CardRegistration = $this->connexionApi->CardRegistrations->Get($carte->Id);
        $CardRegistration->RegistrationData = 'data=' . $registrationId;
        $CardUpdate = $this->connexionApi->CardRegistrations->Update($CardRegistration);
        //dump($CardUpdate);
        return $this->connexionApi->Cards->Get($CardUpdate->CardId);

        //$this->connexionApi->Cards->Get($result->CardId);

    }

    //création d'une PayIn Card
    public function PayIn(Membre $membre, \MangoPay\Card $CardObject, $amount, $fees)
    {
        $PayIn = new \MangoPay\PayIn();
        $PayIn->CreditedWalletId = $membre->getIdWallet();
        $PayIn->AuthorId = $membre->getIdMangopay(); //TODO : verifier author id -> qui est ce ?
        $PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
        $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $PayIn->PaymentDetails->CardType = "CB_VISA_MASTERCARD";
        $PayIn->DebitedFunds = new \MangoPay\Money();
        $PayIn->DebitedFunds->Currency = "EUR";
        $PayIn->DebitedFunds->Amount = $amount;
        $PayIn->Fees = new \MangoPay\Money();
        $PayIn->Fees->Currency = "EUR";
        $PayIn->Fees->Amount = $fees;
        // $PayIn->ExecutionType = \MangoPay\PayInExecutionType::Web;
        // $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        //$PayIn->ExecutionDetails->SecureModeReturnURL = "http://127.0.0.1/";//".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]."?stepId=".($stepId+1);
        //$PayIn->ExecutionDetails->CardId = $Card->CardId;
        //$PayIn->ExecutionDetails->SecureMode="DEFAULT";
        //$PayIn->ExecutionDetails->Culture = "FR";
        //dump($Card->Id);
        //TODO : Paiement type direct
        $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $PayIn->PaymentDetails->CardType = $CardObject->CardType;
        $PayIn->PaymentDetails->CardId = $CardObject->Id;
        //TODO : execution direct
        $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $PayIn->ExecutionDetails->SecureModeReturnURL = 'http://localhost/cardRegisterForm';

        return $this->connexionApi->PayIns->Create($PayIn);
    }

    //transferer l'argent d'un wallet a un autre wallet
    public function transfert(Membre $membre, Membre $membre2, $amount, $fees)
    {
        $Transfer = new \MangoPay\Transfer();
        $Transfer->AuthorId = $membre->getIdMangopay();
        $Transfer->DebitedFunds = new \MangoPay\Money();
        $Transfer->DebitedFunds->Currency = "EUR";
        $Transfer->DebitedFunds->Amount = $amount;
        $Transfer->Fees = new \MangoPay\Money();
        $Transfer->Fees->Currency = "EUR";
        $Transfer->Fees->Amount = $fees;
        $Transfer->DebitedWalletID = $membre->getIdWallet();
        $Transfer->CreditedWalletId = $membre2->getIdWallet();
        return $this->connexionApi->Transfers->Create($Transfer);
    }

    //creation BankAccount Object pour effectuer les PayOut

    public function InitBankAccount(Membre $membre ,$iban, $bic, $titulaire, $adresse)
    {
        $UserId = $membre->getIdMangopay();
        $BankAccount = new \MangoPay\BankAccount();
        $BankAccount->UserId=$membre->getIdMangopay();
        $BankAccount->Type = "IBAN";
        $BankAccount->Details = new MangoPay\BankAccountDetailsIBAN();
        $BankAccount->Details->IBAN = $iban;
        $BankAccount->Details->BIC = $bic;
        $BankAccount->OwnerName = $titulaire;
        $BankAccount->OwnerAddress = new \MangoPay\Address();
        $BankAccount->OwnerAddress->AddressLine1 = $adresse;
        $BankAccount->OwnerAddress->AddressLine2 = "";
        $BankAccount->OwnerAddress->City = $membre->getVille();
        $BankAccount->OwnerAddress->Country = $membre->getPays();
        $BankAccount->OwnerAddress->PostalCode = $membre->getCodePostal();
        $BankAccount->OwnerAddress->Region = "";
        //$BankAccount->Active = true;

        return $this->connexionApi->Users->CreateBankAccount($UserId, $BankAccount);
    }


    //cloturer transfert d'argent
    public function PayOut(Membre $membre,\MangoPay\BankAccount $bankAccount, $amount, $fees)
    {
        $PayOut = new \MangoPay\PayOut();
        $PayOut->AuthorId = $membre->getIdMangopay();
        $PayOut->DebitedWalletId = $membre->getIdWallet();
        $PayOut->DebitedFunds = new \MangoPay\Money();
        $PayOut->DebitedFunds->Currency = "EUR";
        $PayOut->DebitedFunds->Amount = $amount;
        $PayOut->Fees = new \MangoPay\Money();
        $PayOut->Fees->Currency = "EUR";
        $PayOut->Fees->Amount = $fees;
        $PayOut->PaymentType = \MangoPay\PayOutPaymentType::BankWire;
        $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
        $PayOut->MeanOfPaymentDetails->BankAccountId = $bankAccount->Id;
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
    //preauthporization valable 7jour pour caution