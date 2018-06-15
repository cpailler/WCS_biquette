<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 14/06/2018
 * Time: 09:57
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Membre;
use AppBundle\Form\EnregistrementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profil controller.
 *
 * @Route("register")
 */
class EnregistrementController extends Controller
{
    /**
     * @Route("/", name="enregistrement")
     *
     */
    public function indexAction(request $request)
    {
        $membre= new Membre();
        $form = $this->createForm(EnregistrementType::class,$membre);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('enregistrement/enregistrement.html.twig', array(
            'form'=>$form->createView()
        ));
    }
}
