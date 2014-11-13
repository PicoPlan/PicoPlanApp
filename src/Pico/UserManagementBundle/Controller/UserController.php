<?php

namespace Pico\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        
        $this->get('form.factory')->create(new UserType(), $user);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_view_by_id', array('id'=>$article->getId())));
        }
       

        return $this->render('UserManagementBundle:Default:inscription.html.twig');
    }
}
