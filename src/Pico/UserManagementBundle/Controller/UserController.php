<?php

namespace Pico\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserManagementBundle:Default:index.html.twig');
    }
}
