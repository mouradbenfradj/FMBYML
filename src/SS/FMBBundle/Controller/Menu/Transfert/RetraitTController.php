<?php


namespace SS\FMBBundle\Controller\Menu\Transfert;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RetraitTController extends Controller
{
    public function transfertAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->get('idparc') == null) {
            $parcs = null;
            $stock = null;
            $lanternes = null;
            $articles = null;
        } else {
            $parcs = $em->getRepository('SSFMBBundle:Magasins')->findOneByIdMagasin($request->get('idparc'));
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
            '@SSFMB/Retrait/transfertRetirement.html.twig',
            array(
                'entity' => $parcs,
                'articles' => $articles,
                'lanternes' => $lanternes,
            )
        );
    }
}