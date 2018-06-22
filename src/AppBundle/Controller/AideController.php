<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aide controller.
 *
 * @Route("/aide")
 */
class AideController extends Controller
{
    /**
 * @Route("/comment-ca-marche", name="aide_comment")
 *
 */
    public function commentCaMarche (request $request)
    {
        $membre = $this->getUser();
        return $this->render('aide/comment.html.twig', array(
            'membre' => $membre
        ));
    }

    /**
     * @Route("/bikerr-gratuit", name="aide_gratuit")
     *
     */
    public function vraimentGratuit (request $request)
    {
        $membre = $this->getUser();
        return $this->render('aide/gratuit.html.twig', array(
            'membre' => $membre
        ));
    }

    /**
     * @Route("/bikerr-points", name="aide_points")
     *
     */
    public function aidePoints (request $request)
    {
        $membre = $this->getUser();
        return $this->render('aide/points.html.twig', array(
            'membre' => $membre
        ));
    }

    /**
     * @Route("/bikerr-depot-garantie", name="aide_depot_garantie")
     *
     */
    public function depotGarantie (request $request)
    {
        $membre = $this->getUser();
        return $this->render('aide/depotGarantie.html.twig', array(
            'membre' => $membre
        ));
    }
}
