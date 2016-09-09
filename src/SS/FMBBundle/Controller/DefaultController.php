<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Articles;
use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\StocksArticles;
use SS\FMBBundle\Entity\StocksArticlesSn;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationCordeType;
use SS\FMBBundle\Form\PreparationLanterneType;
use SS\FMBBundle\Implementation\DefaultImpl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($request->get('id') == null)
            $parcs = null;
        else
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findByIdMagasin($request->get('id'));
        return $this->render('SSFMBBundle:Default:index.html.twig', array('entities' => $parcs, 'pages' => $page));
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
            $document->setCodeAffaire("");
            $document->setNomContact("");
            $document->setAdresseContact("");
            $document->setCodePostalContact("");
            $document->setVilleContact("");
            $document->setAppTarifs("");
            $document->setDescription("");
            $document->setDateCreationDoc(new \DateTime());
            $document->setCodeFile("");
            $em->persist($document);

            $lant = $form['nomLanterne']->getData();

            foreach ($form['document']['docsLines']->getData() as $doclin) {
                $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form->get('libStock')->getData()->getIdStock(), 'refArticle' => $doclin->getRefArticle()));
                if (!empty($stockarticles)) {
                    for ($j = 0; $j < $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['nombre']; $j++) {
                        $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['numeroSerie']));
                        $doclin->setRefDoc($document);
                        $doclin->setLibArticle($doclin->getRefArticle()->getLibArticle());
                        $doclin->setDescArticle("");
                        $doclin->setPuHt(0);
                        $doclin->setRemise(0);
                        $doclin->setTva(0);
                        $doclin->setOrdre(false);
                        $doclin->setVisible(false);
                        $doclin->setPaForced(false);

                        $stockslanternes = new StocksLanternes();
                        $stockslanternes->setDateDeCreation($form->getData('date')['date']);
                        $stockslanternes->setPret(false);
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
        $page = $em->getRepository('SSFMBBundle:Magasins')->findAll();
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
            return $this->redirectToRoute('ssfmb_homepage');
        }
        return $this->render(
            '@SSFMB/Default/miseAEauLanterne.html.twig',
            array(
                'entity' => $parcs,
                'pages' => $page,
                'articles' => $articles,
                'lanternes' => $lanternes,
            )
        );
    }

    public function retraitLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Magasins')->findAll();
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
                    var_dump($sarticlesn);
                    if (!$sarticlesn) {
                        $sarticlesn = new StocksArticlesSn($slanterne->getArticle()->getNumeroSerie(), $implementation->calculerQuantiterLanterne($slanterne), $sarticle);
                        $em->persist($sarticlesn);
                    } else {
                        $sarticlesn->setSnQte($sarticlesn->getSnQte() + $implementation->calculerQuantiterLanterne($slanterne));
                    }

                }

                $slanterne->setPret(true);
                $slanterne->getLanterne()->setNbrTotaleEnStock($slanterne->getLanterne()->getNbrTotaleEnStock() + 1);
                $slanterne->setEmplacement(null);
                $place->setStockslanterne(null);
                $place->setDateDeRemplissage(null);
            }

            $em->flush();

            return $this->redirectToRoute('ssfmb_homepage');
        }

        return $this->render('SSFMBBundle:Default:retraitLanterne.html.twig',
            array(
                'entity' => $parcs,
                'pages' => $page,
                'articles' => $articles,
            )
        );
    }

    public function preparationCordeAction(Request $request)
    {
        $form = $this->createForm(new PreparationCordeType(), null, array('action' => $this->generateUrl('ssfmb_preparationcorde'), 'method' => 'POST',));
        $form->add('submit', 'submit', array('label' => 'preparer'));
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            $document = $form['document']->getData();
            $em->persist($document);
            $i = 0;
            foreach ($form['document']['docsLines']->getData() as $doclin) {
                $result = $em->getRepository('SSFMBBundle:StocksArticles')->findBy(
                    array(
                        'idStock' => $form->get('stock')->getData()->getIdStock(),
                        'refArticle' => $doclin->getRefArticle(),
                    )
                );
                if (empty($result)) {
                    return $this->render(
                        '@SSFMB/Default/preparationCorde.html.twig',
                        array(
                            'form' => $form->createView(),
                        )
                    );
                }
                if (empty($result)) {
                    return $this->render(
                        '@SSFMB/Default/preparationCorde.html.twig',
                        array(
                            'form' => $form->createView(),
                        )
                    );
                }
                $stockarticles = $result[0];

                for ($j = 0; $j < $request->request->get(
                    "ss_fmbbundle_preparationcorde"
                )['document']['docsLines'][$i]['nombre']; $j++) {
                    $corde = new Corde();
                    $corde->setPret(false);
                    $corde->setDateDeCreation($form->getData('date')['date']);
                    $stockarticles->setQte($stockarticles->getQte() - $doclin->getQte());
                    $corde->setQuantiter($doclin->getQte());
                    $corde->setArticle($doclin->getRefArticle());
                    $em->persist($corde);

                }
                $i++;
            }
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

    public
    function miseAEauCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Magasins')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findByIdMagasin($request->get('id'));
            $articles = $em->getRepository('SSFMBBundle:Articles')->findAll();
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $cordearticle = $em->getRepository('SSFMBBundle:Corde')->findOneBy(
                    array(
                        'article' => $request->request->get('articlechoix'),
                        'emplacement' => null,
                        'quantiter' => $request->request->get('quantierchoix'),
                        'pret' => false,
                    )
                );
                $cordearticle->setEmplacement($place);
                $cordearticle->setPret(false);
                $place->setCorde($cordearticle);
                $place->setDateDeRemplissage(new \DateTime($request->request->get('dateMAECorde')));
                $em->flush();
            }

            return $this->redirectToRoute('ssfmb_homepage');
        }

        return $this->render(
            'SSFMBBundle:Default:miseAEauCorde.html.twig',
            array(
                'entities' => $parcs,
                'pages' => $page,
                'articles' => $articles,
            )
        );
    }

    public
    function retraitCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Magasins')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findByIdMagasin($request->get('id'));
            $articles = $em->getRepository('SSFMBBundle:Articles')->findAll();
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placecorde') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);

                $corde = $place->getCorde();
                $corde->setPret(true);
                $corde->setEmplacement(null);
                $place->setCorde(null);
                $place->setDateDeRemplissage(null);
                $em->flush();
            }

            return $this->redirectToRoute('ssfmb_homepage');
        }

        return $this->render(
            'SSFMBBundle:Default:retraitCorde.html.twig',
            array(
                'entities' => $parcs,
                'pages' => $page,
                'articles' => $articles,
            )
        );
    }
}
