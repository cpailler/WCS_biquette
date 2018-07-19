<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 22/06/18
 * Time: 09:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Membre;
use AppBundle\Entity\Reservation;
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
use Doctrine\ORM\EntityManagerInterface;




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
     * @param Request $request
     * @param MangoPayApi $mangoPayApi
     * @param Membre $membre
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegisterCardView(Request $request,MangoPayApi $mangoPayApi)
    {
        $session = new Session();

        //on récupere l'utilisateur actuel
        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        //on verifie que les id mangopay existe ou on les crée et les enregistre en BDD
        $membre = $mangoPayApi->CheckIdMangopay($membre,$em);
        //si le wallet n'est pas crée on fait une redirection
        if($membre->getIdWallet() == null)
        {
            return $this->redirectToRoute("profil_infos");
        }
        //le profil mango Pay et le wallet MP sont crée alors on enregistre sa carte
        $cardRegistration = $mangoPayApi->CardRegistration($membre);
        //on crée l'objet de l'entité CartePaiement qui nous servira à faire notre formulaire
        //on le rempli avec les informations récupérés dans card registration
        $CartePaiement= new CartePaiement();
        $CartePaiement->setdata($cardRegistration->PreregistrationData);
        $CartePaiement->setAccessKeyRef($cardRegistration->AccessKey);
        $returnUrl = 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'];
        $returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], ' ') + 1);
        $returnUrl .="paiement/card_Id";
        $CartePaiement->setReturnUrl($returnUrl);
        //on crée le formulaire d'enregistrement de carte
        $form = $this->createForm(CartePaiementType::class, $CartePaiement, array(
            'action' => $cardRegistration->CardRegistrationURL,
        ));

        //sauvegarde en session de l'objet cardRegistration
        $session->set('cardregistration', $cardRegistration);
        // Envoi de la vue
        return $this->render('paiement/CartePaiement.html.twig',array(
            'form'=>$form->createView(),
            'cardregistration' => $cardRegistration,
            'returnUrl'=>$returnUrl
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

        //on récuperer l'information de carte envoyé dans le retour du formulaire
        $dataCard = $request->query->get('data');

        if($cardRegistration == null || $dataCard == null)
        {
            return $this->redirectToRoute("paiement_card");
        }

        $membre = $this->getUser();

        $CarteUpdated = $mangoPayApi->CardUpdate($cardRegistration,$dataCard);

        $reservation = new Reservation();
        $reservation->setCaution(30);
        $reservation->setAssurance(5);

        $PayIn = $mangoPayApi->PayIn($membre,$CarteUpdated,$reservation->getCaution(), $reservation->getAssurance());

        //si le sécure mode est necessaire
       if(!empty($PayIn->ExecutionDetails->SecureModeRedirectURL))
        {
            return $this->redirect($PayIn->ExecutionDetails->SecureModeRedirectURL);
        }

        if($PayIn->Status == "SUCCEEDED")
        {
            $session->getFlashBag()->add('notice', 'Paiement réussi');
            return $this->redirectToRoute('profil_infos');
        }else
        {
            $session->getFlashBag()->add('error', 'Paiement échoué');
            return $this->redirectToRoute('paiement_card');
        }

    }

    /**
     * @Route("/check_transaction", name="check_transaction")
     * @Method({"GET"})
     * @param Request $request
     * @param MangoPayApi $mangoPayApi
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function CheckTransaction(Request $request,MangoPayApi $mangoPayApi)
    {
        $session = new Session();

        $payInStatus = $mangoPayApi->CheckPayIn($request->query->get('transactionId'));


        if($payInStatus == "SUCCEEDED")
        {
            $session->getFlashBag()->add('notice', 'Paiement réussi');
            return $this->redirectToRoute('profil_infos');
        }else
        {
            $session->getFlashBag()->add('error', 'Paiement échoué');
            return $this->redirectToRoute('paiement_card');
        }

    }


    //TODO : check method transfert et payout


}