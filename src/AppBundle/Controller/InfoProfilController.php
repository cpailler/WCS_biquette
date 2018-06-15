<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genre;
use AppBundle\Form\InfoProfilType;
use AppBundle\Entity\Membre;
use AppBundle\Form\NewPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * InfoProfil controller.
 *
 * @Route("profil")
 */
class InfoProfilController extends Controller
{
    /**
     * @Route("/infos", name="profil_infos")
     * @Method({"GET", "POST"})
     *
     */
    public function InfosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $membre=$this->getUser();

        $form = $this->createForm('AppBundle\Form\InfoProfilType', $membre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($membre);
            $em->flush();

        }

        $genres = $em->getRepository(Genre::class)->findAll();

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/infoProfil.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre,
            'genres' => $genres
        ));
    }

    /**
     * @Route("/password", name="profil_password")
     * @Method({"GET", "POST"})
     *
     */

    public function PasswordAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $membre=$this->getUser();

        $form = $this->createForm(NewPasswordType::class, $membre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($membre);
            $em->flush();

        }

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/passwordProfil.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre
        ));
    }
}
