<?php

namespace Pico\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pico\UserManagementBundle\Entity\User;
use Pico\UserManagementBundle\Form\UserType;

class UserController extends Controller
{
    public function indexAction($name = "Invité")
    {
        return $this->render('UserManagementBundle:Default:index.html.twig', array(
            'username' => $name,
            'title' => 'PicoPlan'
        ));
    }
    public function inscriptionAction(Request $request)
    {
        $user = new User();
        
        $form = $this->get('form.factory')->create(new UserType(), $user);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        #    return $this->redirect($this->generateUrl('########', array('id'=>$\\\\\->getId())));
        }
       
        return $this->render('UserManagementBundle:Default:inscription.html.twig', array(
            'username' => 'Inscription',
            'title' => 'PicoPlan'
        ));
    }
}
