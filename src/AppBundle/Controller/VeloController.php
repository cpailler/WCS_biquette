<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 04/06/18
 * Time: 10:29
 */


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Velo controller.
 *
 * @Route("velo")
 */
class VeloController extends Controller
{
    /**
     * @Route("/", name="velo")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/layoutVelo.html.twig');
    }

    /**
     * @Route("/description", name="velo_description")
     *
     */
    public function descriptionAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('velo/description.html.twig');
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
        // replace this example code with whatever you need
        return $this->render('velo/antivol.html.twig');
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
