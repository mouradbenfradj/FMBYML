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
            $nbCordeAs = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssemble();
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEau();
            $nbCordeAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleAEau();
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStock();
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES + $nbCordeAs + $nbCordeAsAe;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparer();
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEau();
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStock();
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparer();
            $nbPocheAsP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssemblePreparer();
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEau();
            $nbPocheAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssembleAEau();
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStock();
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES;
        } else {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            $nbfiliere = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrFiliereByParc($parc);
            $nbCordeP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordePreparerByParc($parc);
            $nbCordeAs = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleByParc($parc);
            $nbCordeAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAEauByParc($parc);
            $nbCordeAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeAssembleAEauByParc($parc);
            $nbCordeES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrCordeEnStockByParc($parc);
            $nbCorde = $nbCordeP + $nbCordeAe + $nbCordeES;

            $nbLanterneP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanternePreparerByParc($parc);
            $nbLanterneAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneAEauByParc($parc);
            $nbLanterneES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrLanterneEnStockByParc($parc);
            $nbLanterne = $nbLanterneP + $nbLanterneAe + $nbLanterneES;

            $nbPocheP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPochePreparerByParc($parc);
            $nbPocheAsP = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssemblePreparerByParc($parc);
            $nbPocheAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAEauByParc($parc);
            $nbPocheAsAe = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheAssembleAEauByParc($parc);
            $nbPocheES = $em->getRepository('SSFMBBundle:Magasins')->countTotaleNbrPocheEnStockByParc($parc);
            $nbPoche = $nbPocheP + $nbPocheAe + $nbPocheES + $nbPocheAsP + $nbPocheAsAe;
        }
        return $this->render('SSFMBBundle:Default:index.html.twig',
            array(
                'entity' => $parc,
                'nbrParc' => count($parc),
                'nbrcorde' => ($nbCorde),
                'nbrcordev' => ($nbCordeES),
                'nbrCordeAs' => ($nbCordeAs),
                'nbrCordeAsAe' => ($nbCordeAsAe),
                'nbrcordep' => ($nbCordeP),
                'nbrcordeae' => ($nbCordeAe),
                'nbrlanterne' => ($nbLanterne),
                'nbrlanternev' => ($nbLanterneES),
                'nbrlanternep' => ($nbLanterneP),
                'nbrlanterneae' => ($nbLanterneAe),
                'nbrpoche' => ($nbPoche),
                'nbrpochev' => ($nbPocheES),
                'nbrpochep' => ($nbPocheP),
                'nbrpocheAsp' => ($nbPocheAsP),
                'nbrpocheae' => ($nbPocheAe),
                'nbrpocheAsae' => ($nbPocheAsAe),
                'nbrfiliere' => $nbfiliere
            )
        );
    }
}