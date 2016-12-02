<?php
/**
 * Created by PhpStorm.
 * User: Sniper
 * Date: 16/09/2016
 * Time: 17:06
 */

namespace SS\FMBBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navigation-menu');
        $menu->addChild('suivi filières');
        $menu->addChild('Préparation');
        $menu->addChild("Mise à l'eau");
        $menu->addChild('Retrait Transfert');
        $menu->addChild('Retrait AW');
        $menu->addChild('Traitement Comercial');
        $menu->addChild('planing de travaille');
        $menu->addChild('Processus');

        $menu['Préparation']->addChild('preparer lanterne', array('route' => 'ssfmb_preparationlanterne'));
        $menu['Préparation']->addChild('preparer corde', array('route' => 'ssfmb_preparationcorde'));
        $menu['Préparation']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu["Mise à l'eau"]->addChild('MAE lanterne');
        $menu["Mise à l'eau"]->addChild('MAE corde');
        $menu["Mise à l'eau"]->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Retrait AW']->addChild('Retrait lanterne');
        $menu['Retrait AW']->addChild('Retrait corde');
        $menu['Retrait AW']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        //   $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu['suivi filières']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_homepage',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['suivi filières']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

                $menu["Mise à l'eau"]['MAE lanterne']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaulanterne',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu["Mise à l'eau"]['MAE lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['Retrait AW']['Retrait lanterne']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitLanterne',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait AW']['Retrait lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu["Mise à l'eau"]['MAE corde']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaucorde',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu["Mise à l'eau"]['MAE corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['Retrait AW']['Retrait corde']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitcorde',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait AW']['Retrait corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['Traitement Comercial']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'traitementcomerciale',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Traitement Comercial']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['planing de travaille']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_planingdetravaille',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['planing de travaille']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['Processus']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_processusgrocissement',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Processus']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
                $menu['Retrait Transfert']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_transfert',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait Transfert']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

            }

        }
        /*
      */
        return $menu;
    }

    public function parcMAETransfertMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeautransfert',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
            }
        }
        return $menu;
    }
}