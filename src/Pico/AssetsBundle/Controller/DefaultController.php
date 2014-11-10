<?php

namespace Pico\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PicoAssetsBundle:Default:index.html.twig', array(
            'username' => '',
            'title' => 'PicoPlan'
        ));
    }
}
