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
            if (isset ($_POST['ville'])){
                $ville = explode(",", $_POST['ville']);
                $velos=$this->getDoctrine()->getManager()->getRepository(Velo::class)->findBy(array('ville'=>$ville[0],'enLigne'=>true));

                // replace this example code with whatever you need
                return $this->render('recherche/rechercheListe.html.twig', array(
                    'velos' => $velos,
                    'membre'=> $this->getUser(),
                    'ville'=>$_POST['ville']
                ));
            }

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
