<?php

namespace Emova\IelraBundle\Controller;

use Emova\IelraBundle\Entity\OrderLine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Orderline controller.
 *
 * @Route("orderline")
 */
class OrderLineController extends Controller
{
    /**
     * Lists all orderLine entities.
     *
     * @Route("/", name="orderline_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderLines = $em->getRepository('IelraBundle:OrderLine')->findAll();

        return $this->render('orderline/index.html.twig', array(
            'orderLines' => $orderLines,
        ));
    }

    /**
     * @Route("/all", name="orderline_all")
     * @Method("GET")
     */
    public function allCommandeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $orderLines = $em->getRepository('IelraBundle:OrderLine')->findAll();
        return $this->render('orderline/all.html.twig', array(
            'orderLines' => $orderLines
        ));
    }
    /**
     * Creates a new orderLine entity.
     *
     * @Route("/new", name="orderline_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $orderLine = new Orderline();
        $form = $this->createForm('Emova\IelraBundle\Form\OrderLineType', $orderLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderLine);
            $em->flush($orderLine);

            return $this->redirectToRoute('orderline_show', array('id' => $orderLine->getId()));
        }

        return $this->render('orderline/new.html.twig', array(
            'orderLine' => $orderLine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a orderLine entity.
     *
     * @Route("/{id}", name="orderline_show")
     * @Method("GET")
     */
    public function showAction(OrderLine $orderLine)
    {
        $deleteForm = $this->createDeleteForm($orderLine);

        return $this->render('orderline/show.html.twig', array(
            'orderLine' => $orderLine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing orderLine entity.
     *
     * @Route("/{id}/edit", name="orderline_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrderLine $orderLine)
    {
        $deleteForm = $this->createDeleteForm($orderLine);
        $editForm = $this->createForm('Emova\IelraBundle\Form\OrderLineType', $orderLine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orderline_edit', array('id' => $orderLine->getId()));
        }

        return $this->render('orderline/edit.html.twig', array(
            'orderLine' => $orderLine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a orderLine entity.
     *
     * @Route("/{id}", name="orderline_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrderLine $orderLine)
    {
        $form = $this->createDeleteForm($orderLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderLine);
            $em->flush();
        }

        return $this->redirectToRoute('orderline_index');
    }

    /**
     * Creates a form to delete a orderLine entity.
     *
     * @param OrderLine $orderLine The orderLine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderLine $orderLine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderline_delete', array('id' => $orderLine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
