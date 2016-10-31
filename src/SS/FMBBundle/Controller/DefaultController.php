<?php

namespace SS\FMBBundle\Controller;

use DateTime;
use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\Corde;
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
                $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("CORDE HUITRES");
                if (!$article) {
                    $article = new Articles();
                    $article->setLibArticle("CORDE HUITRES");
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
        $form = $this->createForm(new PreparationCordeType($em), null, array('action' => $this->generateUrl('ssfmb_preparationcorde'), 'method' => 'POST'));
        $form->add('submit', 'submit', array('label' => 'preparer'));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $document = $form['document']->getData();
            $document->setDateCreationDoc(new \DateTime());
            $document->setCodeFile("");
            $em->persist($document);
            $cordes = $request->request->get("ss_fmbbundle_preparationcorde")["nomCorde"];
            $corde = $em->getRepository("SSFMBBundle:Corde")->findOneBy(array('nomCorde' => $cordes, 'parc' => $form['Parc']->getData()));
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
            $date1 = new DateTime("now");
            $stock = $em->getRepository('SSFMBBundle:Stocks')->find($request->request->get('stockchoix'));
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $interval = date_diff($place->getDateDeRemplissage(), $date1);
                $scorde = $place->getStockscorde();
                if ($interval->m <= 5)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES G" . $interval->m . " COM");
                elseif ($interval->m == 6)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H3 COM");
                elseif ($interval->m == 7)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H2 COM");
                elseif ($interval->m == 8)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H1 COM");
                elseif ($interval->m == 9)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H0 COM");
                elseif ($interval->m == 10)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H00 COM");
                elseif ($interval->m == 11)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H000 COM");
                elseif ($interval->m >= 12)
                    $article = $em->getRepository('SSFMBBundle:Articles')->findOneByLibArticle("HUITRES H0000 COM");
                if (!$article) {
                    $article = new Articles();
                    if ($interval->m <= 5)
                        $article->setLibArticle("HUITRES G" . $interval->m . " COM");
                    elseif ($interval->m == 6)
                        $article->setLibArticle("HUITRES H3 COM");
                    elseif ($interval->m == 7)
                        $article->setLibArticle("HUITRES H2 COM");
                    elseif ($interval->m == 8)
                        $article->setLibArticle("HUITRES H1 COM");
                    elseif ($interval->m == 9)
                        $article->setLibArticle("HUITRES H0 COM");
                    elseif ($interval->m == 10)
                        $article->setLibArticle("HUITRES H00 COM");
                    elseif ($interval->m == 11)
                        $article->setLibArticle("HUITRES H000 COM");
                    elseif ($interval->m >= 12)
                        $article->setLibArticle("HUITRES H0000 COM");
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
                    $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    if (!$sarticlesn && !$sarticlesn1) {
                        $sarticlesn1 = new StocksArticlesSn($scorde->getArticle()->getNumeroSerie(), 0, $sarticle);
                        $sarticlesn = new StocksArticlesSnVirtuel($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                        $em->persist($sarticlesn1);
                        $em->persist($sarticlesn);
                        $scorde->setArticle($sarticlesn1);
                        $em->flush();
                    }
                } else {
                    $sarticle->setQte($sarticle->getQte() + $scorde->getQuantiter());
                    $sarticlesn1 = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    $sarticlesn = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($sarticle->getRefStockArticle(), $scorde->getArticle()->getNumeroSerie());
                    if (!$sarticlesn && !$sarticlesn1) {
                        $sarticlesn1 = new StocksArticlesSn($scorde->getArticle()->getNumeroSerie(), 0, $sarticle);
                        $sarticlesn = new StocksArticlesSnVirtuel($scorde->getArticle()->getNumeroSerie(), $scorde->getQuantiter(), $sarticle);
                        $scorde->setArticle($sarticlesn1);
                        $em->persist($sarticlesn1);
                        $em->persist($sarticlesn);
                        $em->flush();
                    } else {
                        $sarticlesn1->setSnQte($sarticlesn1->getSnQte() + 0);
                        $sarticlesn->setSnQte($sarticlesn->getSnQte() + $scorde->getQuantiter());
                        $scorde->setArticle($sarticlesn1);
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

    public function quantiterEnStocksSnActuelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stocksArticlesSn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($request->get('stocks'), $request->get('lot'));
        return $this->render('SSFMBBundle:Render:quantiterEnStocksArticlesSnRender.html.twig', array(
            'stocksArticlesSn' => $stocksArticlesSn->getSnQte()));
    }

    public
    function traitementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('id') == null) {
            $parcs = null;
            $stocksnvirtuel = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            $stocksnvirtuel = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->findByRefStockArticle($em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock()));
            $articles = $em->getRepository('SSFMBBundle:StocksArticles')->findByIdStock($parcs->getIdStock());
        }
        if ($request->isMethod('POST')) {
            $i = 0;
            $stocksnvirtuelt = "";
            $stocksArticlesSnt = "";
            foreach ($request->get('tab') as $item) {
                switch ($i) {
                    case 0:
                        $stocks = $item;
                        $i++;
                        break;
                    case 1:
                        $stocksnvirtuelt = $em->getRepository('SSFMBBundle:StocksArticlesSnVirtuel')->getSAS($stocks, $item);
                        $stocksArticlesSnt = $em->getRepository('SSFMBBundle:StocksArticlesSn')->getSAS($stocks, $item);
                        $i++;
                        break;
                    case 2:
                        $stocksnvirtuelt->setSnQteTraiterValide($stocksnvirtuelt->getSnQteTraiterValide() + $item);
                        $i++;
                        break;
                    case 3:
                        $stocksnvirtuelt->setSnQteMiseEnVente($stocksnvirtuelt->getSnQteMiseEnVente() + $item);
                        $stocksArticlesSnt->setSnQte($stocksArticlesSnt->getSnQte() + $item);
                        $i++;
                        break;
                    case 4:
                        $stocksnvirtuelt->setSnQteARemettreEnPoche($stocksnvirtuelt->getSnQteARemettreEnPoche() + $item);
                        $i++;
                        break;
                    case 5:
                        $stocksnvirtuelt->setSnQteMorte($stocksnvirtuelt->getSnQteMorte() + $item);
                        $i++;
                        break;
                    case 6:
                        $stocksnvirtuelt->setSnQtePerdu($stocksnvirtuelt->getSnQtePerdu() + $item);
                        $i = 0;
                        $em->flush();
                        break;
                }
                //  $stocksnvirtuel->setsnQteMorte($item);
            }
            return $this->redirectToRoute('traitementcomerciale');


        }
        return $this->render('@SSFMB/Default/traitementcomerciale.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'stocksnvirtuel' => $stocksnvirtuel
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
        if ($request->get('id') == null) {
            $parcs = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
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
                                        } elseif (($interval->m == 2) && ($interval->d <= 7) && ($interval->m < 3)) {
                                            $pregrossisementaeffectuer = array_merge($pregrossisementaeffectuer, array($emplacement));
                                        } else {
                                            $pregrossisement = array_merge($pregrossisement, array($emplacement));
                                        }
                                    } elseif ($emplacement->getStockscorde() && !$filiere->getAireDeTravaille()) {
                                        if (($interval->m >= 6) || ($interval->y >= 1)) {
                                            $grossisementurgent = array_merge($grossisementurgent, array($emplacement));
                                        } elseif (($interval->m == 5) && ($interval->d >= 23) && ($interval->m < 6)) {
                                            $grossisementaeffectuer = array_merge($grossisementaeffectuer, array($emplacement));
                                        } else {
                                            $grossisement = array_merge($grossisement, array($emplacement));
                                        }
                                    } elseif ($emplacement->getStockscorde() && $filiere->getAireDeTravaille()) {
                                        if ($interval->m < 7) {
                                            $grossisementAW = array_merge($grossisementAW, array($emplacement));
                                        } elseif (($interval->m >= 7) && ($interval->m < 8)) {
                                            $grossisementaeffectuerAW = array_merge($grossisementaeffectuerAW, array($emplacement));
                                        } else {
                                            $grossisementurgentAW = array_merge($grossisementurgentAW, array($emplacement));
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
        return $this->render('@SSFMB/Default/planingdetravaille.html.twig', array('laf' => $lanternefabriquer, 'lafu' => $lanternefabriquerurgent, 'caf' => $cordefabriquer, 'cafu' => $cordefabriquerurgent, 'entity' => $parcs, 'pregrossisement' => $pregrossisement, 'grossisement' => $grossisement, 'grossisementAW' => $grossisementAW, 'comerciale' => $comerciale, 'pregrossisementaeffectuer' => $pregrossisementaeffectuer, 'grossisementaeffectuer' => $grossisementaeffectuer, 'grossisementaeffectuerAW' => $grossisementaeffectuerAW, 'comercialeaeffectuer' => $comercialeaeffectuer, 'pregrossisementurgent' => $pregrossisementurgent, 'grossisementurgent' => $grossisementurgent, 'grossisementurgentAW' => $grossisementurgentAW, 'comercialeurgent' => $comercialeurgent));
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
        if ($request->get('id') == null) {
            $parcs = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('id'));
            if ($parcs) {
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
                                        if ($interval->y == 0) {
                                            switch ($interval->m) {
                                                case 0 :
                                                    $pg[0] = array_merge($pg[0], array($emplacement));
                                                    break;
                                                case 1 :
                                                    $pg[1] = array_merge($pg[1], array($emplacement));
                                                    break;
                                                case 2 :
                                                    $pg[2] = array_merge($pg[2], array($emplacement));
                                                    break;
                                                case 3 :
                                                    $pg[3] = array_merge($pg[3], array($emplacement));
                                                    break;
                                                default :
                                                    $pg[4] = array_merge($pg[4], array($emplacement));
                                                    break;
                                            }
                                        } else {
                                            $pg[4] = array_merge($pg[4], array($emplacement));
                                        }
                                    } elseif ($emplacement->getStockscorde()) {
                                        if ($interval->y == 0) {
                                            switch ($interval->m) {
                                                case 0 :
                                                    $gr[0] = array_merge($gr[0], array($emplacement));
                                                    break;
                                                case 1 :
                                                    $gr[1] = array_merge($gr[1], array($emplacement));
                                                    break;
                                                case 2 :
                                                    $gr[2] = array_merge($gr[2], array($emplacement));
                                                    break;
                                                case 3 :
                                                    $gr[3] = array_merge($gr[3], array($emplacement));
                                                    break;
                                                case 4 :
                                                    $gr[4] = array_merge($gr[4], array($emplacement));
                                                    break;
                                                case 5 :
                                                    $gr[5] = array_merge($gr[5], array($emplacement));
                                                    break;
                                                case 6 :
                                                    $gr[6] = array_merge($gr[6], array($emplacement));
                                                    break;
                                                case 7 :
                                                    $gr[7] = array_merge($gr[7], array($emplacement));
                                                    break;
                                                case 8 :
                                                    $gr[8] = array_merge($gr[8], array($emplacement));
                                                    break;
                                                case 9 :
                                                    $gr[9] = array_merge($gr[9], array($emplacement));
                                                    break;
                                                case 10 :
                                                    $gr[10] = array_merge($gr[10], array($emplacement));
                                                    break;
                                                default :
                                                    $gr[11] = array_merge($gr[11], array($emplacement));
                                                    break;
                                            }
                                        } else {
                                            $gr[11] = array_merge($gr[11], array($emplacement));
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
        return $this->render('@SSFMB/Default/processusgrocissement.html.twig', array('cr' => $cr, 'pg' => $pg, 'gr' => $gr, 'entity' => $parcs));
    }

    public function transfertAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

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
            $session = new Session();
            $session->set('emplacement', array());
            $session->set('lanterne', array());
            $session->set('corde', array());
            foreach ($request->request->get('place') as $emplacement) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacement);

                $session->set('dateTransfertRetrait', new \DateTime($request->request->get('dateRetrait')));
                $session->set('emplacement', array_merge($session->get('emplacement'), array($place)));
                if ($place->getStockscorde() != null) {
                    $session->set('corde', array_merge($session->get('corde'), array($place->getStockscorde())));
                } elseif ($place->getStockslanterne() != null) {
                    $session->set('lanterne', array_merge($session->get('lanterne'), array($place->getStockslanterne())));
                }
            }
            return $this->redirectToRoute('ssfmb_misaaeautransfert');
        }
        return $this->render(
            '@SSFMB/Default/transfertRetirement.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'lanternes' => $lanternes,
            )
        );
    }

    public
    function transfertMAEAction(Request $request)
    {
        $session = new Session();
        //  var_dump($session->get('lanterne'));
        // var_dump($session->get('corde'));
        $em = $this->getDoctrine()->getManager();
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
            $cmpt = 0;
            foreach ($request->request->get('place') as $emplacement) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacement);
                if ($cmpt < count($session->get('emplacement'))) {
                    if ($session->get('emplacement')[$cmpt]->getStockscorde() != null) {
                        $anarticle = $em->getRepository('SSFMBBundle:StocksCordes')->find($session->get('emplacement')[$cmpt]->getStockscorde());
                        $anplace = $em->getRepository('SSFMBBundle:Emplacement')->find($session->get('emplacement')[$cmpt]);
                        $anarticle->setEmplacement(null);
                        $anplace->setStockscorde(null);
                        $place->setDateDeRemplissage($anplace->getDateDeRemplissage());
                        $anplace->setDateDeRemplissage(null);
                        $em->flush();
                        $place->setStockscorde($anarticle);
                        $anarticle->setEmplacement($place);
                        $anarticle->setDateDeRetraitTransfert($session->get('dateTransfertRetrait'));
                        $anarticle->setDateDeMAETransfert(new \DateTime($request->request->get('dateRemise')));
                        $cmpt++;

                    } else if (($session->get('emplacement')[$cmpt]->getStockslanterne() != null) && ($cmpt < count($session->get('emplacement')))) {
                        $anarticle = $em->getRepository('SSFMBBundle:StocksLanternes')->find($session->get('emplacement')[$cmpt]->getStockslanterne());
                        $anplace = $em->getRepository('SSFMBBundle:Emplacement')->find($session->get('emplacement')[$cmpt]);
                        $anplace->setStockslanterne(null);
                        $anarticle->setEmplacement(null);
                        $place->setDateDeRemplissage($anplace->getDateDeRemplissage());
                        $anplace->setDateDeRemplissage(null);
                        $em->flush();
                        $place->setStockslanterne($anarticle);
                        $anarticle->setEmplacement($place);
                        $cmpt++;

                    }
                }
            }
            $em->flush();
            return $this->redirectToRoute('ssfmb_transfert');
        }
        return $this->render(
            '@SSFMB/Default/transfertMAE.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'cordes' => $cordes,
            )
        );
    }

}
