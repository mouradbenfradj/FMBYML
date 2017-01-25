<?php

namespace SS\FMBBundle\Controller\Menu\Statistique;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StatistiqueController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findAll();
            $nbfiliere = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrFiliere();
            $nbCordeP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordePreparer();
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEau();
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStock();
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparer();
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEau();
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStock();
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparer();
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEau();
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStock();
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES;
        } else {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $nbfiliere = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrFiliereByParc($parc);
            $nbCordeP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordePreparerByParc($parc);
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEauByParc($parc);
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStockByParc($parc);
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparerByParc($parc);
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEauByParc($parc);
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStockByParc($parc);
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparerByParc($parc);
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEauByParc($parc);
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStockByParc($parc);
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES;
        }
        return $this->render('SSFMBBundle:Default:index.html.twig',
            array(
                'entity' => $parc,
                'nbrcorde' => ($nbCorde),
                'nbrlanterne' => ($nbLanterne),
                'nbrpoche' => ($nbPoche),
                'nbrfiliere' => $nbfiliere
            )
        );
    }
}