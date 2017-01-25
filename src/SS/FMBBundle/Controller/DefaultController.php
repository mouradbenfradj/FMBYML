<?php

namespace SS\FMBBundle\Controller;

use DateTime;
use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\Historique;
use SS\FMBBundle\Entity\StocksArticles;
use SS\FMBBundle\Entity\StocksArticlesSn;
use SS\FMBBundle\Entity\StocksArticlesSnVirtuel;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationCordeType;
use SS\FMBBundle\Form\PreparationLanterneType;
use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('ssfmb_statistique');
    }




    
    public function quantiterEnStocksSnActuelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stocksArticlesSn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->get('stocks'), $request->get('lot'));
        return $this->render('SSFMBBundle:Render:quantiterEnStocksArticlesSnRender.html.twig', array(
            'stocksArticlesSn' => $stocksArticlesSn->getSnQte()));
    }

    public function processgrocissmeentAction(Request $request)
    {
        $date1 = new DateTime("now");
        $pg[0] = array();
        $pg[1] = array();
        $pg[2] = array();
        $pg[3] = array();
        $pg[4] = array();
        $gr[0] = array();
        $gr[1] = array();
        $gr[2] = array();
        $gr[3] = array();
        $gr[4] = array();
        $gr[5] = array();
        $gr[6] = array();
        $gr[7] = array();
        $gr[8] = array();
        $gr[9] = array();
        $gr[10] = array();
        $gr[11] = array();
        $cr[0] = array();
        $cr[1] = array();
        $cr[2] = array();
        $cr[3] = array();
        $cr[4] = array();
        $cr[5] = array();
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parc = null;
        } else {
            $parc = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            if ($parc) {
                $filieress = $em->getRepository('SSFMBBundle:Filiere')->getTotaleContenuFiliere($parc);
                $filieres = array();
                foreach ($filieress as $item) {
                    $filieres[$item['fiId']]['nomFiliere'] = $item['nomFiliere'];
                    $filieres[$item['fiId']]['aireDeTravaille'] = $item['aireDeTravaille'];
                    $filieres[$item['fiId']][$item['sId']]['longeur'] = $item['longeur'];
                    $filieres[$item['fiId']][$item['sId']]['nomSegment'] = $item['nomSegment'];
                    $filieres[$item['fiId']][$item['sId']][$item['flId']]['nomFlotteur'] = $item['nomFlotteur'];
                    $filieres[$item['fiId']][$item['sId']][$item['flId']][$item['empId']] =
                        array('place' => $item['place'],
                            'filiere' => $item['nomFiliere'],
                            'segment' => $item['nomSegment'],
                            'flotteur' => $item['nomFlotteur'],
                            'numeroSerieLanrt' => $item['numeroSerieLanrt'],
                            'llibArticle' => $item['llibArticle'],
                            'libArticle' => $item['libArticle'],
                            'nomLanterne' => $item['nomLanterne'],
                            'nomCorde' => $item['nomCorde'],
                            'numeroSerie' => $item['numeroSerie'],
                            'dateDeRemplissage' => $item['dateDeRemplissage'],
                            'stockscorde' => $item['sc'],
                            'qte' => $item['qte'] * $item['nbrpoche'],
                            'qtec' => $item['qtec'],
                            'stockslanterne' => $item['sl']);
                }
                foreach ($filieres as $filiere) {
                    if (is_array($filiere)) {
                        foreach ($filiere as $segment) {
                            if (is_array($segment)) {
                                foreach ($segment as $flotteur) {
                                    if (is_array($flotteur)) {
                                        foreach ($flotteur as $cle => $emplacement) {
                                            if (is_array($emplacement)) {
                                                if ($emplacement['dateDeRemplissage']) {
                                                    if ($emplacement['dateDeRemplissage']) {
                                                        $interval = date_diff($emplacement['dateDeRemplissage'], $date1);
                                                        if ($emplacement['stockslanterne']) {
                                                            if ($interval->y == 0) {
                                                                switch ($interval->m) {
                                                                    case 0 :
                                                                        if (isset($pg[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $pg[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $pg[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 1 :
                                                                        if (isset($pg[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $pg[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $pg[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 2 :
                                                                        if (isset($pg[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $pg[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $pg[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 3 :
                                                                        if (isset($pg[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $pg[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $pg[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    default :
                                                                        if (isset($pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                }
                                                            } else {
                                                                if (isset($pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                    $pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                else
                                                                    $pg[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                            }
                                                        } elseif ($emplacement['stockscorde']) {
                                                            if ($interval->y == 0) {
                                                                switch ($interval->m) {
                                                                    case 0 :
                                                                        if (isset($gr[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[0][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 1 :
                                                                        if (isset($gr[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[1][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 2 :
                                                                        if (isset($gr[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[2][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 3 :
                                                                        if (isset($gr[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[3][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 4 :
                                                                        if (isset($gr[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[4][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 5 :
                                                                        if (isset($gr[5][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[5][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[5][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[5][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 6 :
                                                                        if (isset($gr[6][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[6][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[6][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[6][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 7 :
                                                                        if (isset($gr[7][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[7][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[7][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[7][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 8 :
                                                                        if (isset($gr[8][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[8][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[8][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[8][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 9 :
                                                                        if (isset($gr[9][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[9][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[9][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[9][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    case 10 :
                                                                        if (isset($gr[10][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[10][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[10][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[10][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                    default :
                                                                        if (isset($gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                            $gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                        else
                                                                            $gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                                        break;
                                                                }
                                                            } else {
                                                                if (isset($gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]]))
                                                                    $gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array_merge($gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]], array($emplacement));
                                                                else
                                                                    $gr[11][$filiere["nomFiliere"]][$segment['nomSegment']][$flotteur["nomFlotteur"]] = array($emplacement);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $pretacomercialisation = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array("pret" => true, "corde" => $em->getRepository('SSFMBBundle:Corde')->findOneByParc($parc)));
                if ($pretacomercialisation) {
                    $p1 = array();
                    $p2 = array();
                    $p3 = array();
                    $p4 = array();
                    foreach ($pretacomercialisation as $stocksCordes) {
                        if ($stocksCordes->getDateDeRetirement()) {
                            $interval = date_diff($stocksCordes->getDateDeRetirement(), $date1);
                            switch ($interval->m) {
                                case 0 :
                                    if (in_array($stocksCordes->getArticle(), $p1)) {
                                        $key = array_search($stocksCordes->getArticle(), $p1);
                                        $cr[4][$key]->setQuantiter($stocksCordes->getQuantiter() + $cr[4][$key]->getQuantiter());
                                    } else {
                                        $p1 = array_merge($p1, array($stocksCordes->getArticle()));
                                        $cr[4] = array_merge($cr[4], array($stocksCordes));
                                    }
                                    break;
                                case 1 :
                                    if (in_array($stocksCordes->getArticle(), $p2)) {
                                        $key = array_search($stocksCordes->getArticle(), $p2);
                                        $cr[3][$key]->setQuantiter($stocksCordes->getQuantiter() + $cr[3][$key]->getQuantiter());
                                    } else {
                                        $p2 = array_merge($p2, array($stocksCordes->getArticle()));
                                        $cr[3] = array_merge($cr[3], array($stocksCordes));
                                    }
                                    break;
                                case 2 :
                                    if (in_array($stocksCordes->getArticle(), $p3)) {
                                        $key = array_search($stocksCordes->getArticle(), $p3);
                                        $cr[2][$key]->setQuantiter($stocksCordes->getQuantiter() + $cr[2][$key]->getQuantiter());
                                    } else {
                                        $p3 = array_merge($p3, array($stocksCordes->getArticle()));
                                        $cr[2] = array_merge($cr[2], array($stocksCordes));
                                    }
                                    break;
                                case 3 :
                                    if (in_array($stocksCordes->getArticle(), $p4)) {
                                        $key = array_search($stocksCordes->getArticle(), $p4);
                                        $cr[1][$key]->setQuantiter($stocksCordes->getQuantiter() + $cr[1][$key]->getQuantiter());
                                    } else {
                                        $p4 = array_merge($p4, array($stocksCordes->getArticle()));
                                        $cr[1] = array_merge($cr[1], array($stocksCordes));
                                    }
                                    break;
                                default :
                                    $cr[0] = array_merge($cr[0], array($stocksCordes));
                                    break;
                            }
                        }
                    }
                }
            }
        }
        return $this->render('@SSFMB/Default/processusgrocissement.html.twig', array('cr' => $cr, 'pg' => $pg, 'gr' => $gr, 'entity' => $parc));
    }
}

