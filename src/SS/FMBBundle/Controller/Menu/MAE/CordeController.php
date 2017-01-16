<?php

namespace SS\FMBBundle\Controller\Menu\MAE;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CordeController extends Controller
{

    public function miseAEauCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parcs = null;
            $stock = null;
            $cordes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $cordes = $em->getRepository('SSFMBBundle:Corde')->findByParc($parcs);
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }
        if ($request->isMethod('POST')) {
            $dateMiseAEau = new \DateTime($request->request->get('dateMAECorde'));
            $corde = $em->getRepository('SSFMBBundle:Corde')->find($request->request->get('cordechoix'));
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $cordearticle = $em->getRepository('SSFMBBundle:StocksCordes')->getCordePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->request->get('articlechoix'), $request->request->get('articlelotchoix')), $corde);
                $cordearticle[0]->setEmplacement($place);
                $cordearticle[0]->setDateDeMiseAEau($dateMiseAEau);
                $place->setStocksCorde($cordearticle[0]);
                $place->setDateDeRemplissage($dateMiseAEau);
                $em->flush();
            }
            return $this->redirectToRoute('ssfmb_misaaeaucorde');
        }
        return $this->render(
            '@SSFMB/MAE/Corde/miseAEauCorde.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'cordes' => $cordes,
            )
        );
    }

}