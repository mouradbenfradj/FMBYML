<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\Lot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        if (!$em->getRepository('SSFMBBundle:Lot')->find(date("Ymd"))) {
            $lotId = new Lot();
            $lotId->setLot(date("Ymd"));
            $em->persist($lotId);
            $em->flush();
        }
        $parcs = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            'SSFMBBundle:Default:index.html.twig',
            array(
                'entities' => $parcs,
            )
        );

    }

    public function preparationCordeAction()
    {
        $corde = new Corde();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder('form', $corde);

        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('author', 'text')
            ->add('published', 'checkbox')
            ->add('save', 'submit');
        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        return $this->render(
            'SSFMBBundle:Default:preparationCorde.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function preparationLanterneAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Corde')->findAll();

        return $this->render(
            '@SSFMB/Default/preparationLanterne.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    public function miseAEauCordeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Corde')->findAll();

        return $this->render(
            '@SSFMB/Default/miseAEauCorde.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    public function miseAEauLanterneAction()
    {
        $em = $this->getDoctrine()->getManager();
        if (!$em->getRepository('SSFMBBundle:Lot')->find(date("Ymd"))) {
            $lotId = new Lot();
            $lotId->setLot(date("Ymd"));
            $em->persist($lotId);
            $em->flush();
        }
        $entities = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            'SSFMBBundle:Default:miseAEauLanterne.html.twig',
            array(
                'entities' => $entities,
            )
        );

    }

    public function retraitCordeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Corde')->findAll();

        return $this->render(
            '@SSFMB/Default/retraitCorde.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    public function retraitLanterneAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SSFMBBundle:Corde')->findAll();

        return $this->render(
            '@SSFMB/Default/retraitLanterne.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }
}
