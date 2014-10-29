<?php

namespace Pico\Library\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PicoLibraryAssetsBundle:Default:index.html.twig', array('name' => $name));
    }
}
