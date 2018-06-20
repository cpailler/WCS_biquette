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
 * @Route("/velo")
 */
class VeloController extends Controller
{
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
        //le vélo a les données récupéré en base de données
        //automatiquement par doctrine et le conteneur de services
        //par rapport aux données {id} rentrées dans l'URL

        //on crée un formulaire avec createForm
        //qui sera rempli en fonction des valeurs du vélo
        // !!! maintenant, le formulaire et l'entité velo sont liés !!!
        $form = $this->createForm('AppBundle\Form\VeloDescriptionType', $velo);
        //on regarde avec handlerequest dans la requete
        //si il y a des données POST (donc, de formulaire submité)
        //qui pourrait nous permettre de modifier l'objet velo
        $form->handleRequest($request);
        //on récupère toutes les couleurs de la base avec un findAll()
        $couleurs=$this->getDoctrine()->getManager()->getRepository(Couleur::class)->findAll();
        //on verifie qu'on a reçu un formulaire en POST
        //on verifie que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        //TODO replace view with correct viewpath
        return $this->render('velo/description.html.twig', array(
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
        $photoVelo = new Photovelo();
        $form = $this->createForm('AppBundle\Form\PhotoVeloType', $photoVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photoVelo);
            $em->flush();

            return $this->redirectToRoute('photovelo_show', array('id' => $photoVelo->getId()));
        }

        return $this->render('photovelo/new.html.twig', array(
            'photoVelo' => $photoVelo,
            'form' => $form->createView(),
        ));
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
