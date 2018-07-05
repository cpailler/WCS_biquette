<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Genre;
use AppBundle\Form\InfoProfilType;
use AppBundle\Entity\Membre;
use AppBundle\Form\NewPasswordType;
use AppBundle\Service\JaugeProfil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Velo;

/**
 * InfoProfil controller.
 *
 * @Route("profil")
 */
class InfoProfilController extends Controller
{
    private function getJaugeProfil(Membre $membre, JaugeProfil $jaugeProfil)
    {
        return $jaugeProfil->indicativeJaugeProfil(
            $membre->getGenre(),
            $membre->getNom(),
            $membre->getPrenom(),
            $membre->getCodePostal(),
            $membre->getVille(),
            $membre->getEmail(),
            $membre->getPays(),
            $membre->getTel(),
            $membre->getDateNaissance(),
            $membre->getImage()
        );
    }

    /**
     * @Route("/infos", name="profil_infos")
     * @Method({"GET", "POST"})
     *
     */
    public function InfosAction(Request $request, JaugeProfil $jaugeProfil)
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
        $jaugeProfil = $this->getJaugeProfil($membre, $jaugeProfil);

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/infoProfil.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre,
            'genres' => $genres,
            'jaugeProfil' => $jaugeProfil
        ));
    }

    /**
     * @Route("/photo", name="photo-profil")
     *
     */
    public function photoProfilAction(request $request, JaugeProfil $jaugeProfil)
    {

        $membre = $this->getUser();
        /*if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }*/
        //$photoVelo = new Photovelo();
        $form = $this->createForm('AppBundle\Form\PhotoProfilType', $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $em = $this->getDoctrine()->getManager();
            //$photoVelo->setVelo($velo);
            $membre->setImage($membre);
            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('photo-profil', array());
        }

        $jaugeProfil = $this->getJaugeProfil($membre, $jaugeProfil);

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/photo_profil.html.twig',
            //'photoProfil' => $photoVelo,
            //'velo'=>$velo,
            'form' => $form->createView(),
            'membre' => $membre,
            'jaugeProfil' =>$jaugeProfil
        ));
    }

    /**
     * @Route("/photo_profil_update", name = "photo_profil_update")
     *
     */
    public function updatePhotoProfil(request $request, JaugeProfil $jaugeProfil){
        $membre= $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\PhotoProfilType', $membre);
        $form->handleRequest($request);

        $image = $membre->getImage();
        if ($form->isSubmitted() && $form->isValid() ) {

            $em = $this->getDoctrine()->getManager();
            //$photoVelo->setVelo($velo);
            $membre->setImage($membre);
            $em->persist($membre);
            $em->flush();

            return $this->redirectToRoute('photo-profil', array());
        }

        $jaugeProfil = $this->getJaugeProfil($membre, $jaugeProfil);

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/photo_profil_update.html.twig',
            //'photoProfil' => $photoVelo,
            //'velo'=>$velo,
            'form' => $form->createView(),
            'membre' => $membre,
            'jaugeProfil' =>$jaugeProfil
        ));
    }


    /**
     *  @Route("/", name="profil_delete")
     *  @Method("DELETE")
     *
     */
    public function deleteAction(request $request)
    {
        $membre = $this->getUser();

        $form = $this->createDeleteForm($membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($membre);
            $em->flush();
        }
        return $this->redirectToRoute('homepage_non_connect');

    }

    /**
     * Finds and displays and delete a membre entity.
     *
     * @Route("/supprimer", name="profil_supprimer")
     * @Method("GET")
     */
    public function supprimerAction()
    {
        $membre = $this->getUser();

        $deleteForm = $this->createDeleteForm($membre);

        return $this->render('profil/layoutProfil.html.twig',array(
            'formulaire'=>'profil/delete.html.twig',
            'delete_form' => $deleteForm->createView(),
            'membre' =>$membre
        ));
    }

    /**
     * Creates a form to delete a profil entity.
     *
     * @param Membre $membre The membre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Membre $membre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profil_delete', array('id' => $membre->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
