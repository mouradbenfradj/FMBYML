<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Parc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Filiere;
use SS\FMBBundle\Form\FiliereType;

/**
 * Filiere controller.
 *
 */
class FiliereController extends Controller
{

    /**
     * Lists all Filiere entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Filiere')->findAll();

        return $this->render(
            'SSFMBBundle:Filiere:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Filiere entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Filiere();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            foreach ($entity->getSegments() as $segment) {
                $segment->setFiliere($entity);
                $em->persist($entity);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('filiere_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:Filiere:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Filiere entity.
     *
     * @param Filiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Filiere $entity)
    {
        $form = $this->createForm(
            new FiliereType(),
            $entity,
            array(
                'action' => $this->generateUrl('filiere_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Filiere entity.
     *
     */
    public function newAction()
    {
        $entity = new Filiere();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:Filiere:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    public function newdpAction(Parc $parc)
    {
        $entity = new Filiere();
        $entity->setParc($parc);
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:Filiere:newdp.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Filiere entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Filiere:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a Filiere entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('filiere_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Filiere entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:Filiere:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Filiere entity.
     *
     * @param Filiere $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Filiere $entity)
    {
        $form = $this->createForm(
            new FiliereType(),
            $entity,
            array(
                'action' => $this->generateUrl('filiere_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Filiere entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Filiere entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('filiere_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:Filiere:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Filiere entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Filiere')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Filiere entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('filiere'));
    }
}
