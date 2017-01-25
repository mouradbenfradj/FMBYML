<?php

namespace SS\FMBBundle\Controller\Menu\Planing;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlaningController extends Controller
{
    public function planingdetravailleAction(Request $request)
    {
        $date1 = new DateTime("now");
        $lanternefabriquer = array();
        $lanternefabriquerurgent = array();
        $cordefabriquer = array();
        $cordefabriquerurgent = array();
        $grossisementurgent = array();
        $grossisementurgentAW = array();
        $comercialeurgent = array();
        $pregrossisementaeffectuer = array();
        $grossisementaeffectuer = array();
        $grossisementaeffectuerAW = array();
        $comercialeaeffectuer = array();
        $pregrossisement = array();
        $grossisement = array();
        $grossisementAW = array();
        $comerciale = array();

        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parcs = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
            if ($parcs) {
                $crd = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array("pret" => false, "emplacement" => null, "corde" => $em->getRepository('SSFMBBundle:Corde')->findByParc($parcs)));
                if ($crd) {
                    $cordefabriquer = array();
                    $cordefabriquerurgent = array();
                    foreach ($crd as $corde) {
                        if ($corde->getDateDeCreation()) {
                            $diff = date_diff($corde->getDateDeCreation(), $date1);
                            if (($diff->d == 0) && ($diff->m == 0) && ($diff->y == 0)) {
                                $cordefabriquer = array_merge($cordefabriquer, array($corde));
                            } else {
                                $cordefabriquerurgent = array_merge($cordefabriquerurgent, array($corde));
                            }
                        }
                    }
                }
                $lntr = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(array("pret" => false, "emplacement" => null, "lanterne" => $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs)));
                if ($lntr) {
                    $lanternefabriquer = array();
                    $lanternefabriquerurgent = array();
                    foreach ($lntr as $lanterne) {
                        if ($lanterne->getDateDeCreation()) {
                            $diff = date_diff($lanterne->getDateDeCreation(), $date1);
                            if (($diff->d == 0) && ($diff->m == 0) && ($diff->y == 0)) {
                                $lanternefabriquer = array_merge($lanternefabriquer, array($lanterne));
                            } else {
                                $lanternefabriquerurgent = array_merge($lanternefabriquerurgent, array($lanterne));
                            }
                        }
                    }
                }
                $filieress = $em->getRepository('SSFMBBundle:Filiere')->getTotaleContenuFiliere($parcs);
                $filieres = array();
                foreach ($filieress as $item) {
                    $filieres[$item['fiId']]['nomFiliere'] = $item['nomFiliere'];
                    $filieres[$item['fiId']]['aireDeTravaille'] = $item['aireDeTravaille'];
                    $filieres[$item['fiId']][$item['sId']]['longeur'] = $item['longeur'];
                    $filieres[$item['fiId']][$item['sId']]['nomSegment'] = $item['nomSegment'];
                    $filieres[$item['fiId']][$item['sId']][$item['flId']]['nomFlotteur'] = $item['nomFlotteur'];
                    $filieres[$item['fiId']][$item['sId']][$item['flId']][$item['empId']] =
                        array('place' => $item['place'],
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
                                                    $interval = date_diff($emplacement['dateDeRemplissage'], $date1);
                                                    if ($emplacement['stockslanterne']) {
                                                        if (($interval->m >= 3) || ($interval->y >= 1)) {
                                                            $pregrossisementurgent[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                        } elseif (($interval->m == 2) && ($interval->d <= 7) && ($interval->m < 3)) {
                                                            $pregrossisementaeffectuer[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                        } else {
                                                            $pregrossisement[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                        }
                                                    } elseif ($emplacement['stockscorde'] && !$filiere['aireDeTravaille']) {
                                                        //debut moules
                                                        if (preg_match('/MOULES/i', $emplacement['libArticle'])) {

                                                            /*
                                                            {% if difference.m <=3 and difference.y ==0 %}PG{{ difference.m + 1 }}
                                                            {% elseif difference.m <=12 and difference.y == 0 %}G{{ difference.m + - 3 }}
                                                            {% elseif difference.m <=1 and difference.y == 1 %}G{{ difference.m + 9 }}
                                                            {% elseif difference.m >1 and difference.m <=3 and difference.y == 1 %}MS{{ difference.m - 1 }}
                                                            {% elseif difference.m >3 and difference.m <=7 and difference.y == 1 %}ME{{ difference.m - 3 }}
                                                            {% elseif difference.m >7 and difference.y == 1 %}MR{{ difference.m - 7 }}
                                                            {% elseif difference.y > 1 %}MR{{ difference.m + 3 }}
                                                            {% endif %}
                                                            */
                                                            if ((($interval->y == 1) && ($interval->m >= 10) || ($interval->y >= 2))) {
                                                                $grossisementurgent[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif (($interval->y == 1) && ($interval->m >= 8) && ($interval->m < 10)) {
                                                                $grossisementaeffectuer[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif ((($interval->y == 1) && ($interval->m == 7) && ($interval->d >= 21))) {
                                                                $grossisementaeffectuer[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif ((($interval->y == 1) && ($interval->m == 7) && ($interval->d < 21)) || (($interval->y == 1) && ($interval->m >= 4))) {
                                                                $grossisement[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif ((($interval->y == 1) && ($interval->m == 4) && ($interval->d >= 21))) {
                                                                $grossisementaeffectuer[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif ((($interval->y == 1) && ($interval->m == 4) && ($interval->d < 21)) || (($interval->y == 1) && ($interval->m >= 1))) {

                                                            } elseif ((($interval->y == 0) && ($interval->m <= 3) && ($interval->d <= 17))) {
                                                                $pregrossisement[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            }
                                                            //fin moules et debut huitre
                                                        } else {

                                                            if (($interval->m >= 6) || ($interval->y >= 1)) {
                                                                $grossisementurgent[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } elseif (($interval->m == 5) && ($interval->d >= 23) && ($interval->m < 6)) {
                                                                $grossisementaeffectuer[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            } else {
                                                                $grossisement[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                            }
                                                        }
                                                        //fin  huitre
                                                    } elseif ($emplacement['stockscorde'] && $filiere['aireDeTravaille']) {
                                                        if ($interval->m < 7) {
                                                            $grossisementAW[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                        } elseif (($interval->m >= 7) && ($interval->m < 8)) {
                                                            $grossisementaeffectuerAW[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
                                                        } else {
                                                            $grossisementurgentAW[$filiere['nomFiliere']][$segment['nomSegment']][$flotteur['nomFlotteur']][$cle] = $emplacement;
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
            $pretacomercialisation = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array("pret" => true, "corde" => $em->getRepository('SSFMBBundle:Corde')->findOneByParc($parcs)));
            if ($pretacomercialisation) {
                $p1 = array();
                $p2 = array();
                $p3 = array();
                foreach ($pretacomercialisation as $stocksCordes) {
                    if ($stocksCordes->getDateDeRetirement()) {
                        $interval = date_diff($stocksCordes->getDateDeRetirement(), $date1);
                        if ($interval->format('%R%m') >= 2) {
                            if (in_array($stocksCordes->getArticle(), $p1)) {
                                $key = array_search($stocksCordes->getArticle(), $p1);
                                $comercialeurgent[$key]->setQuantiter($stocksCordes->getQuantiter() + $comercialeurgent[$key]->getQuantiter());
                            } else {
                                $p1 = array_merge($p1, array($stocksCordes->getArticle()));
                                $comercialeurgent = array_merge($comercialeurgent, array($stocksCordes));
                            }
                        } elseif (($interval->format('%R%m') < 2) && ($interval->format('%R%m') >= 1)) {
                            if (in_array($stocksCordes->getArticle(), $p2)) {
                                $key = array_search($stocksCordes->getArticle(), $p2);
                                $comercialeaeffectuer[$key]->setQuantiter($stocksCordes->getQuantiter() + $comercialeaeffectuer[$key]->getQuantiter());
                            } else {
                                $p2 = array_merge($p2, array($stocksCordes->getArticle()));
                                $comercialeaeffectuer = array_merge($comercialeaeffectuer, array($stocksCordes));
                            }
                        } elseif ($interval->format('%R%m') < 1) {
                            if (in_array($stocksCordes->getArticle(), $p3)) {
                                $key = array_search($stocksCordes->getArticle(), $p3);
                                $comerciale[$key]->setQuantiter($stocksCordes->getQuantiter() + $comerciale[$key]->getQuantiter());
                            } else {
                                $p3 = array_merge($p3, array($stocksCordes->getArticle()));
                                $comerciale = array_merge($comerciale, array($stocksCordes));

                            }
                        }
                    }
                }
            }
        }
        return $this->render('@SSFMB/Default/planingdetravaille.html.twig',
            array('laf' => $lanternefabriquer,
                'lafu' => $lanternefabriquerurgent,
                'caf' => $cordefabriquer,
                'cafu' => $cordefabriquerurgent,
                'entity' => $parcs,
                'pregrossisement' => $pregrossisement,
                'grossisement' => $grossisement,
                'grossisementAW' => $grossisementAW,
                'comerciale' => $comerciale,
                'pregrossisementaeffectuer' => $pregrossisementaeffectuer,
                'grossisementaeffectuer' => $grossisementaeffectuer,
                'grossisementaeffectuerAW' => $grossisementaeffectuerAW,
                'comercialeaeffectuer' => $comercialeaeffectuer,
                'pregrossisementurgent' => $pregrossisementurgent,
                'grossisementurgent' => $grossisementurgent,
                'grossisementurgentAW' => $grossisementurgentAW,
                'comercialeurgent' => $comercialeurgent));
    }

}

