<?php

namespace Pico\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Controller\RegistrationController as FOSRegistrationController;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class RegistrationController extends FOSRegistrationController
{
    public function getParent() {
        return "FOSUserBundle";
    }

    public function registerAction(Request $request) {
        # Return the parent register action
        # So special stuff here

        $response = parent::registerAction($request);

        return $response;
    }
}