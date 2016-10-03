<?php

namespace SS\FMBBundle\Controller;

use DateTime;
use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\StocksArticles;
use SS\FMBBundle\Entity\StocksArticlesSn;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationCordeType;
use SS\FMBBundle\Form\PreparationLanterneType;
use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == null)
            $parcs = null;
        else
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
        return $this->render('SSFMBBundle:Default:index.html.twig', array('entity' => $parcs));
    }

    public function preparationLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PreparationLanterneType($em), null, array('action' => $this->generateUrl('ssfmb_preparationlanterne'), 'method' => 'POST',));
        $form->add('submit', 'submit', array('label' => 'Create'));
        if ($request->isMethod('POST')) {
            $defaultmetier = new DefaultImpl($em);
            $form->handleRequest($request);
            $document = $form['document']->getData();
            $document->setDateCreationDoc(new \DateTime());
            $em->persist($document);
            $lant = $form['nomLanterne']->getData();
            foreach ($form['document']['docsLines']->getData() as $doclin) {
                $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form->get('libStock')->getData()->getIdStock(), 'refArticle' => $doclin->getRefArticle()));
                if (!empty($stockarticles)) {
                    for ($j = 0; $j < $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['nombre']; $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['numeroSerie']));
                        $doclin->setRefDoc($document);
                        $doclin->setLibArticle($doclin->getRefArticle()->getLibArticle());

                        $stockslanternes = new StocksLanternes();
                        $stockslanternes->setDateDeCreation($form->getData('date')['date']);
                        $stockslanternes->setArticle($stocksarticlessn);
                        $stockslanternes->setLanterne($lant);
                        $stockslanternes->setDocLine($doclin);
                        $stockarticles->setQte($stockarticles->getQte() - $doclin->getQte());
                        $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $doclin->getQte());

                        for ($i = 1; $i < ($stockslanternes->getLanterne()->getNbrpoche() + 1); $i++) {
                            $stockslanternes->addPoch($defaultmetier->remplirPoche($i, $doclin->getQte(), $stockslanternes->getLanterne()->getNbrpoche()));
                        }
                        $em->persist($stockslanternes);
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationLanterne.html.twig', array('form' => $form->createView(),));
                }
            }
            $lant->setNbrTotaleEnStock($lant->getNbrTotaleEnStock() - $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['nombre']);

            $em->flush();
            return $this->redirectToRoute('ssfmb_homepage');
        }
        return $this->render('@SSFMB/Default/preparationLanterne.html.twig', array('form' => $form->createView()));
    }

    public function miseAEauLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $defaultmetier = new DefaultImpl($em);

        if ($request->get('id') == null) {
            $parcs = null;
            $stock = null;
            $lanternes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            $lanternes = $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs);
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placelanterne') as $emplacementlanterne) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementlanterne);
                $lanterne = $em->getRepository('SSFMBBundle:Lanterne')->find($request->request->get('lanternechoix'));
                $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->getLanternePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->request->get('articlechoix'), $request->request->get('articlelotchoix')), $lanterne);
                $position = 0;
                while (($defaultmetier->calculerQuantiterLanterne($lanternearticle[$position]) != $request->request->get('quantierchoix')) && (count($lanternearticle) > $position)) {
                    $position++;
                }
                if ($defaultmetier->calculerQuantiterLanterne($lanternearticle[$position]) == $request->request->get('quantierchoix')) {
                    $lanternearticle[$position]->setEmplacement($place);
                    $place->setStocksLanterne($lanternearticle[$position]);
                    $place->setDateDeRemplissage(new \DateTime($request->request->get('dateMAELanterne')));
                }
                $em->flush();
            }
            return $this->redirectToRoute('ssfmb_misaaeaulanterne');
        }
        return $this->render(
            '@SSFMB/Default/miseAEauLanterne.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'lanternes' => $lanternes,
            )
        );
    }

    public function retraitLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == null) {
            $parcs = null;
            $stock = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }

        if ($request->isMethod('POST')) {
            $implementation = new DefaultImpl($em);
            $stock = $em->getRepository('SSFMBBundle:Stocks')->find($request->request->get('stockchoix'));
            foreach ($request->request->get('placelanterne') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $slanterne = $place->getStockslanterne();
                $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle(substr($slanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), strrpos($slanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), ' ', 0) + 1));
                if (!$article) {
                    $article = new Articles();
                    $article->setLibArticle(substr($slanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), strrpos($slanterne->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), ' ', 0) + 1));
                    $article->setLibTicket('');
                    $article->setDescCourte('');
                    $article->setDescLongue('');
                    $article->setRefArtCateg('');
                    $article->setModele('');
                    $article->setPaaLastMaj(new \DateTime());
                    $article->setPromo(0);
                    $article->setValoIndice(0);
                    $article->setLot(true);
                    $article->setComposant(true);
                    $article->setVariante(true);
                    $article->setGestionSn(true);
                    $article->setDateDebutDispo(new \DateTime());
                    $article->setDateFinDispo(new \DateTime());
                    $article->setDispo(true);
                    $article->setDateCreation(new \DateTime());
                    $article->setDateModification(new \DateTime());
                    $article->setIsAchetable(false);
                    $article->setIsVendable(false);
                    $em->persist($article);
                    $em->flush();
                }
                $sarticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneByRefArticle($article);
                if (!$sarticle) {
                    $sarticle = new StocksArticles();
                    $sarticle->setRefArticle($article);
                    $sarticle->setQte($implementation->calculerQuantiterLanterne($slanterne));
                    $sarticle->setIdStock($stock);
                    $em->persist($sarticle);
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $slanterne->getArticle()->getNumeroSerie());
                    if (!$sarticlesn) {
                        $sarticlesn = new StocksArticlesSn($slanterne->getArticle()->getNumeroSerie(), $implementation->calculerQuantiterLanterne($slanterne), $sarticle);
                        $em->persist($sarticlesn);
                        $em->flush();
                    }

                } else {
                    $sarticle->setQte($sarticle->getQte() + $implementation->calculerQuantiterLanterne($slanterne));
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $slanterne->getArticle()->getNumeroSerie());
                    if (!$sarticlesn) {
                        $sarticlesn = new StocksArticlesSn($slanterne->getArticle()->getNumeroSerie(), $implementation->calculerQuantiterLanterne($slanterne), $sarticle);
                        $em->persist($sarticlesn);
                        $em->flush();
                    } else {
                        $sarticlesn->setSnQte($sarticlesn->getSnQte() + $implementation->calculerQuantiterLanterne($slanterne));
                    }
                }

                $slanterne->setPret(true);
                $slanterne->setDateDeRetirement(new \DateTime($request->request->get('dateRetraitLanterne')));
                $slanterne->getLanterne()->setNbrTotaleEnStock($slanterne->getLanterne()->getNbrTotaleEnStock() + 1);
                $slanterne->setEmplacement(null);
                $place->setStockslanterne(null);
                $place->setDateDeRemplissage(null);
            }

            $em->flush();

            return $this->redirectToRoute('ssfmb_retraitLanterne');
        }

        return $this->render('SSFMBBundle:Default:retraitLanterne.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
            )
        );
    }

    public function preparationCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PreparationCordeType($em), null, array('action' => $this->generateUrl('ssfmb_preparationcorde'), 'method' => 'POST',));
        $form->add('submit', 'submit', array('label' => 'preparer'));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $document = $form['document']->getData();
            $document->setDateCreationDoc(new \DateTime());
            $document->setCodeFile("");
            $em->persist($document);
            $corde = $form['id']->getData();
            foreach ($form['document']['docsLines']->getData() as $doclin) {
                $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form->get('libStock')->getData()->getIdStock(), 'refArticle' => $doclin->getRefArticle()));
                if (!empty($stockarticles)) {
                    for ($j = 0; $j < $request->request->get("ss_fmbbundle_preparationcorde")['document']['docsLines'][0]['nombre']; $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationcorde")['document']['docsLines'][0]['numeroSerie']));
                        $doclin->setRefDoc($document);
                        $doclin->setLibArticle($doclin->getRefArticle()->getLibArticle());

                        $stockscordes = new StocksCordes();
                        $stockscordes->setDateDeCreation($form->getData('date')['date']);
                        $stockscordes->setPret(false);
                        $stockscordes->setArticle($stocksarticlessn);
                        $stockscordes->setCorde($corde);
                        $stockscordes->setQuantiter($doclin->getQte());
                        $stockscordes->setDocLine($doclin);
                        $stockarticles->setQte($stockarticles->getQte() - $doclin->getQte());
                        $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $doclin->getQte());
                        $em->persist($stockscordes);
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationCorde.html.twig', array('form' => $form->createView(),));
                }
            }
            $corde->setNbrTotaleEnStock($corde->getNbrTotaleEnStock() - $request->request->get("ss_fmbbundle_preparationcorde")['document']['docsLines'][0]['nombre']);

            $em->flush();
            return $this->redirectToRoute('ssfmb_homepage');
        }


        return $this->render(
            '@SSFMB/Default/preparationCorde.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function miseAEauCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $defaultmetier = new DefaultImpl($em);

        if ($request->get('id') == null) {
            $parcs = null;
            $stock = null;
            $cordes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            $cordes = $em->getRepository('SSFMBBundle:Corde')->findByParc($parcs);
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $corde = $em->getRepository('SSFMBBundle:Corde')->find($request->request->get('cordechoix'));
                $cordearticle = $em->getRepository('SSFMBBundle:StocksCordes')->getCordePreparer($em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->request->get('articlechoix'), $request->request->get('articlelotchoix')), $corde);
                $position = 0;
                while (($cordearticle[$position]->getQuantiter() != $request->request->get('quantierchoix')) && (count($cordearticle) > $position)) {
                    $position++;
                }
                if ($cordearticle[$position]->getQuantiter() == $request->request->get('quantierchoix')) {
                    $cordearticle[$position]->setEmplacement($place);
                    $place->setStocksCorde($cordearticle[$position]);
                    $place->setDateDeRemplissage(new \DateTime($request->request->get('dateMAECorde')));
                }
                $em->flush();
            }
            return $this->redirectToRoute('ssfmb_misaaeaucorde');
        }
        return $this->render(
            '@SSFMB/Default/miseAEauCorde.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'cordes' => $cordes,
            )
        );
    }

    public function retraitCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == null) {
            $parcs = null;
            $stock = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }

        if ($request->isMethod('POST')) {
            $stock = $em->getRepository('SSFMBBundle:Stocks')->find($request->request->get('stockchoix'));
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $scorde = $place->getStockscorde();

                $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle(substr($scorde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), strrpos($scorde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), ' ', 0)) . " comercial");
                if (!$article) {
                    $article = new Articles();
                    $article->setLibArticle(substr($scorde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), strrpos($scorde->getArticle()->getRefStockArticle()->getRefArticle()->getLibArticle(), ' ', 0)) . " comercial");
                    $article->setLibTicket('l');
                    $article->setDescCourte('e');
                    $article->setDescLongue('e');
                    $article->setRefArtCateg('r');
                    $article->setModele('m');
                    $article->setPaaLastMaj(new \DateTime());
                    $article->setPromo(1);
                    $article->setValoIndice(10);
                    $article->setLot(true);
                    $article->setComposant(true);
                    $article->setVariante(true);
                    $article->setGestionSn(true);
                    $article->setDateDebutDispo(new \DateTime());
                    $article->setDateFinDispo(new \DateTime());
                    $article->setDispo(true);
                    $article->setDateCreation(new \DateTime());
                    $article->setDateModification(new \DateTime());
                    $article->setIsAchetable(true);
                    $article->setIsVendable(true);
                    $em->persist($article);
                    $em->flush();
                }
                $sarticle = $em->getRepository('SSFMBBundle:StocksArticles')->findOneByRefArticle($article);
                if (!$sarticle) {
                    $sarticle = new StocksArticles();
                    $sarticle->setRefArticle($article);
                    $sarticle->setQte($scorde->getQuantiter());
                    $sarticle->setIdStock($stock);
                    $em->persist($sarticle);
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    if (!$sarticlesn) {
                        $sarticlesn = new StocksArticlesSn($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                        $em->persist($sarticlesn);
                        $scorde->setArticle($sarticlesn);
                        $em->flush();
                    }

                } else {
                    $sarticle->setQte($sarticle->getQte() + $scorde->getQuantiter());
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSN')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    if (!$sarticlesn) {
                        $sarticlesn = new StocksArticlesSn($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                        $scorde->setArticle($sarticlesn);
                        $em->persist($sarticlesn);
                        $em->flush();
                    } else {
                        $sarticlesn->setSnQte($sarticlesn->getSnQte() + $scorde->getQuantiter());
                        $scorde->setArticle($sarticlesn);

                    }

                }

                $scorde->setPret(true);
                $scorde->setDateDeRetirement(new \DateTime($request->request->get('dateRetraitCorde')));
                $scorde->getCorde()->setNbrTotaleEnStock($scorde->getCorde()->getNbrTotaleEnStock() + 1);
                $scorde->setEmplacement(null);
                $place->setStockscorde(null);
                $place->setDateDeRemplissage(null);
            }

            $em->flush();
            return $this->redirectToRoute('ssfmb_retraitcorde');

        }

        return $this->render('@SSFMB/Default/retraitCorde.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
            )
        );
    }

    public function planingdetravailleAction(Request $request)
    {
        $date1 = new DateTime("now");
        $lanternefabriquer = array();
        $lanternefabriquerurgent = array();
        $cordefabriquer = array();
        $cordefabriquerurgent = array();
        $pregrossisementurgent = array();
        $grossisementurgent = array();
        $comercialeurgent = array();
        $pregrossisementaeffectuer = array();
        $grossisementaeffectuer = array();
        $comercialeaeffectuer = array();
        $pregrossisement = array();
        $grossisement = array();
        $comerciale = array();

        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == null) {
            $parcs = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            if ($parcs) {

                $crd = $em->getRepository('SSFMBBundle:StocksCordes')->findBy(array("pret" => false, "emplacement" => null, "corde" => $em->getRepository('SSFMBBundle:Corde')->findOneByParc($parcs)));
                if ($crd) {
                    $cordefabriquer = array();
                    $cordefabriquerurgent = array();
                    foreach ($crd as $corde) {
                        if ($corde->getDateDeCreation()) {
                            $diff = date_diff($corde->getDateDeCreation(), $date1);
                            if ($diff->d < 1) {
                                $cordefabriquer = array_merge($cordefabriquer, array($corde));
                            } else {
                                $cordefabriquerurgent = array_merge($cordefabriquerurgent, array($corde));
                            }
                        }
                    }
                }

                $filiers = $em->getRepository('SSFMBBundle:Filiere')->findByParc($parcs);
                foreach ($filiers as $filiere) {
                    $segments = $em->getRepository('SSFMBBundle:Segment')->findByFiliere($filiere);
                    foreach ($segments as $segment) {
                        $flotteurs = $em->getRepository('SSFMBBundle:Flotteur')->findBySegment($segment);
                        foreach ($flotteurs as $flotteur) {
                            $emplacements = $em->getRepository('SSFMBBundle:Emplacement')->findByFlotteur($flotteur);
                            foreach ($emplacements as $emplacement) {
                                if ($emplacement->getDateDeRemplissage()) {
                                    $interval = date_diff($emplacement->getDateDeRemplissage(), $date1);
                                    if ($emplacement->getStockslanterne()) {
                                        if (($interval->m >= 3) || ($interval->y >= 1)) {
                                            $pregrossisementurgent = array_merge($pregrossisementurgent, array($emplacement));
                                        } elseif (($interval->m > 2) && ($interval->d > 23) && ($interval->m < 3)) {
                                            $pregrossisementaeffectuer = array_merge($pregrossisementaeffectuer, array($emplacement));
                                        } else {
                                            $pregrossisement = array_merge($pregrossisement, array($emplacement));
                                        }
                                    } elseif ($emplacement->getStockscorde()) {
                                        if (($interval->m >= 6) || ($interval->y >= 1)) {
                                            $grossisementurgent = array_merge($grossisementurgent, array($emplacement));
                                        } elseif (($interval->m > 5) && ($interval->d > 23) && ($interval->m < 6)) {
                                            $grossisementaeffectuer = array_merge($grossisementaeffectuer, array($emplacement));
                                        } else {
                                            $grossisement = array_merge($grossisement, array($emplacement));
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
        return $this->render('@SSFMB/Default/planingdetravaille.html.twig', array('entity' => $parcs, 'pregrossisement' => $pregrossisement, 'grossisement' => $grossisement, 'comerciale' => $comerciale, 'pregrossisementaeffectuer' => $pregrossisementaeffectuer, 'grossisementaeffectuer' => $grossisementaeffectuer, 'comercialeaeffectuer' => $comercialeaeffectuer, 'pregrossisementurgent' => $pregrossisementurgent, 'grossisementurgent' => $grossisementurgent, 'comercialeurgent' => $comercialeurgent));
    }
}
