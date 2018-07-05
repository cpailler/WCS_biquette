<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PreferencesVirementType;
use AppBundle\Entity\BankAccount;


/**
 * Profil controller.
 *
 * @Route("/profil")
 */
class ProfilController extends Controller
{
    /**
     * @Route("/", name="profil")
     *
     */
    public function indexAction(request $request)
    {
        // replace this example code with whatever you need
        return $this->render('profil/layoutProfil.html.twig');
    }

    /**
     * @Route("/preferencesvirement", name="preferencesvirement")
     *
     */
    public function preferencesVirement(request $request)
    {

        $BankAccount = new BankAccount();
        $membre = $this->getUser();
        $form = $this->createForm(PreferencesVirementType::class, $BankAccount);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $BankForm = $form->getData();
        }
        // Envoi de la vue
        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/preferencesVirement.html.twig',
            'form'=>$form->createView(),
            'membre' => $membre
        ));

    }
}
