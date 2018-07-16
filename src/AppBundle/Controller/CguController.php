<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Aide controller.
 *
 * @Route("/cgu")
 */
class CguController extends Controller {

    /**
     * @Route("/conditions-generales", name="conditions_generales")
     *
     */
    public function conditionsGenerales() {
        $membre = $this->getUser();
        return $this->render('cgu/generales.html.twig', array('membre' => $membre));
    }

    /**
     * @Route("/utilisation-service", name="utilisation_service")
     *
     */
    public function utilisationService() {
        $membre = $this->getUser();
        return $this->render('cgu/utilisation.html.twig', array('membre' => $membre));
    }
}