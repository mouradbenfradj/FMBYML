<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use SS\FMBBundle\Entity\Lanterne;
use SS\FMBBundle\Form\LanterneType;

/**
 * Lanterne controller.
 *
 */
class LanterneController extends Controller
{

    /**
     * Lists all Lanterne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Lanterne')->findAll();

        return $this->render('SSFMBBundle:Lanterne:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Lanterne entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Lanterne();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lanterne_show', array('id' => $entity->getId())));
        }

        return $this->render('SSFMBBundle:Lanterne:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Lanterne entity.
     *
     * @param Lanterne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($em, Lanterne $entity)
    {
        $form = $this->createForm(new LanterneType($em), $entity, array(
            'action' => $this->generateUrl('lanterne_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function ajaxAction(Request $request)
    {

        // Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();

        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Lanterne');
        $lanternes = $repo->findByParc($id, array('parc' => 'asc'));

        foreach ($lanternes as $lanterne) {

            $result[$lanterne->getNomLanterne()] = $lanterne->getNomLanterne();
        }
        return new JsonResponse($result);
    }

    /**
     * Displays a form to create a new Lanterne entity.
     *
     */
    public function newAction()
    {
        $entity = new Lanterne();
        $form = $this->createCreateForm($this->getDoctrine()->getManager(), $entity);
        return $this->render('SSFMBBundle:Lanterne:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lanterne entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Lanterne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lanterne entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Lanterne:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lanterne entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Lanterne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lanterne entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SSFMBBundle:Lanterne:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Lanterne entity.
     *
     * @param Lanterne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Lanterne $entity)
    {
        $form = $this->createForm(new LanterneType(), $entity, array(
            'action' => $this->generateUrl('lanterne_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Lanterne entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:Lanterne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lanterne entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lanterne_edit', array('id' => $id)));
        }

        return $this->render('SSFMBBundle:Lanterne:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lanterne entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:Lanterne')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lanterne entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lanterne'));
    }

    /**
     * Creates a form to delete a Lanterne entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lanterne_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
