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

    public function editAction(Request $request) {
        # return parent edit action
        # no special stuff here
        $response = parent::editAction($request);
        return $response;
    }
}