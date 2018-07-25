<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Velo;
use AppBundle\Form\ReservationType;
use AppBundle\Service\Calendrier\Calendrier;
use AppBundle\Service\DateCheck;
use AppBundle\Service\PointsManager;
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
    public function validationAction(Reservation $reservation, \Swift_Mailer $mailer) {
        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 0) {

            $reservation->setEtape(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();


            $locataire = $reservation->getLocataire();
            $emailLocataire = $locataire->getEmail();

            $message = (new \Swift_Message('Réservation acceptée'))
                ->setFrom('infos@bikerr.fr')
                ->setTo($emailLocataire)
                ->setBody(
                    $this->renderView(
                        'email/demandeValidation.email.twig',
                        array('reservation' => $reservation)
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);

        }

        return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));
    }



    /**
     *
     * @Route("/paiement/{id}", name="partage_paiement")
     */
    public function paiementAction(Reservation $reservation, \Swift_Mailer $mailer, PointsManager $pointsManager)
    {

        $membre = $this->getUser();
        if ($membre->getPoints()>=$reservation->getCoutPts()){
            if ($membre == $reservation->getLocataire() && ($reservation->getPointsTransferred() == 0) &&
                ($reservation->getEtape() == 2 ||
                    ($reservation->getEtape()
                        == 1
                        && $reservation->getCaution() == 0 &&
                        $reservation->getAssurance() == 0))
            ) {

                $reservation->setEtape(2);
                $pointsManager->transferPoints(
                    $reservation->getLocataire(),
                    $reservation->getVelo()->getProprio(),
                    $reservation->getCoutPts());
                $reservation->setPointsTransferred(1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();


                $locataire = $reservation->getLocataire();
                $emailLocataire = $locataire->getEmail();

                $message = (new \Swift_Message('Récapitulatif réservation'))
                    ->setFrom('infos@bikerr.fr')
                    ->setTo($emailLocataire)
                    ->setBody(
                        $this->renderView(
                            'email/recapitulatifLocataire.email.twig',
                            array('reservation' => $reservation)
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                $emailProprio = $reservation->getVelo()->getProprio()->getEmail();

                $message = (new \Swift_Message('Transfert de points effectué'))
                    ->setFrom('infos@bikerr.fr')
                    ->setTo($emailProprio)
                    ->setBody(
                        $this->renderView(
                            'email/paiementPointsProprio.email.twig',
                            array('reservation' => $reservation)
                        ),
                        'text/html'
                    );

                $mailer->send($message);

            }

        } else {
            $this->addFlash('danger', 'Vous ne disposez pas de suffisament de points pour procéder à la transaction');

        }
        return $this->redirectToRoute('partage', array('id' => $reservation->getId()));
    }
    /**
     *
     * @Route("/retour_locataire/{id}", name="partage_retour_locataire")
     */
    public function retourLocataireAction(Reservation $reservation, \Swift_Mailer $mailer) {

        $membre = $this->getUser();

        if($membre == $reservation->getLocataire() && $reservation->getEtape() == 2) {

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

            $emailProprio = $reservation->getVelo()->getProprio()->getEmail();

            $message = (new \Swift_Message('Retour du vélo'))
                ->setFrom('infos@bikerr.fr')
                ->setTo($emailProprio)
                ->setBody(
                    $this->renderView(
                        'email/utilisateurRetour.email.twig',
                        array('reservation' => $reservation)
                    ),
                    'text/html'
                );

            $mailer->send($message);



        }
        return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));

    }

    /**
     *
     * @Route("/retour_proprio/{id}", name="partage_retour_proprio")
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
             *  TODO Mail de rappel de valider la retour de vélo à envoyer au proprio
             *
             *  Actions
             *  Page proprio avec les bouton "Tout s’est bien passé, je clos le partage" et "Il y un problème, j’ouvre un cas de litige"
            */


        }
        return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));


    }






    /**
     *
     * @Route("/suppressionpartage/{id}", name="partage_suppression")
     */
    public function suppressionAction(Reservation $reservation, \Swift_Mailer $mailer) {
        $membre = $this->getUser();

        if($membre == $reservation->getVelo()->getProprio() && $reservation->getEtape() == 0) {

            $emailProprio = $reservation->getVelo()->getProprio()->getEmail();

            $message = (new \Swift_Message('Annulation de la réservation'))
                ->setFrom('infos@bikerr.fr')
                ->setTo($emailProprio)
                ->setBody(
                    $this->renderView(
                        'email/annulationLocataire.email.twig',
                        array('reservation' => $reservation)
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }
        elseif ($membre == $reservation->getLocataire() && $reservation->getEtape() == 1) {

            $locataire = $reservation->getLocataire();
            $emailLocataire = $locataire->getEmail();

            $message = (new \Swift_Message('Annulation de la réservation'))
                ->setFrom('infos@bikerr.fr')
                ->setTo($emailLocataire)
                ->setBody(
                    $this->renderView(
                        'email/annulationProprio.email.twig',
                        array('reservation' => $reservation)
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();

        }

        return $this->redirectToRoute('recherche-liste');
    }


}
