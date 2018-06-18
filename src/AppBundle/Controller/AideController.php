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
        return $this->render('aide/comment.html.twig');
    }

    /**
     * @Route("/bikerr-gratuit", name="aide_gratuit")
     *
     */
    public function vraimentGratuit (request $request)
    {
        return $this->render('aide/gratuit.html.twig');
    }

    /**
     * @Route("/bikerr-points", name="aide_points")
     *
     */
    public function aidePoints (request $request)
    {
        return $this->render('aide/points.html.twig');
    }
}
