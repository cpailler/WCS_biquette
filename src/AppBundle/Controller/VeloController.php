<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 04/06/18
 * Time: 10:29
 */


namespace AppBundle\Controller;

use AppBundle\Entity\Velo;
use AppBundle\Entity\Couleur;
use AppBundle\Form\VeloDescriptionType;
use AppBundle\Repository\CouleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Velo controller.
 *
 * @Route("velo")
 */
class VeloController extends Controller
{
    /**
     * @Route("/", name="velo_index")
     *
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

        $form = $this->createForm('AppBundle\Form\VeloDescriptionType', $velo);
        $form->handleRequest($request);
        $couleurs=$this->getDoctrine()->getManager()->getRepository(Couleur::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('velo/layoutVelo.html.twig', array(
            'formulaire'=>'velo/description.html.twig',
            'velo' => $velo,
            'form' => $form->createView(),
            'couleurs'=>$couleurs
        ));

    }

    /**
     * @Route("/photos", name="velo_photos")
     *
     */
    public function photosAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/photos.html.twig');
    }

    /**
     * @Route("/equipement", name="velo_equipement")
     *
     */
    public function equipementAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/equipement.html.twig');
    }

    /**
     * @Route("/antivol", name="velo_antivol")
     *
     */
    public function antivolAction(request $request)
    {
        $velo = new Velo();
        $velo->getAntivolKey();
        $velo->getAntivolCode();
        $velo->getBicycode();

        $form = $this->createFormBuilder($velo)
            ->add('antivolKey', ChoiceType::class, array(
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                )
            ))
            ->add('antivolCode', ChoiceType::class, array(
                'choices' => array(
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                )
            ))
            ->add('bicycode', RadioType::class)
            ->add('bicycode', TextType::class)
            ->add('enregistrer', SubmitType::class, array('label' => 'Enregistrer'))
            ->getForm();


        return $this->render('velo/antivol.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/localisation", name="velo_localisation")
     *
     */
    public function localisationAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/localisation.html.twig');
    }

    /**
     * @Route("/calendrier", name="velo_calendrier")
     *
     */
    public function calendrierAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/calendrier.html.twig');
    }

    /**
     * @Route("/points", name="velo_points")
     *
     */
    public function pointsAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/points.html.twig');
    }

    /**
     * @Route("/supprimer", name="velo_supprimer")
     *
     */
    public function deleteAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/delete.html.twig');
    }
}
