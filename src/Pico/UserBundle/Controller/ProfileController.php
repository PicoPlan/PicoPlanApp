<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController {

    public function getParent() {

        return 'FOSUserBundle';
    }

    public function showAction() {
        $user = $this->get('security.context')
            ->getToken()
            ->getUser();

        if($user){
            $data = array(
            'username' => array(
                'content' => $user->getUsername(),
                'title' => 'Pseudo',
                'icon' => 'glyphicon-star'),
            'last_name' => array(
                'content' => $user->getLastName(),
                'title' => 'Nom',
                'icon' => 'glyphicon-user'),
            'first_name' => array(
                'content' => $user->getFirstName(),
                'title' => 'Prénom',
                'icon' => 'glyphicon-user'),
            'email' => array(
                'content' => $user->getEmail(),
                'title' => 'Email',
                'icon' => 'glyphicon-envelope'),
            'phone' => array(
                'content' => $user->getPhone(),
                'title' => 'Téléphone',
                'icon' => 'glyphicon-phone'),
            );
        }
        else{
            $data = null;
        }


        return $this->render('PicoUserBundle:User:show.html.twig', array(
            'data' => $data,
        ));
    }

    public function editAction(Request $request) {
        # return parent edit action
        # no special stuff here
        $response = parent::editAction($request);
        return $response;
    }
}