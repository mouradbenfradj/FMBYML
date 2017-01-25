<?php

namespace SS\FMBBundle\Controller\Menu\MAE;
use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LanterneController extends Controller
{
    public function miseAEauLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $defaultmetier = new DefaultImpl($em);

        if ($request->get('idparc') == null) {
            $parcs = null;
            $stock = null;
            $lanternes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $lanternes = $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs);
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }
        if ($request->isMethod('POST')) {
            $lanterne = $em->getRepository('SSFMBBundle:Lanterne')->find($request->request->get('lanternechoix'));
            $dateMiseAEau = new \DateTime($request->request->get('dateMAELanterne'));
            foreach ($request->request->get('placelanterne') as $emplacementlanterne) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementlanterne);
                $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->request->get('articlechoix'), $request->request->get('articlelotchoix')), $lanterne);
                $lanternearticle[0]->setEmplacement($place);
                $lanternearticle[0]->setDateDeMiseAEau($dateMiseAEau);
                $place->setStocksLanterne($lanternearticle[0]);
                $place->setDateDeRemplissage($dateMiseAEau);
                $lanternearticle[0]->setCycleR(3);
                $em->flush();
            }
            return $this->redirectToRoute('ssfmb_misaaeaulanterne');
        }
        return $this->render('@SSFMB/MAE/Lanterne/miseAEauLanterne.html.twig', array('entity' => $parcs, 'articles' => $articles, 'lanternes' => $lanternes,));
    }

}