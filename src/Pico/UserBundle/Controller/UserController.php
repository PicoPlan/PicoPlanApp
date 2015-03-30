<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller
{

    public function getParent(){
        return 'FOSUserBundle';
    }

    public function indexAction()
    {
        return $this->render('::base.html.twig', array(
       	'title' => 'PicoPlan'
        ));
    }

    public function confirmedAction() {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('::base.html.twig', array(
            'user' => $user,
        ));
    }

    public function homeAction() {
        if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();

            $data = array(
                'user' => $user,
                );

            return $this->render('PicoUserBundle:User:home.html.twig', $data);
        }
        else {
            $url = $this->generateUrl('fos_user_security_login');

            return $this->redirect($url, 301);
        }

    }

    public function showAction($username = null) {

        echo $username;

        if($username != null) {
            $usermanager = $this->get("fos_user.user_manager");
            $user = $usermanager->findUserByUsername($username);
        }
        else {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();
        }

        if(!$user) {
            $alert_info = "L'utilisateur recherché n'existe pas.";
            $alert_class ="warning";
        }
        else {
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


        /*
        * Adds wanted values in response array
        */
        $response = array();
        if($user) {
            $response["data"] = $data;
        }
        elseif(!$user) {
            $response["alert_info"] = $alert_info;
            $response["alert_class"] = $alert_class; 
        }


        return $this->render('PicoUserBundle:User:show.html.twig', $response);
    }

    public function editAction() {
        $user = $this->get('security.context')
            ->getToken()
            ->getUser();


        $formBuilder = $this->get("form.factory")->createBuilder("form", $user);

        $formBuilder
            ->add("last_name", "text")
            ->add("first_name", "text")
            ->add("email", "text")
            ->add("phone", "number");

        $form = $formBuilder->getForm();

        if(isset($request)){

        }

        // foreach($data as $key => $value) {
        //     if($key == "email") {
        //         $user->setEmail($value);
        //     }
        // }

        // $this->get('fos_user.user_manager')->updateUser($user);

        $alert_info = serialize($request);
        $alert_class = "success";
        $url = $this->generateUrl('user_show');
        return $this->render('UserBundle:User:edit.html.twig', array(
            'alert_info' => $alert_info,
            'alert_class' => $alert_class,
            "form" => $form->createView(),
            'user' => $user,
            ));
    }

}

