<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Velo;

/**
 * Profil controller.
 *
 * @Route("/annonce")
 * @Method({"GET", "POST"})
 */
class AnnonceController extends Controller
{
    /**
     * Annonce vélo.
     *
     * @Route("/{id}", name="annonce")
     * @Method({"GET"})
     */
    public function indexAction(request $request, Velo $velo)
    {
        $membre = $this->getUser();
        return $this->render('/recherche/annonce.html.twig', array(
            'velo' => $velo,
            'membre' => $membre,
        ));
    }
}
