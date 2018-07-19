<?php

namespace AppBundle\Controller;

use AppBundle\Service\Calendrier\Calendrier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Velo;
use AppBundle\Service\JaugeProfil;
use AppBundle\Entity\Membre;

/**
 * Profil controller.
 *
 * @Route("/recherche-liste/annonce")
 * @Method({"GET", "POST"})
 */
class AnnonceController extends Controller
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
     * Annonce vélo.
     *
     * @Route("/{id}/{initMonth}/{initYear}", name="annonce", defaults={"initMonth"=null, "initYear"=null}))
     * @Method({"GET"})
     */
    public function indexAction(Velo $velo, int $initMonth=null, int $initYear=null, JaugeProfil $jaugeProfil)
    {
        if (!$velo->getEnLigne()){
            return $this->redirectToRoute('recherche-liste');
        }
        $membre = $this->getUser();
        $calendrier = new Calendrier($initMonth,$initYear);

        $jaugeProfil = $this->getJaugeProfil($membre, $jaugeProfil);


        return $this->render('/recherche/annonce.html.twig', array(
            'velo' => $velo,
            'membre' => $membre,
            'calendrier' => $calendrier,
            'jaugeProfil' => $jaugeProfil
        ));


    }

}
