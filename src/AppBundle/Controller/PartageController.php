<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Velo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Partage controller.
 *
 * @Route("/partage")
 * @Method({"GET", "POST"})
 */
class PartageController extends Controller
{
    /**
     * @Route("/", name="partage")
     *
     */
    public function utilisateurReservationAction(Reservation $reservation, Velo $velo)
    {
        $membre = $this->getUser();

        return $this->render('partage/utilisateur_reservation.html.twig', array(
            'velo' => $velo,
            'reservation' => $reservation,
            'membre' => $membre));
    }

    public function proprietaireValidationAction(Reservation $reservation, Velo $velo) {
        $membre = $this->getUser();

        return $this->render('partage/proprietaire_validation.html.twig', array(
            'velo' => $velo,
            'reservation' => $reservation,
            'membre' => $membre));
    }

    public function utilisateurRetourAction(Reservation $reservation, Velo $velo) {
        $membre = $this->getUser();

        return $this->render('partage/utilisateur_retour.html.twig', array(
            'velo' => $velo,
            'reservation' => $reservation,
            'membre' => $membre));
    }
}
