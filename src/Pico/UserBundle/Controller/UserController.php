<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function indexAction()
    {
        return $this->render('::base.html.twig', array(
       	'title' => 'PicoPlan'
        ));
    }
}
