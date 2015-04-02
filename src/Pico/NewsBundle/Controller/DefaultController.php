<?php

namespace Pico\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PicoNewsBundle:Default:index.html.twig', array('name' => $name));
    }
}
