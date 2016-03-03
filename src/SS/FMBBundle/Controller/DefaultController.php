<?php

namespace SS\FMBBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SSFMBBundle:Default:index.html.twig');
    }

    public function parcViewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            'SSFMBBundle:Default:choixParc.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    public function generalViewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $parc = $em
            ->getRepository('SSFMBBundle:Parc')
            ->find($id);
        if (null === $parc) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
        $listCordes = $em
            ->getRepository('SSFMBBundle:Corde')
            ->findBy(
                array(
                    'ssegment' =>
                        $em
                            ->getRepository('SSFMBBundle:SSegment')
                            ->findBy(
                                array(
                                    'segment' =>
                                        $em
                                            ->getRepository('SSFMBBundle:Segment')
                                            ->findBy(
                                                array(
                                                    'filiere' => $em
                                                        ->getRepository('SSFMBBundle:Filiere')
                                                        ->findBy(array('parc' => $parc)),
                                                )
                                            ),
                                )
                            ),
                )
            );

        return $this->render(
            'SSFMBBundle:Default:generalView.html.twig',
            array(
                'parc' => $parc,
                'listCordes' => $listCordes,
            )
        );
    }
}
