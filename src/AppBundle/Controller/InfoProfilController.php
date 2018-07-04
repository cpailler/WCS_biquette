<?php

namespace AppBundle\Controller;


use AppBundle\Entity\BankAccount;
use AppBundle\Form\preferencesVirementType;
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
     * @Route("/virement", name="virement_infos")
     * @Method({"GET", "POST"})
     *
     */
    public function VirementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $membre=$this->getUser();

        $bankAccount = new BankAccount();

        $form = $this->createForm('AppBundle\Form\PreferencesVirementType', $bankAccount);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em->persist($bankAccount);
            //$em->flush();
            $form->getData();

        }

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/preferencesVirement.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre

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
