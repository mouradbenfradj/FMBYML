<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Entity\Stockage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\BonReception;
use SS\FMBBundle\Form\BonReceptionType;

/**
 * BonReception controller.
 *
 */
class BonReceptionController extends Controller
{

    /**
     * Lists all BonReception entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:BonReception')->findAll();

        return $this->render(
            'SSFMBBundle:BonReception:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }
    /**
     * Creates a new BonReception entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new BonReception();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SSFMBBundle:Lot')
            ;
            $dt=new \Datetime();
            //$dt->modify("- 2 days");

            if($repository->findByLot($dt->format('ymd')) != null)
            {
                $nLot =$repository->findOneBy(array('lot' => $dt->format('ymd')));
                $entity->setNLot($nLot);
            }else
            {
                $nLot = new Lot();
                $nLot->setLot($dt->format('ymd'));
                $entity->setNLot($nLot);
            }
            $repositoryStock = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('SSFMBBundle:Stockage');

            $stock = new Stockage();
            if (!empty($repositoryStock->existe($entity->getArticle(), $entity->getNLot()))) {
                $stock = $repositoryStock->existe($entity->getArticle(), $entity->getNLot())[0];
                $stock->setQuantiter(($stock->getQuantiter() + ($entity->getQuantiter() * $entity->getDuplication())));

                $em->merge($stock);
            } else {
                $stock->setArticle($entity->getArticle());
                $stock->setQuantiter($entity->getQuantiter() * $entity->getDuplication());
                $stock->setNLot($entity->getNLot());
                $em->persist($stock);
                $em->flush();

            }

            $em->persist($entity);

            $em->flush();

            return $this->redirect($this->generateUrl('bonreception_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'SSFMBBundle:BonReception:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a BonReception entity.
     *
     * @param BonReception $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BonReception $entity)
    {
        $form = $this->createForm(
            new BonReceptionType(),
            $entity,
            array(
                'action' => $this->generateUrl('bonreception_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BonReception entity.
     *
     */
    public function newAction()
    {
        $entity = new BonReception();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'SSFMBBundle:BonReception:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a BonReception entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:BonReception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonReception entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:BonReception:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to delete a BonReception entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bonreception_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing BonReception entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:BonReception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonReception entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'SSFMBBundle:BonReception:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a BonReception entity.
     *
     * @param BonReception $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(BonReception $entity)
    {
        $form = $this->createForm(
            new BonReceptionType(),
            $entity,
            array(
                'action' => $this->generateUrl('bonreception_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing BonReception entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SSFMBBundle:BonReception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BonReception entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bonreception_edit', array('id' => $id)));
        }

        return $this->render(
            'SSFMBBundle:BonReception:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a BonReception entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SSFMBBundle:BonReception')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BonReception entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bonreception'));
    }
}
