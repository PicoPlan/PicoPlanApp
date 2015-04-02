<?php
namespace Pico\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Pico\LeagueBundle\Entity\Club;
use Pico\LeagueBundle\Entity\Equipe;
use Pico\LeagueBundle\Entity\League;
use Pico\LeagueBundle\Entity\Sport;
use Pico\LeagueBundle\Entity\UserToEquipe;

use Pico\LeagueBundle\Form\Type\SportType;



class SportController extends Controller {

	# Usefull attributes
	private $user;
	private $em;

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


	public function createAction(Request $request) {
		# Instanciate user and user manager
		$this->__init();

		$sport = new Sport();

		if($this->user->getPermission() > 2){
			throw new AccessDeniedException("Cet utilisateur n'a pas accès à cette section");
		}

		$form = $this->createForm(new SportType(), $sport); 
		$form->handleRequest($request);
		$response["form"] = $form->createView();

		if($form->isValid()){
			$this->em->persist($sport);
			$this->em->flush();
			$response["alert_info"] = "Votre sport a bien été enregistré.";
			$response["alert_class"] = "success";
		}

		return $this->render('PicoLeagueBundle:Sport:create.html.twig', $response);
	}


}
