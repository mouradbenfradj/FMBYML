<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\Lanterne;
use SS\FMBBundle\Entity\Parc;
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
        $defaultmetier = new DefaultImpl($em);
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();
        if ($request->get('id') == null) {
            $parcs = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Parc')->findById($request->get('id'));
        }
        return $this->render(
            'SSFMBBundle:Default:index.html.twig',
            array(
                'entities' => $parcs,
                'pages' => $page,
            )
        );
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
            $em->persist($document);
            var_dump("test1");
            $lant = $em->getRepository('SSFMBBundle:Lanterne')->find($form->get('nomLanterne')->getData());

            foreach ($form['document']['docsLines']->getData() as $doclin) {
                $result = $em->getRepository('SSFMBBundle:StocksArticles')->findBy(array('idStock' => $form->get('libStock')->getData()->getIdStock(), 'refArticle' => $doclin->getRefArticle(),));
                if (!empty($result)) {
                    $stockarticles = $result[0];
                    for ($j = 0; $j < $request->request->get("ss_fmbbundle_preparationlanterne")['document']['docsLines'][0]['nombre']; $j++) {
                        $stockslanternes = new StocksLanternes();
                        $stockslanternes->setDateDeCreation($form->getData('date')['date']);
                        $stockslanternes->setPret(false);
                        $stockslanternes->setLanterne($lant);
                        $stockslanternes->setDocLine($doclin);
                        $stockarticles->setQte($stockarticles->getQte() - $doclin->getQte());
                        $qtedocs = $doclin->getQte();
                        for ($i = 1; $i < ($stockslanternes->getLanterne()->getNbrpoche() + 1); $i++) {
                            $stockslanternes->addPoch($defaultmetier->remplirPoche($i, $qtedocs, $stockslanternes->getLanterne()->getNbrpoche()));
                        }
                        $em->persist($stockslanternes);
                        $stockslanternes->setArticle($doclin->getRefArticle());
                    }
                } else {
                    return $this->render('@SSFMB/Default/preparationLanterne.html.twig', array('form' => $form->createView(),));
                }
            }
            $em->flush();
            return $this->redirectToRoute('ssfmb_homepage');
        }
        return $this->render('@SSFMB/Default/preparationLanterne.html.twig', array('form' => $form->createView()));
    }

    public function miseAEauLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $lanternes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Parc')->findById($request->get('id'));
            $lanternes = $em->getRepository('SSFMBBundle:Lanterne')->findByParc($parcs);
            $articles = $em->getRepository('SSFMBBundle:Articles')->findAll();
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placelanterne') as $emplacementlanterne) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementlanterne);
                $lanterne = $em->getRepository('SSFMBBundle:Lanterne')->find($request->request->get('lanternechoix'));
                $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(array('article' => $request->request->get('articlechoix'), 'emplacement' => null, 'lanterne' => $lanterne, 'pret' => false,));
                $trouve = false;
                foreach ($lanternearticle as $la) {
                    if (($this->calculerQuantiterLanterne($la) == $request->request->get('quantierchoix')) && !$trouve) {

                        $la->setEmplacement($place);
                        $la->setPret(false);
                        $place->setStocksLanterne($la);
                        $place->setDateDeRemplissage(new \DateTime($request->request->get('dateMAELanterne')));
                        $em->flush();
                        $trouve = true;
                    }
                }
            }
            return $this->redirectToRoute('ssfmb_homepage');
        }
        return $this->render(
            '@SSFMB/Default/miseAEauLanterne.html.twig',
            array(
                'entities' => $parcs,
                'pages' => $page,
                'articles' => $articles,
                'lanternes' => $lanternes,
            )
        );
    }

    public function retraitLanterneAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Parc')->findById($request->get('id'));
            $articles = $em->getRepository('SSFMBBundle:Articles')->findAll();
        }
        if ($request->isMethod('POST')) {
            foreach ($request->request->get('placelanterne') as $emplacementcorde) {
                $place = $em->getRepository('SSFMBBundle:Emplacement')->find($emplacementcorde);
                $slanterne = $place->getStockslanterne();
                $slanterne->setPret(true);
                $slanterne->setEmplacement(null);
                $place->setStockslanterne(null);
                $place->setDateDeRemplissage(null);
                $em->flush();
            }
            return $this->redirectToRoute('ssfmb_homepage');
        }

        return $this->render('SSFMBBundle:Default:retraitLanterne.html.twig', array('entities' => $parcs, 'pages' => $page, 'articles' => $articles,));
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

    public function parcStocksAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Stocks');
        $stocks = $repo->findByRefAdrStock($id, array('refAdrStock' => 'asc'));
        foreach ($stocks as $stock) {
            $result[$stock->getLibStock()] = $stock->getIdStock();
        }
        return new JsonResponse($result);
    }


    public function parcLanternesAction(Request $request)
    {// Get the province ID
        $id = $request->query->get('parc_id');
        $result = array();
        // Return a list of cities, based on the selected province
        $repo = $this->getDoctrine()->getManager()->getRepository('SSFMBBundle:Lanterne');
        $lanternes = $repo->findByParc($id, array('parc' => 'asc'));
        foreach ($lanternes as $lanterne) {
            $result[$lanterne->getNomLanterne()] = $lanterne->getNomLanterne();
        }
        return new JsonResponse($result);
    }

    public function cordeArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cordearticle = $em->getRepository('SSFMBBundle:Corde')->findBy(
            array('article' => $request->get('ida'), 'emplacement' => null, 'pret' => false)
        );
        count($cordearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        foreach ($cordearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if (!in_array($e->getQuantiter(), $tabtest)) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = count($cordearticle);
                $tabEnsembles[$i]['qte'] = $e->getQuantiter();
                $tabtest[] = $e->getQuantiter();
            }
            $i++;

        }

        $response = new Response();

        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json

        $response->headers->set('Content-Type', 'miseaeaucorde/json');
        $response->setContent($data);

        return $response;

    }

    public function miseAEauCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Parc')->findById($request->get('id'));
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

    public function lanterneArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(
            array(
                'article' => $request->get('ida'),
                'emplacement' => null,
                'pret' => false,
                'lanterne' => $request->get('idl'),
            )
        );
        count($lanternearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        foreach ($lanternearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if (!in_array($this->calculerQuantiterLanterne($e), $tabtest)) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = count($lanternearticle);
                $tabEnsembles[$i]['qte'] = $this->calculerQuantiterLanterne($e);
                $tabtest[] = $this->calculerQuantiterLanterne($e);
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaulanterne/json');
        $response->setContent($data);

        return $response;

    }

    public function nombreLanterneArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $lanternearticle = $em->getRepository('SSFMBBundle:StocksLanternes')->findBy(
            array(
                'article' => $request->get('ida'),
                'emplacement' => null,
                'pret' => false,
                'lanterne' => $request->get('idl'),
            )
        );
        count($lanternearticle);
        $tabEnsembles = array();
        $tabtest = array();
        $i = 0;
        $tt = 1;
        foreach ($lanternearticle as $e) { // transformer la réponse de la requete en tableau qui remplira le select pour ensembles
            if ($this->calculerQuantiterLanterne($e) == $request->get('qtech')) {
                $tabEnsembles[$i]['id'] = $e->getId();
                $tabEnsembles[$i]['nombre'] = $tt;
                $tabEnsembles[$i]['qte'] = $this->calculerQuantiterLanterne($e);
                $tabtest[] = $this->calculerQuantiterLanterne($e);
                $tt++;
            }
            $i++;
        }
        $response = new Response();
        $data = json_encode($tabEnsembles); // formater le résultat de la requête en json
        $response->headers->set('Content-Type', 'miseaeaulanterne/json');
        $response->setContent($data);

        return $response;

    }

    public function calculerQuantiterLanterne($tableauPoches)
    {
        $somme = 0;
        foreach ($tableauPoches->getPoches() as $poches) {
            $somme = $somme + $poches->getQuantite();
        }

        if ($somme != 0) {
            return $somme;
        }
    }


    public function retraitCordeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();

        if ($request->get('id') == null) {
            $parcs = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Parc')->findById($request->get('id'));
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
