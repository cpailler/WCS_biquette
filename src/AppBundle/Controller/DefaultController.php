<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Membre;
use AppBundle\Service\MangoPayApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;




class DefaultController extends Controller
{
    /**
     * @Route("/cardRegisterForm", name="homedefault")
     */
    public function indexAction(Request $request, MangoPayApi $mangopayapi)
    {
        // On crée une session pour simuler la persistance des données
        $session = $request->getSession();

        //membre 1
        $membreMP = new Membre();
        $membreMP->setEmail('luc.camarche@gmail.com');
        $membreMP->setNom('CAMARCHE');
        $membreMP->setPrenom('Luc');
        $membreMP->setDateNaissance(new \DateTime('17-03-1988'));
        $membreMP->setPays('FR');
        //membre2
        $membreMP1 = new Membre();
        $membreMP1->setEmail('atomic67200@gmail.com');
        $membreMP1->setNom('CAMARCHE');
        $membreMP1->setPrenom('Aurélien');
        $membreMP1->setDateNaissance(new \DateTime('28-04-1984'));
        $membreMP1->setPays('FR');

        //creation d'un membre Mango Pay à partir des membres en base
        $membreMP->setIdMangopay($mangopayapi->CreateNaturalUser($membreMP));
        $membreMP1->setIdMangopay($mangopayapi->CreateNaturalUser($membreMP1));

        //on crée les wallets à partir des membres
        $membreMP->setIdWallet($mangopayapi->CreateWallet($membreMP));
        $membreMP1->setIdWallet($mangopayapi->CreateWallet($membreMP1));

        //cartes
        $card1 = $mangopayapi->CardRegistration($membreMP);
        $card2 = $mangopayapi->CardRegistration($membreMP1);

        // On enregistre l'id du membre1
        $session->set('membre1', $membreMP);
        $session->set('membre2', $membreMP1);
        dump($membreMP);
        dump($membreMP1);
        // On enregistre l'id des cards
        $session->set('card1', $card1);
        $session->set('card2', $card2);
        dump($card1);
        dump($card2);
        //on défini une valeur de retour d'URL pour pouvoir enregistrer la carte chez nous
        $returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
        $returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], ' ') + 1);
        $returnUrl .= 'cardRegistration';
        $session->set('returnUrl', $returnUrl);
        //appel de la vue
        return $this->render('default/cardRegisterForm.html.twig', [
            'card'=>$card1,
        'returnUrl'=>$returnUrl
        ]);
    }

    /**
     * @Route("/cardRegistration", name="carte")
     */
    public function cardRegisterAction(Request $request, MangoPayApi $mangopayapi)
    {
        //on récupere les elements de session
        $session = $request->getSession();
        $Carte1 = $session->get('card1');
        $Carte2 = $session->get('card2'); // pas utilisé
        $membre1 = $session->get('membre1');
        $membre2 = $session->get('membre2');
        //on récupere le CardRegistration envoyé en Get
        $Carte= $mangopayapi->CardUpdate($Carte1,$request->query->get('data'));
        //on défini la somme à envoyer
        //et les frais
        $Amount = 4900;  // 49€€€
        //les frais sont à 5% aujourd'hui car Bikerr ne
        //preleve pas d'argent sur un pret de velo
        //cette valeur sera a calculer pour les cautions (%5)
        $fees = 0;
        //on génère un PayIn de membre1
        //on récupère le résultat de la génération du PayIn
        //si il est OK, on peut proceder au transfert
        $resultatDuPayIn = $mangopayapi->CreateDirectCardPayIn($membre1,$Carte, $Amount, $fees);
        //$resultatDuPayIn2 = $mangopayapi->CreateDirectCardPayIn($membre2,$Amount, $fees);
        dump($resultatDuPayIn);
        $Amount2 = 10;
        $transfert =$mangopayapi->transfert($membre1, $membre2, $Amount2, $fees);
        dump($transfert);

        $session->set('membre1', $membre1);

        return $this->render('default/bankAccountRegistration.html.twig', ['cardId'=>$Carte1]);
    }


    /**
     * @Route("/FormBankAccount", name="Form")
     * @Method()
     */
    public function FormBankAccountAction(Request $request,MangoPayApi $mangopayapi)
    {
        //initialisation session
        $session = $request->getSession();
        //recuperation en session membre1
        $membre1 = $session->get('membre1');
        //$membre2 = $session->get('membre2');

        if ($request->getMethod() == 'POST')
            {
            if((isset($_POST['titul_compte']))
            && (isset($_POST['adresse']))
            && (isset($_POST['Pays']))
            && (isset($_POST['iban']))
            && (isset($_POST['bic'])))
                {
                    $firstPayment  = $mangopayapi->PayOut($membre1,50697827 ,2000,0);
                   $Bank = $mangopayapi->InitBankAccount($membre1,$_POST['iban'],$_POST['bic'],$_POST['titul_compte'],$_POST['adresse']);
                   dump($Bank);
                   $session->set('Bank', $Bank);
                }
            }

            if(isset($Bank))
            {
                $Bank1 = $session->get('Bank');
                $firstPayment  = $mangopayapi->PayOut($membre1,$Bank1 ,2000,0);
                dump($firstPayment);
            }


            return $this->render('default/bankAccountRegistration.html.twig');

    }

}