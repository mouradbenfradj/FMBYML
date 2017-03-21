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
            $processus = null;
            $lanternes = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $lanternes = $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs);
            $processus = $em->getRepository('SSFMBBundle:Processus')->findAll();
        }
        if ($request->isMethod('POST')) {
            $lanterne = $em->getRepository('SSFMBBundle:Lanterne')->find($request->request->get('lanternechoix'));
            $dateMiseAEau = new \DateTime($request->request->get('dateMAELanterne'));
            $dateLanternePreparer = new \DateTime($request->request->get('dateLanterneChoix'));
            $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle($request->request->get('articlechoix'));

            $stockArticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $request->request->get('idstockparc'), 'refArticle' => $article));
            $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($stockArticle, $request->request->get('articlelotchoix')), $lanterne, $dateLanternePreparer);
            $position = 0;
            $processusC = $em->getRepository('SSFMBBundle:Processus')->find($request->request->get('articlecyclechoix'));
            foreach ($request->request->get('placelanterne') as $emplacementlanterne) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementlanterne);

                $lanternearticle[$position]->setEmplacement($place);
                $lanternearticle[$position]->setDateDeMiseAEau($dateMiseAEau);
                $lanternearticle[$position]->setProcessus($processusC);
                $place->setStocksLanterne($lanternearticle[$position]);
                $place->setDateDeRemplissage($dateMiseAEau);
                $lanternearticle[$position]->setCycleR($processusC->getDuree()['mois']);
                $em->flush();
                $position++;

            }
            return $this->redirectToRoute('ssfmb_misaaeaulanterne');
        }
        return $this->render('@SSFMB/MAE/Lanterne/miseAEauLanterne.html.twig', array('entity' => $parcs, 'lanternes' => $lanternes, 'processus' => $processus));
    }

}