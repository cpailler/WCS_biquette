<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 22/06/18
 * Time: 09:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Membre;
use AppBundle\Service\MangoPayApi;
use AppBundle\Form\CartePaiementType;
use AppBundle\Entity\CartePaiement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Session\Session;






/**
 * Paiement controller.
 *
 * @Route("paiement")
 */
class PaiementController extends Controller
{



    /**
     * @Route("/card", name="paiement_card")
     * @Method({"GET", "POST"})
     *
     */
    public function RegisterCardView(Request $request,MangoPayApi $mangoPayApi)
    {
        $session = new Session();
        //$session->start();

        //declaration reoute retour pour recuperation card_Id object
        $returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
        $returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], ' ') + 1);
        $returnUrl .= 'paiement/card_Id';

        //on récupere l'utilisateur actuel
        $membre = $this->getUser();

        //si il n'a pas encore d'Id MangoPay, on lui crée
        if($membre->getIdMangopay() == null)
        {
            $membre->setIdMangopay($mangoPayApi->CreateNaturalUser($membre));
        }
        //si il n'a pas encore de wallet, on lui crée
        if($membre->getIdWallet() == null)
        {
            $membre->setIdWallet($mangoPayApi->CreateWallet($membre));
        }

        $cardRegistration = $mangoPayApi->CardRegistration($membre);

        dump($cardRegistration);

        $CartePaiement= new CartePaiement();

        $CartePaiement->setdata($cardRegistration->PreregistrationData);
        $CartePaiement->setAccessKeyRef($cardRegistration->AccessKey);
        $CartePaiement->setReturnUrl($returnUrl);
        $form = $this->createForm(CartePaiementType::class, $CartePaiement, array(
            'action' => $cardRegistration->CardRegistrationURL,
        ));

        //sauveagarde en session de l'objet cardRegistration
        $session->set('cardregistration', $cardRegistration);

        //recuperation requete GET & POST
        $form->handleRequest($request);

        //Validation du formulaire

        if ($form->isSubmitted() && $form->isValid()) {

            $data=$request->query->get('data');
            dump($data);
            $CardID = $form->getData();

        }

        // Accès au retour de $_POST
        //$request->request->get('CardRegisterForm'); // post ???

        // Envoi de la vue
        return $this->render('paiement/CartePaiement.html.twig',array(
            'form'=>$form->createView(),
            'cardregistration' => $cardRegistration
        ));
    }
    /**
     * @Route("/card_Id", name="get_card_id")
     * @Method({"GET", "POST"})
     *
     */
    public function GetCardID(Request $request,MangoPayApi $mangoPayApi)
    {
        $session = new Session();

        $cardRegistration = $session->get('cardregistration');
        //$RegistrationData = $session->get('RegistrationData');

       // dump($RegistrationData);

        dump($cardRegistration);

        $CarteUpdated = $mangoPayApi->CardUpdate($cardRegistration,$request->query->get('data'));

        dump($CarteUpdated);

        return $this->render('paiement/CartePaiement.html.twig',array(
            'form'=>$form->createView(),
            'cardregistration' => $cardRegistration
        ));


    }
}