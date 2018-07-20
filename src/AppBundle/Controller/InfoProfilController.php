<?php

namespace AppBundle\Controller;


use AppBundle\Entity\BankAccount;
use AppBundle\Form\preferencesVirementType;
use AppBundle\Entity\Genre;
use AppBundle\Form\InfoProfilType;
use AppBundle\Entity\Membre;
use AppBundle\Service\MangoPayApi;
use AppBundle\Form\NewPasswordType;
use AppBundle\Service\JaugeProfil;
use AppBundle\Service\PointsManager;
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
        $jauge = $jaugeProfil->indicativeJaugeProfil(
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

        if ($jauge == 100 && $membre->getProfilCompleted() == 0) {
            $membre->setProfilCompleted(1);
            $pointsManager = New PointsManager($this->getDoctrine()->getManager());
            $pointsManager->givePoints($membre,250);
        }
        return $jauge;
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
    public function photoProfilAction(Request $request, JaugeProfil $jaugeProfil)
    {
        $membre = $this->getUser();


        $form = $this->createForm('AppBundle\Form\PhotoProfilType', $membre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
        }

        $jaugeProfil = $this->getJaugeProfil($membre, $jaugeProfil);

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/photo_profil.html.twig',
            'form' => $form->createView(),
            'membre' => $membre,
            'jaugeProfil' =>$jaugeProfil
        ));
    }

    /**
     * @Route("/virement", name="virement_infos")
     * @Method({"GET", "POST"})
     *
     */
    public function VirementAction(Request $request,JaugeProfil $jaugeProfil,MangoPayApi $mangoPayApi)
    {
        $em = $this->getDoctrine()->getManager();
        $membre1=$this->getUser();

        $jaugeProfil1 = $this->getJaugeProfil($membre1, $jaugeProfil);
        $bankAccount = new BankAccount();

        $form = $this->createForm('AppBundle\Form\PreferencesVirementType', $bankAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idBankAccount = $mangoPayApi->InitBankAccount($membre1,$bankAccount->getIban(),$bankAccount->getBic(),$bankAccount->getOwnerAccount(),$bankAccount->getAdresse(),$em);

        }



        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/preferencesVirement.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre1,
            'jaugeProfil' =>$jaugeProfil1

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
