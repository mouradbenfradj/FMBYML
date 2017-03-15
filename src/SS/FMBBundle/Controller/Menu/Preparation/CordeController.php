<?php

namespace SS\FMBBundle\Controller\Menu\Preparation;

use SS\FMBBundle\Entity\DocsLines;
use SS\FMBBundle\Entity\Documents;
use SS\FMBBundle\Entity\StocksCordes;
use SS\FMBBundle\Form\PreparationCordeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CordeController extends Controller
{
    public function cordeHAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PreparationCordeType($em), null, array('action' => $this->generateUrl('ssfmb_preparationcorde'), 'method' => 'POST', 'attr' => array('class' => "form-horizontal")));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $stockarticles = $em->getRepository('SSFMBBundle:StocksArticles')->findOneBy(array('idStock' => $form['libStock']->getData()->getIdStock(), 'refArticle' => $form['refArticle']->getData()->getRefArticle()));
            if (!empty($stockarticles)) {
                $document = new Documents();
                $time = explode("/", $form['date']->getData());
                $document->setDateCreationDoc(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                $doclin = new DocsLines();
                $doclin->setRefDoc($document);
                $doclin->setQte($form['qte']->getData());
                $doclin->setLibArticle($form['refArticle']->getData()->getLibArticle());
                $doclin->setRefArticle($form['refArticle']->getData()->getRefArticle());
                $cordes = $request->request->get("ss_fmbbundle_preparationcorde")["nomCorde"];
                $corde = $em->getRepository("SSFMBBundle:Corde")->findOneBy(array('nomCorde' => $cordes, 'parc' => $form['Parc']->getData()));
                $doclin2 = new DocsLines();
                $doclin2->setRefDoc($document);
                $doclin2->setLibArticle($corde->getNomCorde());
                $doclin2->setQte($form['nombre']->getData());
                $doclin2->setRefDocLineParent($doclin);
                $doclin2->setRefArticle($corde->getId());
                $em->persist($document);
                $em->persist($doclin);
                $em->persist($doclin2);
                for ($j = 0; $j < $form['nombre']->getData(); $j++) {
                    $stocksarticlessn = $em->getRepository('SSFMBBundle:StocksArticlesSn')->findOneBy(array('refStockArticle' => $stockarticles, 'numeroSerie' => $request->request->get("ss_fmbbundle_preparationcorde")['numeroSerie']));
                    $stockscordes = new StocksCordes();
                    $stockscordes->setDateDeCreation(new \DateTime($time[2] . '-' . $time[1] . '-' . $time[0]));
                    $stockscordes->setArticle($stocksarticlessn);
                    $stockscordes->setCorde($corde);
                    $stockscordes->setDocLine($doclin);
                    $stockscordes->setQuantiter($doclin->getQte());
                    $stockscordes->setPret(false);
                    $stockarticles->setQte($stockarticles->getQte() - $form['qte']->getData());
                    $stocksarticlessn->setSnQte($stocksarticlessn->getSnQte() - $form['qte']->getData());
                    $em->persist($stockscordes);
                }
            } else {
                return $this->render('@SSFMB/Default/preparationCorde.html.twig', array('form' => $form->createView(),));
            }
            $corde->setNbrTotaleEnStock($corde->getNbrTotaleEnStock() - $form['nombre']->getData());
            $em->flush();
            return $this->redirectToRoute('ssfmb_homepage');
        }
        return $this->render('@SSFMB/Preparation/preparationCorde.html.twig', array('form' => $form->createView(),));
    }

}