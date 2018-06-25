<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 04/06/18
 * Time: 10:29
 */


namespace AppBundle\Controller;

use AppBundle\Entity\Equipement;
use AppBundle\Entity\Velo;
use AppBundle\Entity\Couleur;
use AppBundle\Entity\PhotoVelo;
use AppBundle\Entity\Membre;
use AppBundle\Form\VeloDescriptionType;
use AppBundle\Form\VeloAntivolType;
use AppBundle\Form\VeloPointsType;
use AppBundle\Form\VeloEquipementType;
use AppBundle\Form\LocalisationType;
use AppBundle\Repository\CouleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\CalendrierType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Velo controller.
 *
 * @Route("/velo")
 */
class VeloController extends Controller
{
    private function securityCheck(Velo $velo)
    {
        if (!($velo->getProprio()==$this->getUser()))
        {
            return $this->redirectToRoute('annonce',['id'=>$velo->getId()]);
        }
        return true;
    }

    /**
     * @Route("/", name="velo_index")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/layoutVelo.html.twig');
    }

    /**
     * @Route("/{id}/description", name="velo_description")
     * @Method({"GET", "POST"})
     *
     */
    public function descriptionAction(request $request, Velo $velo)
    {
        $this->securityCheck($velo);

        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\VeloDescriptionType', $velo);
        $form->handleRequest($request);
        $couleurs=$em->getRepository(Couleur::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }


        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/description.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'couleurs'=>$couleurs,
            'membre' => $membre
        ));

    }

    /**
     * @Route("/{id}/photos", name="velo_photos")
     *
     */
    public function photosAction(request $request, Velo $velo)
    {
        $photoVelo = new Photovelo();
        $membre = $this->getUser();
        $form = $this->createForm('AppBundle\Form\PhotoVeloType', $photoVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photoVelo->setVelo($velo->getId());
            $em->persist($photoVelo);
            $em->flush();

            return $this->redirectToRoute('photovelo_show', array('id' => $photoVelo->getId()));
        }

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'photovelo/new.html.twig',
            'photoVelo' => $photoVelo,
            'velo'=>$velo,
            'form' => $form->createView(),
            'membre' => $membre
        ));
    }

    /**
     * @Route("/{id}/equipement", name="velo_equipement")
     * @Method({"GET", "POST"})
     *
     */
    public function equipementAction(request $request, Velo $velo)
    {
        $this->securityCheck($velo);
        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(VeloEquipementType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

        }


        $equipements = $em->getRepository(Equipement::class)->findAll();

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/equipement.html.twig',
            'form'=>$form->createView(),
            'velo'=>$velo,
            'equipements'=>$equipements,
            'membre' =>$membre
        ));
    }

    /**
     * @Route("/{id}/antivol", name="velo_antivol")
     * @Method({"GET", "POST"})
     *
     */
    public function antivolAction(request $request, Velo $velo)
    {
        $this->securityCheck($velo);

        $membre = $this->getUser();
        $form = $this->createForm(VeloAntivolType::class,$velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/antivol.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre
        ));
    }

    /**
     * @Route("/{id}/localisation", name="velo_localisation")
     * @Method({"GET", "POST"})
     *
     */
    public function localisationAction(request $request, Velo $velo)
    {
        $this->securityCheck($velo);
        $form = $this->createForm('AppBundle\Form\LocalisationType',$velo);
        $membre = $this->getUser();
        $form = $this->createForm('AppBundle\Form\LocalisationType', $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
        }

        // replace this example code with whatever you need
        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire' => 'velo/localisation.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' => $membre
        ));
    }

    /**
     * @Route("/{id}/points", name="velo_points")
     *
     */
    public function pointsAction(request $request, Velo $velo)
    {
        $this->securityCheck($velo);
        $membre = $this->getUser();
        $form = $this->createForm('AppBundle\Form\VeloPointsType',$velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/points.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre
        ));
    }




    /**
     * @Route("/{id}", name="velo_delete")
     *  @Method("DELETE")
     *
     */
    public function deleteAction(request $request,Velo $velo)
    {
        $this->securityCheck($velo);

        $form = $this->createDeleteForm($velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($velo);
            $em->flush();
        }
        return $this->redirectToRoute('profil_infos');

    }

    /**
     * @Route("/{id}/calendrier", name="velo_calendrier")
     * @Method({"GET", "POST"})
     */
    public function calendrierAction(request $request, Velo $velo)
    {
        $membre = $this->getUser();
        $form = $this->createForm('AppBundle\Form\CalendrierType',$velo);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('velo/layoutVelo.html.twig', array(

            'formulaire'=>'velo/calendrier.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre
        ));
    }



    /**
     * Finds and displays and delete a velo entity.
     *
     * @Route("/{id}/supprimer", name="velo_supprimer")
     * @Method("GET")
     */
    public function supprimerAction(Velo $velo)
    {
        $deleteForm = $this->createDeleteForm($velo);

        return $this->render('velo/layoutVelo.html.twig',array(
            'formulaire'=>'velo/delete.html.twig',
            'velo' => $velo,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Creates a form to delete a velo entity.
     *
     * @param Velo $velo The velo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Velo $velo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('velo_delete', array('id' => $velo->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}