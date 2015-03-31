<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Pico\UserBundle\Entity\ProfilePicture;
use Pico\UserBundle\Form\Type\ProfilePictureFormType;



class ProfilePictureController extends Controller {

	# Usefull attributes
	private $user;
	private $em; # Entity Manager

	public function __init(){
		# Current user
		if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->user = $this->get('security.context')
                ->getToken()
                ->getUser();
        } else {
            $this->user = false;
        }
        # Entity Manager
        $this->em = $this->getDoctrine()->getManager();
	}

	public function updateAction(Request $request){
		# Instanciate user and user manager
		$this->__init();

		$picture = new ProfilePicture();

		if($this->user->getPermission() > 2){
			throw new AccessDeniedException("Cet utilisateur n'a pas accès à cette section");
		}

		$form = $this->createForm(new ProfilePictureFormType(), $picture);
		$form->handleRequest($request);
		$response["form"] = $form->createView();

		if($form->isValid()){
			$picture->setUser($this->user);
			$this->em->persist($picture);
			$response["alert_info"] = "Votre image a été uploadée.";
			$response["alert_class"] = "success";
		}

		return $this->render("PicoUserBundle:ProfilePicture:update.html.twig", $response);
	}
}
