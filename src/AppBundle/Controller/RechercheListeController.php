<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Velo;
use Symfony\Component\HttpFoundation\Response;

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
     * @Method({"GET", "POST"})
     */
    public function indexAction(request $request)
    {
        dump($_POST);
        $em = $this->getDoctrine()->getManager();
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


        $velos=$this->getDoctrine()->getManager()->getRepository(Velo::class)->findBy(array('enLigne'=>true));

        // replace this example code with whatever you need
        return $this->render('recherche/rechercheListe.html.twig', array(
            'velos' => $velos,
            'membre'=> $this->getUser()

        ));
    }

    /**
     * Recherche vélos sur Paris
     *
     * @Route("/recherche_paris", name="recherche-Paris")
     * @Method({"GET", "POST"})
     */
    public function rechercheParis(request $request){

        $velos=$this->getDoctrine()->getManager()->getRepository(Velo::class)->findBy(array('ville'=>['Paris'],'enLigne'=>true));

        return $this->render('recherche/rechercheListe.html.twig', array(
            'velos' => $velos,
            'membre'=> $this->getUser()
        ));
    }

    /**
     * Search velos.
     *
     * @Route("/getVille/{nom}", name="ville_search")
     * @Method({"GET"})
     */
    /*public function searchAction($nom, SerializerInterface $serializer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository(Velo::class)->findByExampleField($nom);
        //$resultJson = array();
        //foreach ($result as $value)
        //{
        //    $veloSimple['ville'] = $value->getVille();
        //    $resultJson[]=$veloSimple;
        //}

        $data = $serializer->serialize($result, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }*/
}

