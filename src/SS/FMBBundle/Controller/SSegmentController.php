<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\SSegment;
use SS\FMBBundle\Form\SSegmentType;

/**
 * SSegment controller.
 *
 */
class SSegmentController extends Controller
{

    /**
     * Lists all SSegment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:SSegment')->findAll();

        return $this->render(
            'SSFMBBundle:SSegment:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new SSegment entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SSegment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ssegment_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:SSegment:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a SSegment entity.
     *
     * @param SSegment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SSegment $entity)
    {
        $form = $this->createForm(
            new SSegmentType(),
            $entity,
            array(
                'action' => $this->generateUrl('ssegment_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SSegment entity.
     *
     */
    public function newAction()
    {
        $entity = new SSegment();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:SSegment:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a SSegment entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:SSegment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SSegment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:SSegment:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a SSegment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ssegment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing SSegment entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:SSegment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SSegment entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:SSegment:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a SSegment entity.
     *
     * @param SSegment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SSegment $entity)
    {
        $form = $this->createForm(
            new SSegmentType(),
            $entity,
            array(
                'action' => $this->generateUrl('ssegment_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing SSegment entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:SSegment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SSegment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ssegment_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:SSegment:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a SSegment entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:SSegment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SSegment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ssegment'));
    }
}
