<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profil controller.
 *
 * @Route("profil")
 */
class ProfilController extends Controller
{
    /**
     * @Route("/", name="profil")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('profil/layoutProfil.html.twig');
    }
}
