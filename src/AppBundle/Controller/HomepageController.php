<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Velo;

/**
 * Homepage controller.
 *
 * @Route("/")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage_non_connect")
     *
     */
    public function indexAction(request $request)
    {

        $membre = $this->getUser();

        if (isset ($membre)){
            return $this->render('homepage/homepage_connect.html.twig', array(
                'membre' => $membre
            ));
        }
        else{
            return $this->render('homepage/homepage.html.twig', array(
                'membre' => $membre
            ));
        }
    }

    /**
     * @Route("/connect", name="homepage_connect")
     *
     */
    public function connectAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $membre= $this->getUser();

        if(!isset ($membre)){
            return $this->render('homepage/homepage.html.twig', array(
                'membre' => $membre
            ));
        }else {
            return $this->render('homepage/homepage_connect.html.twig', array(
                'membre' => $membre
            ));
        }
    }
}
