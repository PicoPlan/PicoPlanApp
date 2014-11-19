<?php

namespace Pico\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Pico\UserManagementBundle\Entity\User;
use Pico\MessagerieBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Response;
class MessagerieController extends Controller
{
	private $EntityManager;
	private $User;
	
	public function __construct()
	{
		parent::__construct();
		$this->EntityManager = $this->getDoctrine()->getManager();
		$this->User = new User();
		
	}
	public function addAction()
	{
		// Pour les tests, on crée un user
		$this->User = new User();
		$this->User->setLogin('punkoTest');
		$this->User->setMdp('test');
		$this->User->setSecurityLvl("99");
		$this->User->setFirstName('Moi');
		$this->User->setLastName('Leo');
		$this->User->setEmail('Punkoleo@gmail.com');
		$this->User->setPhone('0123456789');
		$this->User->setBirthDate('un bug ici ;)');
	
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
		$Message1->setUser($this->User);
		$Message2->setUser($this->User);
	
		// Étape 1 : On « persiste » l'entité
		$this->EntityManager->persist($this->User);
	
		// Étape 1 bis : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
		// définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
		$this->EntityManager->persist($Message1);
		$this->EntityManager->persist($Message2);
	
		// Étape 2 : On « flush » tout ce qui a été persisté avant
		$this->EntityManager->flush();
	
		return new Response('Ok');
	}
	
	public function viewAction($id)
	{
		$em = $this->getDoctrine()->getManager();
	
		// On récupère l'annonce $id
		$advert = $em
		->getRepository('OCPlatformBundle:Advert')
		->find($id)
		;
	
		if (null === $advert) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
	
		// On récupère la liste des candidatures de cette annonce
		$listApplications = $em
		->getRepository('OCPlatformBundle:Application')
		->findBy(array('advert' => $advert))
		;
	
		return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
				'advert'           => $advert,
				'listApplications' => $listApplications
		));
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