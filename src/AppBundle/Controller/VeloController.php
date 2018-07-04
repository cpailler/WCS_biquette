<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 04/06/18
 * Time: 10:29
 */


namespace AppBundle\Controller;

use AppBundle\Entity\Disponibilite;
use AppBundle\Entity\Equipement;
use AppBundle\Entity\Velo;
use AppBundle\Entity\Couleur;
use AppBundle\Entity\PhotoVelo;
use AppBundle\Entity\Membre;
use AppBundle\Form\DisponibiliteType;
use AppBundle\Form\VeloDescriptionType;
use AppBundle\Form\VeloAntivolType;
use AppBundle\Form\VeloPointsType;
use AppBundle\Form\VeloEquipementType;
use AppBundle\Form\LocalisationType;
use AppBundle\Repository\CouleurRepository;
use AppBundle\Service\Calendrier\Calendrier;
use AppBundle\Service\DateCheck;
use AppBundle\Service\JaugeVelo;
use AppBundle\Service\PointsManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    private function redirectToAnnonce(Velo $velo)
    {
        return $this->redirectToRoute('annonce', array('id'=>$velo->getId()));
    }

    private function getJauge(Velo $velo, JaugeVelo $jaugeVelo){

	    $jauge = $jaugeVelo->indicativeJaugeVelo(
            $velo->getTitre(),
            $velo->getDescription(),
            $velo->getMarque(),
            $velo->getModele(),
            $velo->getTypeVelo(),
            $velo->getEtatVelo(),
            $velo->getCouleur(),
            $velo->getPhotos(),
            $velo->getLongitude()
        );

	    if ($jauge == 100 && $velo->getProprio()->getFirstVeloCompleted() == 0) {
		    $velo->getProprio()->setFirstVeloCompleted(1);
		    $pointsManager = New PointsManager($this->getDoctrine()->getManager());
		    $pointsManager->givePoints($velo->getProprio(),250);
	    }

	    return $jauge;

    }

    /**
     * @Route("/", name="velo_nouveau")
     *
     */
    public function nouveauVeloAction(request $request)
    {   $membre = $this->getUser();
        $velo = new Velo();
        $velo->setProprio($membre);
        $velo->setNeuf(0);
        $velo->setAntivolKey(0);
        $velo->setAntivolCode(0);
        $velo->setAssurOblig(0);
        $velo->setCoutPts(0);
        $velo->setDispoTotale(0);
        $velo->setCautionOblig(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($velo);
            $em->flush();

            return $this->redirectToRoute('velo_description', array('id' => $velo->getId()));


    }

    /**
     * @Route("/{id}/description", name="velo_description")
     * @Method({"GET", "POST"})
     *
     */
    public function descriptionAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }


        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\VeloDescriptionType', $velo);
        $form->handleRequest($request);
        $couleurs=$em->getRepository(Couleur::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/description.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'couleurs'=>$couleurs,
            'membre' => $membre,
            'jaugeVelo' =>$jaugeVelo
        ));

    }

    /**
     * @Route("/{id}/photos", name="velo_photos")
     *
     */
    public function photosAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {

        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $photoVelo = new Photovelo();
        $form = $this->createForm('AppBundle\Form\PhotoVeloType', $photoVelo);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && count($velo->getPhotos())<3) {

                $em = $this->getDoctrine()->getManager();
                $photoVelo->setVelo($velo);
                $em->persist($photoVelo);
                $em->flush();

            return $this->redirectToRoute('velo_photos', array('id' => $velo->getId()));
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/photos.html.twig',
            'photoVelo' => $photoVelo,
            'velo'=>$velo,
            'form' => $form->createView(),
            'membre' => $membre,
            'jaugeVelo' =>$jaugeVelo
        ));
    }

    /**
     * @Route("/photo/delete/{id}", name="photoVelo_delete")
     *
     */
    public function deletePhoto(request $request, PhotoVelo $photoVelo)
    {

        $membre = $this->getUser();
        if ($photoVelo->getVelo()->getProprio()!=$membre){
            return $this->redirectToAnnonce($photoVelo->getVelo());
        }
        else{
            $em = $this->getDoctrine()->getManager();
            $em->remove($photoVelo);
            $em->flush();

            return $this->redirectToRoute('velo_photos', array('id'=>$photoVelo->getVelo()->getId()));
        }

    }

    /**
     * @Route("/{id}/equipement", name="velo_equipement")
     * @Method({"GET", "POST"})
     *
     */
    public function equipementAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(VeloEquipementType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        $equipements = $em->getRepository(Equipement::class)->findAll();

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/equipement.html.twig',
            'form'=>$form->createView(),
            'velo'=>$velo,
            'equipements'=>$equipements,
            'membre' =>$membre,
            'jaugeVelo' =>$jaugeVelo
        ));
    }

    /**
     * @Route("/{id}/antivol", name="velo_antivol")
     * @Method({"GET", "POST"})
     *
     */
    public function antivolAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $form = $this->createForm(VeloAntivolType::class,$velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/antivol.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre,
            'jaugeVelo' =>$jaugeVelo
        ));
    }

    /**
     * @Route("/{id}/localisation", name="velo_localisation")
     * @Method({"GET", "POST"})
     *
     */
    public function localisationAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {
        $em = $this->getDoctrine()->getManager();

        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $form = $this->createForm('AppBundle\Form\LocalisationType', $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        $velos=$this->getDoctrine()->getManager()->getRepository(Velo::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire' => 'velo/localisation.html.twig',
            'velo' => $velo,
            'velos' => $velos,
            'form' => $form->createView(),
            'membre' => $membre,
            'jaugeVelo' => $jaugeVelo
        ));
    }

    /**
     * @Route("/{id}/points", name="velo_points")
     *
     */
    public function pointsAction(request $request, Velo $velo, JaugeVelo $jaugeVelo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $form = $this->createForm('AppBundle\Form\VeloPointsType',$velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/points.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre,
            'jaugeVelo' => $jaugeVelo
        ));
    }

    /**
     * @Route("/{id}", name="velo_delete")
     *  @Method("DELETE")
     *
     */
    public function deleteAction(request $request,Velo $velo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }

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
     * @Route("/{id}/calendrier/{initMonth}/{initYear}", name="velo_calendrier", defaults={"initMonth"=null, "initYear"=null})
     * @Method({"GET", "POST"})
     */
    public function calendrierAction(request $request, Velo $velo, int $initMonth=null, int $initYear=null, JaugeVelo $jaugeVelo, DateCheck $dateCheck)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('AppBundle\Form\CalendrierType',$velo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
        }
        $dispo = New Disponibilite();
        $dispoForm = $this->createForm(DisponibiliteType::class, $dispo);
        $dispoForm->handleRequest($request);
        if ($dispoForm->isSubmitted() && $dispoForm->isValid()) {
            if ($dateCheck->noCrossDispos($dispo,$velo)){
                $dispo->setVelo($velo);

                $em->persist($dispo);
                $em->flush();
                return $this->redirectToRoute('velo_calendrier', array('id'=>$velo->getId(),'initMonth'=>$initMonth,
                    'initYear'=>$initYear));
            }
            else{
                $this->addFlash('error','La période saisie est invalide.');
            }

        }
        $disponibilites = $velo->getDisponibilites();
        $dispo_forms=[];
        foreach ($disponibilites as $disponibilite){
            $id = $disponibilite->getId();
            $dispo_forms[$id]= $this->createForm(DisponibiliteType::class, $disponibilite)->createview();
        }


        $calendrier = new Calendrier($initMonth,$initYear);
        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/calendrier.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'membre' =>$membre,
            'calendrier'=>$calendrier,
            'dispoForm'=>$dispoForm->createView(),
            'dispo_forms'=>$dispo_forms,
            'jaugeVelo'=>$jaugeVelo
        ));
    }

    /**
     * @Route("/{velo}/{disponibilite}/update", name="update_dispo")
     * @Method({"GET", "POST"})
     */
    public function updatedispoAction(request $request, Velo $velo,
                                      Disponibilite $disponibilite, DateCheck $dateCheck)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(DisponibiliteType::class,$disponibilite);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($dateCheck->noCrossDispos($disponibilite,$velo)){
                $em->flush();
            }
            else{
                $this->addFlash('error','La période saisie est invalide.');
            }
        }

        return $this->redirectToRoute('velo_calendrier', array('id'=>$velo->getId()));
    }

    /**
     * @Route("/{velo}/{disponibilite}/delete", name="delete_dispo")
     * @Method({"GET", "POST"})
     */
    public function deletedispoAction(request $request, Velo $velo, Disponibilite $disponibilite)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }
        else{
            $em = $this->getDoctrine()->getManager();
            $em->remove($disponibilite);
            $em->flush();
            return $this->redirectToRoute('velo_calendrier', array('id'=>$velo->getId()));
        }



    }



    /**
     * Finds and displays and delete a velo entity.
     *
     * @Route("/{id}/supprimer", name="velo_supprimer")
     * @Method("GET")
     */
    public function supprimerAction(Velo $velo, JaugeVelo $jaugeVelo)
    {
        $membre = $this->getUser();
        if ($velo->getProprio()!=$membre){
            return $this->redirectToAnnonce($velo);
        }

        $jaugeVelo = $this->getJauge($velo, $jaugeVelo);
        $deleteForm = $this->createDeleteForm($velo);

        return $this->render('velo/layoutVelo.html.twig',array(
            'formulaire'=>'velo/delete.html.twig',
            'velo' => $velo,
            'delete_form' => $deleteForm->createView(),
            'membre' => $membre,
            'jaugeVelo' => $jaugeVelo
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