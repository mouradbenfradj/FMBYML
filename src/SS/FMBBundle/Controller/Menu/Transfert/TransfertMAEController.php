<?php

namespace SS\FMBBundle\Controller\Menu\Transfert;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class TransfertMAEController extends Controller
{

    public function transfertMAEAction(Request $request)
    {
        $session = new Session();
        //  var_dump($session->get('lanterne'));
        // var_dump($session->get('corde'));
        $em = $this->getDoctrine()->getManager();
        if ($request->get('idparc') == null) {
            $parcs = null;
            $stock = null;
            $cordes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
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
                        $anarticle->setDateDeRetraitTransfert($session->get('dateTransfertRetrait'));
                        $anarticle->setDateDeMAETransfert(new \DateTime($request->request->get('dateRemise')));
                        $cmpt++;

                    }
                }
            }
            $em->flush();
            return $this->redirectToRoute('ssfmb_transfert');
        }
        return $this->render(
            '@SSFMB/MAE/transfertMAE.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'cordes' => $cordes,
            )
        );
    }


}