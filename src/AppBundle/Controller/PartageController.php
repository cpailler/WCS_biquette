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

    public function proprietaireValidationAction(Reservation $reservation) {
        $membre = $this->getUser();




        return $this->render('partage/partage.html.twig', array(

            'reservation' => $reservation,
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
