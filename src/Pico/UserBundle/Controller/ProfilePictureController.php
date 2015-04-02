<?php

namespace Pico\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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

		// Updates active ProfilePicture
		$toActive = $request->get("set_active");
		if($toActive){
			$pic = $this->em
				->getRepository("PicoUserBundle:ProfilePicture")
				->findBy(array("path" => $toActive));
			$pic[0]->setIsActive(true);
			$this->em->persist($pic[0]);
			$this->em->flush();
		}

		// Erase picture if needed
		$toErase = $request->get("delete_picture");
		if($toErase){
			$pic = $this->em
				->getRepository("PicoUserBundle:ProfilePicture")
				->findBy(array("path" => $toErase));
			foreach($pic as $item){
				$this->em->remove($item);
			}
			$this->em->flush();
		}

		$form = $this->createForm(new ProfilePictureFormType(), $picture);
		$form->handleRequest($request);
		$response["form"] = $form->createView();

		if($form->isValid()){
			# Get the extension of the file if exists
			if($form["picture"]->getData() != null){
				$extension = $form["picture"]->getData()->guessExtension();
				if(!$extension){
				 	$extension = "bin";
				}
				# Randomly name the file to prevent injection
				$fileName = $this->user->getId()."_".rand(1, 99999).".".$extension;
				$picture->upload($fileName);
				$picture->setUser($this->user);
				$this->em->persist($picture);
				$this->em->flush();
				$response["alert_info"] = "Votre image a été uploadée.";
				$response["alert_class"] = "success";
			}
		}

		// Getting all current user's pictures 
		$pictureList = $this->em
			->getRepository("PicoUserBundle:ProfilePicture")
			->findBy(array("user" => $this->user));
		$list = [];
		foreach ($pictureList as $pic) {
			$list[$pic->getId()] = array(
				"name" => $pic->getPath(),
				"absolute_path" => $pic->getAbsolutePath(),
				"is_active" => $pic->getIsActive()
			);
		}
		if($pictureList){
			$response["pictures"] = $list;
		}

		return $this->render("PicoUserBundle:ProfilePicture:update.html.twig", $response);
	}
}
