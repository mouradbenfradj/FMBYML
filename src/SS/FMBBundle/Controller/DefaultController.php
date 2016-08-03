<?php

namespace SS\FMBBundle\Controller;

use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Entity\Lanterne;
use SS\FMBBundle\Entity\Lot;
use SS\FMBBundle\Entity\Parc;
use SS\FMBBundle\Entity\Poche;
use SS\FMBBundle\Entity\StocksLanternes;
use SS\FMBBundle\Form\PreparationCordeType;
use SS\FMBBundle\Form\PreparationLanterneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        if (!$em->getRepository('SSFMBBundle:Lot')->find(date("Ymd"))) {
            $lotId = new Lot();
            $lotId->setLot(date("Ymd"));
            $em->persist($lotId);
            $em->flush();
        }
        $page = $em->getRepository('SSFMBBundle:Parc')->findAll();

        if ($request->get('id') == null) {
            $parcs = $page;
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

    public function preparationCordeAction(Request $request)
    {

        $form = $this->createForm(
            new PreparationCordeType(),
            null,
            array(
                'action' => $this->generateUrl('ssfmb_preparationcorde'),
                'method' => 'POST',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Create'));
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
                $stockarticles = $result[0];

                for ($j = 0; $j < $request->request->get(
                    "ss_fmbbundle_preparationcorde"
                )['document']['docsLines'][$i]['nombre']; $j++) {
                    $corde = new Corde();
                    $corde->setPret(false);
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

    public function preparationLanterneAction(Request $request)
    {
        $form = $this->createForm(
            new PreparationCordeType(),
            null,
            array(
                'action' => $this->generateUrl('ssfmb_preparationlanterne'),
                'method' => 'POST',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Create'));
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
                $stockarticles = $result[0];

                for ($j = 0; $j < $request->request->get(
                    "ss_fmbbundle_preparationlanterne"
                )['document']['docsLines'][$i]['nombre']; $j++) {
                    $stockslanternes = new StocksLanternes();
                    $stockslanternes->setPret(false);
                    $stockarticles->setQte($stockarticles->getQte() - $doclin->getQte());
                    for ($i = 1; $i < ($stockslanternes->getLanterne()->getNbrpoche() + 1); $i++) {
                        $poche = new Poche();
                        $poche->setEmplacement($i);
                        $poche->setQuantite($doclin->getQte() / $stockslanternes->getLanterne()->getNbrpoche());
                        $stockslanternes->addPoch($poche);
                    }
                    $stockslanternes->setArticle($doclin->getRefArticle());
                    $em->persist($stockslanternes);
                }
                $i++;
            }
            $em->flush();

            return $this->redirectToRoute('ssfmb_homepage');
        }

        $form = $this->createForm(
            new PreparationLanterneType(),
            null,
            array(
                'action' => $this->generateUrl('ssfmb_preparationlanterne'),
                'method' => 'POST',
            )
        );
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $this->render(
            '@SSFMB/Default/preparationLanterne.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function parcStocksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stocks = $em->getRepository('SSFMBBundle:Stocks')->findByRefAdrStock($request->get('id'));
        $response = new JsonResponse();

        return $response->setData(array('stocks' => $stocks));
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
                $place->setDateDeRemplissage(new \DateTime());
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

    public function miseAEauLanterneAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parcs = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            '@SSFMB/Default/miseAEauLanterne.html.twig',
            array(
                'entities' => $parcs,
            )
        );
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

    public
    function retraitLanterneAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parcs = $em->getRepository('SSFMBBundle:Parc')->findAll();

        return $this->render(
            '@SSFMB/Default/retraitLanterne.html.twig',
            array(
                'entities' => $parcs,
            )
        );
    }
}
