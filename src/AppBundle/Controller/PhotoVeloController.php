<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PhotoVelo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Photovelo controller.
 *
 * @Route("photovelo")
 */
class PhotoVeloController extends Controller
{
    /**
     * Lists all photoVelo entities.
     *
     * @Route("/", name="photovelo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $membre = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $photoVelos = $em->getRepository('AppBundle:PhotoVelo')->findAll();

        return $this->render('photovelo/index.html.twig', array(
            'photoVelos' => $photoVelos,
            'membre' => $membre
        ));
    }

    /**
     * Creates a new photoVelo entity.
     *
     * @Route("/new", name="photovelo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, PhotoVelo $photoVelo)
    {
        $membre = $this->getUser();
        $photoVelo = new Photovelo();

        $deleteForm = $this->createDeleteForm($photoVelo);

        $form = $this->createForm('AppBundle\Form\PhotoVeloType', $photoVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deleteForm = $this->createDeleteForm($photoVelo);
            $em = $this->getDoctrine()->getManager();
            $em->persist($photoVelo);
            $em->flush();

            return $this->redirectToRoute('photovelo_show', array(
                'id' => $photoVelo->getId(),
                'delete_form' => $deleteForm->createView()
            ));
        }

        return $this->render('photovelo/new.html.twig', array(
            'photoVelo' => $photoVelo,
            'form' => $form->createView(),
            'membre' => $membre,
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Finds and displays a photoVelo entity.
     *
     * @Route("/{id}", name="photovelo_show")
     * @Method("GET")
     */
    public function showAction(PhotoVelo $photoVelo)
    {
        $membre = $this->getUser();
        $deleteForm = $this->createDeleteForm($photoVelo);

        return $this->render('photovelo/show.html.twig', array(
            'photoVelo' => $photoVelo,
            'delete_form' => $deleteForm->createView(),
            'membre' => $membre
        ));
    }

    /**
     * Displays a form to edit an existing photoVelo entity.
     *
     * @Route("/{id}/edit", name="photovelo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PhotoVelo $photoVelo)
    {
        $deleteForm = $this->createDeleteForm($photoVelo);
        $editForm = $this->createForm('AppBundle\Form\PhotoVeloType', $photoVelo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photovelo_edit', array('id' => $photoVelo->getId()));
        }

        return $this->render('photovelo/edit.html.twig', array(
            'photoVelo' => $photoVelo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photoVelo entity.
     *
     * @Route("/{id}", name="photovelo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PhotoVelo $photoVelo)
    {
        $form = $this->createDeleteForm($photoVelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photoVelo);
            $em->flush();
        }

        return $this->redirectToRoute('photovelo_index');
    }

    /**
     * Creates a form to delete a photoVelo entity.
     *
     * @param PhotoVelo $photoVelo The photoVelo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PhotoVelo $photoVelo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photovelo_delete', array('id' => $photoVelo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
