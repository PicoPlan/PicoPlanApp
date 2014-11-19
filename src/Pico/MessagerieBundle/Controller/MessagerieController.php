<?php

namespace Pico\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MessagerieController extends Controller
{
	/**
	 * Liste les different messages recus
	 */
    public function getListeMessageAction()
    {
    	//On récupere le user en cours
    	
    	//sinon on retourne a l'accueil
        return $this->render('PicoMessagerieBundle:Default:index.html.twig', array('name' => $name));
    }

    /**
     * Affiche les detail d'un message
     */
    public function detailMessageAction($idMessage)
    {
    	
    }
}