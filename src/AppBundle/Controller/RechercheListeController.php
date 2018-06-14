<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profil controller.
 *
 * @Route("recherche-liste")
 * @Method("GET")
 */
class RechercheListeController extends Controller
{
    /**
     * Lists velos.
     *
     * @Route("/", name="recherche-liste")
     * @Method({"GET"})
     */
    public function indexAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $membre = $em->getRepository('AppBundle:Membre')->findAll();
        $photoVelo = $em->getRepository('AppBundle:PhotoVelo')->findAll();
        $velo = $em->getRepository('AppBundle:Velo')->findAll();
        $typeVelo = $em->getRepository('AppBundle:TypeVelo')->findAll();

        // replace this example code with whatever you need
        return $this->render('recherche/rechercheListe.html.twig', array(
            'membre' => $membre,
            'photoVelo' => $photoVelo,
            'velo' => $velo,
            'typeVelo' => $typeVelo,
        ));
    }
}