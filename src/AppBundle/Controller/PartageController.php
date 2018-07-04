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
     * @Route("/{id}/reservation", name="partage_reservation")
     *
     */
    public function utilisateurReservationAction(Request $request, Velo $velo, DateCheck $dateCheck, Calendrier $calendrier)
    {
        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reservation = New Reservation();
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);
        if ($reservationForm->isSubmitted() && $reservationForm->isValid()) {
            if ($dateCheck->isLegalReservation($reservation, $velo, $calendrier)){
                $nbDay = intval($reservation->getDebut()->diff($reservation->getFin(),true)->format('%d'))+1;
                $reservation->setVelo($velo);
                $reservation->setLocataire($membre);
                $reservation->setCoutPts($velo->getCoutPts()*$nbDay);
                $reservation->setCaution($velo->getCaution());
                if($velo->getAssurOblig()==1){
                $reservation->setAssurance(1*$nbDay);
                }
                else {
                    $reservation->setAssurance(0);
                }



                $em->persist($reservation);
                $em->flush();
            }
            else {
                $this->addFlash('error', 'La réservation n\'est pas valide, merci de vérifier la disponibilité du vélo.');
            }
        }


        return $this->render('partage/utilisateur_reservation.html.twig',array(

            'membre' => $membre,
            'reservationForm' => $reservationForm->createView(),
            'velo' => $velo));
    }

    /**
     * @Route("/validation", name="partage_validation")
     *
     */

    public function proprietaireValidationAction(Velo $velo) {
        $membre = $this->getUser();

        return $this->render('partage/proprietaire_validation.html.twig', array(
            'velo' => $velo,
           // 'reservation' => $reservation,
            'membre' => $membre));
    }

    public function utilisateurRetourAction(Velo $velo) {
        $membre = $this->getUser();

        return $this->render('partage/utilisateur_retour.html.twig', array(
            'velo' => $velo,
           // 'reservation' => $reservation,
            'membre' => $membre));
    }

    public function proprietaireClotureAction(Velo $velo) {
        $membre = $this->getUser();

        return $this->render('partage/proprietaire_cloture.html.twig', array(
            'velo' => $velo,
            //'reservation' => $reservation,
            'membre' => $membre));
    }
}
