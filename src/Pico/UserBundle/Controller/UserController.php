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
        /*
        * Say hello if user is logged
        */
        $user = $this->get('security.context')
            ->getToken()
            ->getUser();

        $data = array(
            'user' => $user,
            );

        // Get user profile picture
        $em = $this->getDoctrine()->getManager();
        $pictureList = $em
            ->getRepository("PicoUserBundle:ProfilePicture")
            ->findBy(array(
                "user" => $user,
                "isActive" => true));
        foreach ($pictureList as $pic) {
            $path = $pic->getPath();
        }
        if($pictureList){
            $session = $this->getRequest()->getSession();
            $session->set("profile_pic", $path);
        }

        // Get 10 latests articles
        $articleList = $em
            ->getRepository("PicoNewsBundle:Article")
            ->findBy(
                array(),
                array("date" => "desc"),
                10);
        foreach ($articleList as $article) {
            $list[$article->getId()] = array(
                "author" => $article->getAuthor(),
                "title" => $article->getTitle(),
                "content" => $article->getContent(),
                "date" => $article->getDate()->format("d-m-Y"),
                "id" => $article->getId()
            );
            if($list){
                $data["articles"] = $list;
            }
        }

        return $this->render('PicoUserBundle:User:home.html.twig', $data);
    }

    public function showAction($username) {
        if($username) {
            $usermanager = $this->get("fos_user.user_manager");
            $user = $usermanager->findUserByUsername($username);
        }
        else {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();
        }

        if($user == "anon.") {
            $response["alert_info"] = "Vous ne pouvez pas accéder à cette section sans identification.";
            $response["alert_class"] ="warning";
        }
        elseif(!$user) {
            $response["alert_info"] = "Cet utilisateur n'existe pas.";
            $response["alert_class"] = "danger";
        }
        else {
            $response["user"] = $user;
            $response["data"] = array(
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

        // Getting user profile picture
        $em = $this->getDoctrine()->getManager();
        $pictureList = $em
            ->getRepository("PicoUserBundle:ProfilePicture")
            ->findBy(array(
                "user" => $user,
                "isActive" => true));
        foreach($pictureList as $pic){
            $response["path"] = $pic->getPath();
            $response["alt"] = $user->getUsername()."'s profile picture";
        }

        return $this->render('PicoUserBundle:User:show.html.twig', $response);
    }

    public function showCalendarAction($type, $id) {
        return $this->render('PicoUserBundle:User:calendar.html.twig', array(
            'id' => $id,
        ));
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

    public function findAction(Request $request) {
        $username = $request->query->get("username");
        
        $url = $this->generateUrl("user_show", array("username" => $username));
        return $this->redirect($url);
    }

}

