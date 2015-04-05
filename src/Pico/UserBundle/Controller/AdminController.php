<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    // Usefull attributes
    private $user;

    private $em; // Entity manager

    public function __init()
    {
        // Current user
        if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->user = $this->get('security.context')
                ->getToken()
                ->getUser();
        } else {
            $this->user = false;
        }
        // Entity Manager
        $this->em = $this->getDoctrine()->getManager();
    }
    
    public function showToolboxIfAllowedAction()
    {
        $this->__init();
        if($this->em->getRepository("PicoUserBundle:User")->calculateUserRight($this->user)) {
            return $this->render('PicoUserBundle:Admin:adminToolBox.html.twig');
        } else {
            return new Response('');
        }
    }
}