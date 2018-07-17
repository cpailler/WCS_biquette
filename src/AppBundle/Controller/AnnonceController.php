<?php

namespace AppBundle\Controller;

use AppBundle\Service\Calendrier\Calendrier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Velo;

/**
 * Profil controller.
 *
 * @Route("/recherche-liste/annonce")
 * @Method({"GET", "POST"})
 */
class AnnonceController extends Controller
{
    /**
     * Annonce vélo.
     *
     * @Route("/{id}/{initMonth}/{initYear}", name="annonce", defaults={"initMonth"=null, "initYear"=null}))
     * @Method({"GET"})
     */
    public function indexAction(Velo $velo, int $initMonth=null, int $initYear=null)
    {
        $membre = $this->getUser();
        $calendrier = new Calendrier($initMonth,$initYear);


        return $this->render('/recherche/annonce.html.twig', array(
            'velo' => $velo,
            'membre' => $membre,
            'calendrier' => $calendrier
        ));


    }

}
