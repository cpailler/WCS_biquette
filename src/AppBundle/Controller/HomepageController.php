<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Homepage controller.
 *
 * @Route("homepage")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     */
    public function indexAction(request $request)
    {

        $membre = $this->getUser();
        return $this->render('homepage/homepage.html.twig', array(
            'membre' => $membre
        ));
    }

    /**
     * @Route("/connect", name="homepage_connect")
     *
     */
    public function connectAction(request $request)
    {
        $membre= $this->getUser();
        return $this->render('homepage/homepage_connect.html.twig', array(
            'membre' => $membre
        ));
    }
}
