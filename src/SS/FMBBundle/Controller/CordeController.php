<?php

namespace SS\FMBBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SS\FMBBundle\Entity\Corde;
use SS\FMBBundle\Form\CordeType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Corde controller.
 *
 */
class CordeController extends Controller
{
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


}
