<?php

namespace SS\FMBBundle\Controller\Menu\Assemblage\PocheACorde;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PocheACordeController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($request->isMethod('POST')) {
            $corde = $em->getRepository('SSFMBBundle:Corde')->find($request->get('corde'));
            var_dump($corde);
            for ($i = 0; $i < $request->get('nbrCordeAssemblage'); $i++) {
                foreach ($request->get('contenu') as $contenu) {
                    var_dump($contenu);
                }
            }
            die();
            return $this->render('@SSFMB/Assemblage/PocheACorde.html.twig');
        }

        return $this->render('@SSFMB/Assemblage/PocheACorde.html.twig',
            array('parcs' => $parcs)
        );
    }
}
