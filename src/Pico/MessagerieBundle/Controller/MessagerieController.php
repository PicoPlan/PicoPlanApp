<?php

namespace Pico\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Pico\UserManagementBundle\Entity\User;
use Pico\MessagerieBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Response;
class MessagerieController extends Controller
{
	
	public function addAction()
	{
		// Pour les tests, on crée un user
		$User = new User();
		$User->setLogin('punkoTest');
		$User->setMdp('test');
		$User->setSecurityLvl("99");
		$User->setFirstName('Moi');
		$User->setLastName('Leo');
		$User->setEmail('Punkoleo@gmail.com');
		$User->setPhone('0123456789');
		$User->setBirthDate('un bug ici ;)');
	
		// Puis deux messages
		$Message1 = new messages();
		$Message1->setIdFrom(1);
		$Message1->setTitle('Test 1');
		$Message1->setText('Yo');
		$Message1->setDate(new \DateTime());
		$Message1->setTopVu(0);
		
		$Message2 = new messages();
		$Message2->setIdFrom(1);
		$Message2->setTitle('Test 2');
		$Message2->setText('Yo');
		$Message2->setDate(new \DateTime());
		$Message2->setTopVu(0);
	
		// On lie les messages à l'user
		$Message1->setUser($User);
		$Message2->setUser($User);
	
		// On récupère l'EntityManager
		$EntityManager = $this->getDoctrine()->getManager();
	
		// Étape 1 : On « persiste » l'entité
		$EntityManager->persist($User);
	
		// Étape 1 bis : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
		// définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
		$EntityManager->persist($Message1);
		$EntityManager->persist($Message2);
	
		// Étape 2 : On « flush » tout ce qui a été persisté avant
		$EntityManager->flush();
	
		return new Response('Ok');
	}
	
	/**
	 * Liste les different messages recus
	 */
    public function getListeMessageAction()
    {
    	//On récupere le user en cours et on regarde s'il a des messages en attentes

    	
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