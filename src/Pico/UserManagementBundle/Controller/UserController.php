<?php

namespace Pico\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($name = "Invité")
    {
        return $this->render('UserManagementBundle:Default:index.html.twig', array(
            'username' => $name,
            'title' => 'PicoPlan'
        ));
    }
}
