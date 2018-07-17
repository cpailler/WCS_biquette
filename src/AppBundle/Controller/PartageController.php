<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Velo;
use AppBundle\Form\ReservationType;
use AppBundle\Service\Calendrier\Calendrier;
use AppBundle\Service\DateCheck;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partage controller.
 *
 * @Route("/partage")
 * @Method({"GET", "POST"})
 */
class PartageController extends Controller
{
    /**
     * @Route("/{id}", name="partage")
     *
     */

    public function partageAction(Reservation $reservation) {

        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio()){

            return $this->render('partage/partage_proprietaire.html.twig', array(

                'reservation' => $reservation,
                'membre' => $membre));

        }elseif ($membre == $reservation->getLocataire()){

            return $this->render('partage/partage_locataire.html.twig', array(

                'reservation' => $reservation,
                'membre' => $membre));
        }else{

            return $this->redirectToRoute('recherche-liste');

        }

    }

    /**
     *
     * @Route("/attentevalidation/{id}", name="partage_attente_validation")
     */
    public function attenteValidationAction(Reservation $reservation) {
        $membre = $this->getUser();

        if($membre == $reservation->getLocataire() && $reservation->getEtape() == 0) {

            return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
        }

    }

    /**
     *
     * @Route("/validationproprio/{id}", name="partage_validation_proprio")
     */
    public function validationAction(Reservation $reservation) {
        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 0) {

            $reservation->setEtape(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
    }



    /**
     *
     * @Route("/paiement/{id}", name="partage_paiement")
     */
    public function paiementAction(Reservation $reservation) {

        $membre = $this->getUser();

        if($membre == $reservation->getLocataire() && $reservation->getEtape() == 1) {

            $reservation->setEtape(2);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();



            /*  Mails
             *  Le récapitulatif de paiement à envoyer au locataire
             *  La notification du payment effectué à envoyer au proprio
             *
             *  Actions
             *  Page locataire avec le bouton "payer" et rédirection sur la page de paiement Mangopay
             *  Après la validaion du paiement passage à l'étape 2

            */


            return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
        }


    }


    /**
     *
     * @Route("/retour_locataire/{id}", name="partage_retour_locataire")
     */
    public function retourLocataireAction(Reservation $reservation) {

        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 2) {

            $reservation->setEtape(3);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            /*  Mails
             *
             *  Mail de rappel de valider la retour de vélo à envoyer au proprio
             *
             *  Actions
             *  Page locataire avec le bouton "Je confirme le retour"
            */


            return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
        }


    }

    /**
     *
     * @Route("/retour_locataire/{id}", name="partage_retour_proprio")
     */
    public function retourProprioAction(Reservation $reservation) {

        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 3) {

            $reservation->setEtape(4);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            /*  Mails
             *
             *  Mail de rappel de valider la retour de vélo à envoyer au proprio
             *
             *  Actions
             *  Page proprio avec les bouton "Tout s’est bien passé, je clos le partage" et "Il y un problème, j’ouvre un cas de litige"
            */


            return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
        }


    }

    /**
     *
     * @Route("/retour_locataire/{id}", name="partage_retour_proprio")
     */
    public function archivageAction(Reservation $reservation) {

        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 3) {

            $reservation->setEtape(4);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            /*  Mails
             *
             *  Mail de rappel de valider la retour de vélo à envoyer au proprio
             *
             *  Actions
             *  Page proprio avec les bouton "Tout s’est bien passé, je clos le partage" et "Il y un problème, j’ouvre un cas de litige"
            */


            return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
        }


    }




    /**
     *
     * @Route("/suppressionpartage/{id}", name="partage_suppression")
     */
    public function suppressionAction(Reservation $reservation) {
        $membre = $this->getUser();

        if(($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 0) ||
        ($membre == $reservation->getLocataire() && $reservation->getEtape() == 1)) {


            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();

        }

        return $this->redirectToRoute('recherche-liste');
    }


}
