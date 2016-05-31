<?php

namespace SS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SSUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
