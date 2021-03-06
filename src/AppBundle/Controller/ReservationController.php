<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 11/07/18
 * Time: 10:36
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Reservation;
use AppBundle\Entity\Velo;
use AppBundle\Form\ReservationType;
use AppBundle\Service\Calendrier\Calendrier;
use AppBundle\Service\DateCheck;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Partage controller.
 *
 * @Route("/reservation")
 * @Method({"GET", "POST"})
 */

class ReservationController extends Controller
{
    /**
     * @Route("/{id}", name="reservation")
     *
     */
    public function utilisateurReservationAction(Request $request, Velo $velo, DateCheck $dateCheck, Calendrier $calendrier, \Swift_Mailer $mailer)
    {
        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reservation = New Reservation();
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);
        if ($reservationForm->isSubmitted() && $reservationForm->isValid() && $membre!=$velo->getProprio()) {
            if ($dateCheck->isLegalReservation($reservation, $velo, $calendrier)) {
                $nbDay = intval($reservation->getDebut()->diff($reservation->getFin(), true)->format('%d')) + 1;
                $reservation->setNbDay($nbDay);
                $reservation->setVelo($velo);
                $reservation->setLocataire($membre);
                $reservation->setCoutPts($velo->getCoutPts() * $nbDay);
                if ($velo->getCautionOblig() == 1){
                    $reservation->setCaution($velo->getCaution());
                }else{
                    $reservation->setCaution(0);
                }

                if ($velo->getAssurOblig() == 1) {
                    $reservation->setAssurance(1 * $nbDay);
                } else {
                    $reservation->setAssurance(0);
                }

                $em->persist($reservation);
                $em->flush();

                // TODO Mail au proprio pour valider la reservation (demande)

                $emailProprio = $velo->getProprio()->getEmail();

                $message = (new \Swift_Message('Demande de réservation'))
                    ->setFrom('infos@bikerr.fr')
                    ->setTo($emailProprio)
                    ->setBody(
                        $this->renderView(
                            'email/demande.email.twig',
                            array('reservation' => $reservation)
                        ),
                        'text/html'
                    )
                ;

                $mailer->send($message);

                return $this->redirectToRoute('partage', array('id'=>$reservation->getId()));


            } else {
                $this->addFlash('error', 'La réservation n\'est pas valide, merci de vérifier la disponibilité du vélo.');
            }


        }
        elseif ($membre==$velo->getProprio()){
            $this->addFlash('error', 'Vous ne pouvez pas réserver votre propre velo');
        }


        return $this->render('partage/reservation.html.twig', array(

            'membre' => $membre,
            'reservation' => $reservation,
            'reservationForm' => $reservationForm->createView(),
            'velo' => $velo));
    }


}