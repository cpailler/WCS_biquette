<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 18/06/18
 * Time: 14:48
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Membre;
use AppBundle\Service\JaugeProfil;
use AppBundle\Service\PointsManager;
use FOS\UserBundle\Controller\ChangePasswordController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * InfoProfil controller.
 *
 * @Route("profil")
 */
class ChangePasswordController extends BaseController
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
     * @Route("/password", name="profil_password")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return null|Response
     */
    public function changePasswordAction(Request $request)
    {

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $eventDispatcher = $this->get('event_dispatcher');

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            $this->addFlash('success','Mot de passe modifié avec succès!');
        }
        $jaugeProfil = New JaugeProfil();
        $jaugeProfil = $this->getJaugeProfil($user, $jaugeProfil);

        return $this->render('profil/layoutProfil.html.twig', array(
            'formulaire'=>'profil/passwordProfil.html.twig',
            'form' => $form->createView(),
            'membre' => $user,
            'jaugeProfil' => $jaugeProfil
        ));
    }
}