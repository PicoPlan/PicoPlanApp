<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

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

            return $this->render('UserBundle:User:home.html.twig', $data);
        }
        else {
            $url = $this->generateUrl('fos_user_security_login');

            return $this->redirect($url, 301);
        }

    }
}

