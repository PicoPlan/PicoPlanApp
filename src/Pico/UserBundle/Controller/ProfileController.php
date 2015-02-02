<?php

namespace Pico\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController {

    public function getParent() {

        return 'FOSUserBundle';
    }

    public function editAction(Request $request) {

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


        return $this->render("PicoUserBundle:Profile:edit.html.twig", array(
            "form" => $form->createView()
        ));
    }
}