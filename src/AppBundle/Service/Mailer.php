<?php
/**
 * Created by PhpStorm.
 * User: xavier
 * Date: 01/06/2018
 * Time: 13:24
 */

namespace AppBundle\Service;

use AppBundle\Entity\Membre;

class Mailer {

    /**
     * @var string
     */
    private $mailer;

    /**
     * @var string
     */
    private $templating;

    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param $membre
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function registrationEmail(Membre $membre)
    {
        $body = $this->templating->render('email/reinitialisation.email.twig', [
            'membre' => $membre,
        ]);

        $message = (new \Swift_Message('Réinitialiser votre mot de passe'))
            ->setFrom(['infos@bikerr.fr' => 'Bikerr'])
            ->setTo($membre->getEmail())
            ->setBody($body,'text/html');
            $this->mailer->send($message);
    }

    /**
     * @param $preteur
     * @param $emprunteur
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function demandeEmail($preteur, $emprunteur)
    {
        $body = $this->templating->render('demande.email.twig', [
            'preteur' => $preteur,
            'emprunteur' => $emprunteur
        ]);

        $message = (new \Swift_Message('Demande de partage'))
            ->setFrom(['infos@bikerr.fr' => 'Bikerr'])
            ->setTo($emprunteur)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }

}