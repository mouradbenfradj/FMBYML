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
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('suivit', array('route' => 'ssfmb_homepage'));
        $menu->addChild('preparer lanterne', array('route' => 'ssfmb_preparationlanterne'));
        $menu->addChild('preparer corde', array('route' => 'ssfmb_preparationcorde'));
        $menu->addChild('MAE lanterne', array('route' => 'ssfmb_misaaeaulanterne'));
        $menu->addChild('MAE corde', array('route' => 'ssfmb_misaaeaucorde'));
        $menu->addChild('Retrait lanterne', array('route' => 'ssfmb_retraitLanterne'));
        $menu->addChild('Retrait corde', array('route' => 'ssfmb_retraitcorde'));
        $menu->addChild('planing de travaille', array('route' => 'ssfmb_planingdetravaille'));
        $menu->addChild('Logout', array('route' => 'fos_user_security_logout'));
        return $menu;
    }

    public function parcHomeMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_homepage',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));

            }
        }
        return $menu;
    }

    public function parcMAELMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaulanterne',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));

            }
        }
        return $menu;
    }

    public function parcMAECMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_misaaeaucorde',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));

            }
        }
        return $menu;
    }

    public function parcRLMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        // findMostRecent and Blog are just imaginary examples
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitLanterne',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));
            }
        }
        return $menu;
    }

    public function parcRCMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_retraitcorde',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));
            }
        }
        return $menu;
    }
    public function parcPlaningMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        $parcs = $em->getRepository('SSFMBBundle:Magasins')->findAll();
        if ($parcs) {
            foreach ($parcs as $parc) {
                $menu->addChild($parc->getAbrevMagasin(), array(
                    'route' => 'ssfmb_planingdetravaille',
                    'routeParameters' => array('id' => $parc->getIdMagasin())
                ));
            }
        }
        return $menu;
    }
}