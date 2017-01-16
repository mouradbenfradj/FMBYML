<?php

namespace SS\FMBBundle\Controller\Menu\Statistique;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatistiqueController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null)
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        else
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
        return $this->render('SSFMBBundle:Default:index.html.twig', array('entity' => $parc));
    }
}