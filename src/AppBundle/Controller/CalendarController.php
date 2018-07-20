<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Velo;


/**
 * Calendar controller.
 *
 * @Route("calendrier")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/", name="calendrier")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/calendrier.html.twig');
    }


    /**
     * @Route("/{id}/calendrier", name="velo_calendrier")
     * @Method({"GET", "POST"})
     */
//    public function calendrierAction(request $request, Reservation $calendrier)
//    {
//        $membre = $this->getUser();
//        $form = $this->createForm('AppBundle\Form\CalendrierType',$calendrier);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//        }
//
//        return $this->render('velo/layoutVelo.html.twig', array(
//            'formulaire'=>'velo/calendrier.html.twig',
//            'calendrier' => $calendrier,
//            'form' => $form->createView(),
//            'membre' =>$membre
//        ));
//    }

}
