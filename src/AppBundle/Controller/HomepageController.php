<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeVelo;
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
        $velos = $this->getDoctrine()->getRepository(Velo::class)->findAll();

        //retourne tous les velos electriques qui sont en ligne
        $velosElectriques = $this->getDoctrine()->getRepository(Velo::class)->findBy(
            array('typeVelo' =>'33', 'enLigne' => '1')
        );

        //retourne tous les vélos récemment mis en ligne, ordonnés par dernière date de publication
        $velosPartages = $this->getDoctrine()->getRepository(Velo::class)->findBy(
            array('enLigne' => '1'),
            array('id' => 'desc'),
            6,
            0
        );


        if (isset ($membre)){
            return $this->render('homepage/homepage_connect.html.twig', array(
                'membre' => $membre,
                'velos' => $velos,
                'velosElectriques' => $velosElectriques,
                'velosPartages' => $velosPartages
            ));
        }
        else{
            return $this->render('homepage/homepage.html.twig', array(
                'membre' => $membre,
                'velos' => $velos,
                'velosElectriques' => $velosElectriques,
                'velosPartages' => $velosPartages
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
        $velos = $this->getDoctrine()->getRepository(Velo::class)->find('id');
        $velosElectriques = $this->getDoctrine()->getRepository(Velo::class)->findBy(
            array('typeVelo' =>'33')
        );

        if(!isset ($membre)){
            return $this->render('homepage/homepage.html.twig', array(
                'membre' => $membre,
                'velosElectriques' => $velosElectriques,
                'velos' => $velos
            ));
        }else {
            return $this->render('homepage/homepage_connect.html.twig', array(
                'membre' => $membre,
                'velosElectriques' => $velosElectriques,
                'velos' => $velos
            ));
        }
    }
}
