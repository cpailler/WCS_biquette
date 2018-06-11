<?php

namespace AppBundle\Controller;

use AppBundle\Form\InfoProfilType;
use AppBundle\Entity\Membre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * InfoProfil controller.
 *
 * @Route("informations-confidentielles")
 */
class InfoProfilController extends Controller
{
    /**
     * @Route("/", name="infos")
     *
     */
    public function newAction(Request $request)
    {
        $membre = new Membre(); // On instancie un objet $review de type Review.
        $form = $this->createForm('AppBundle\Form\InfoProfilType', $membre);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($membre);
                $em->flush();
                return $this->redirectToRoute('profil/infoProfil.html.twig', array('id' => $membre->getId()));
            }

        // replace this example code with whatever you need
        return $this->render('profil/infoProfil.html.twig',array(
            'form'=>$form->createView()
        ));
    }
}
