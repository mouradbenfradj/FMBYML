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
        $menu->addChild('Suivi filières');
        $menu->addChild('Préparation');
        $menu->addChild("Mise à l'eau");
        $menu->addChild('Cordes a Chausser');
        $menu->addChild('Retrait Transfert');
        $menu->addChild('Retrait AW');
        $menu->addChild('Traitement Comercial');
        $menu->addChild('planing de travaille');
        $menu->addChild('Processus');

        $menu['Suivi filières']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Préparation']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Préparation']->addChild('Huitre');
        $menu["Préparation"]['Huitre']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Préparation']->addChild('Moule');
        $menu["Préparation"]['Moule']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Préparation']['Huitre']->addChild('Lanterne NH', array('route' => 'ssfmb_preparationlanterne'));
        $menu['Préparation']['Huitre']->addChild('Corde H', array('route' => 'ssfmb_preparationcorde'));
        $menu['Préparation']['Huitre']->addChild('Poche H', array('route' => ''));
        $menu['Préparation']['Moule']->addChild('Corde NM', array('route' => ''));
        $menu['Préparation']['Moule']->addChild('Corde M', array('route' => ''));
        $menu['Préparation']['Moule']->addChild('Poche M', array('route' => ''));

        $menu["Mise à l'eau"]->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu["Mise à l'eau"]->addChild('MAE lanterne');
        $menu["Mise à l'eau"]['MAE lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu["Mise à l'eau"]->addChild('MAE corde');
        $menu["Mise à l'eau"]['MAE corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu["Mise à l'eau"]->addChild('MAE Poche');
        $menu["Mise à l'eau"]['MAE Poche']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu["Cordes a Chausser"]->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Retrait AW']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');
        $menu['Retrait AW']->addChild('Retrait lanterne');
        $menu['Retrait AW']['Retrait lanterne']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Retrait AW']->addChild('Retrait corde');
        $menu['Retrait AW']['Retrait corde']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Retrait AW']->addChild('Retrait Poche');
        $menu['Retrait AW']['Retrait Poche']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Traitement Comercial']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['planing de travaille']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Processus']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        $menu['Retrait Transfert']->setAttribute('class', 'has-submenu')->setUri("#")->setChildrenAttribute('class', 'submenu');

        //   $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu['Suivi filières']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_homepage',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));

                $menu['Cordes a Chausser']->addChild($parc->getAbrevMagasin(), array(
                    'route' => '',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));

                $menu["Mise à l'eau"]['MAE lanterne']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaulanterne',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));


                $menu['Retrait AW']['Retrait lanterne']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitLanterne',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu["Mise à l'eau"]['MAE corde']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaucorde',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));

                $menu["Mise à l'eau"]['MAE Poche']->addChild($parc->getAbrevMagasin(), array(
                    'route' => '',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait AW']['Retrait corde']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitcorde',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait AW']['Retrait Poche']->addChild($parc->getAbrevMagasin(), array(
                    'route' => '',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Traitement Comercial']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'traitementcomerciale',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['planing de travaille']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_planingdetravaille',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Processus']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_processusgrocissement',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));
                $menu['Retrait Transfert']->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_transfert',
                    'routeParameters' => array('idparc' => $parc->getIdMagasin())
                ));

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