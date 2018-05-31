<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Homepage controller.
 *
 * @Route("homepage")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('homepage/homepage.html.twig');
    }
}
