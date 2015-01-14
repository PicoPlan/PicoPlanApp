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

    public function confirmedAction() {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        var_dump('uech');

        return $this->render('::base.html.twig', array(
            'user' => $user,
        ));
    }
}

