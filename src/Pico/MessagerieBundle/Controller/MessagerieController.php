<?php
namespace Pico\MessagerieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Pico\UserManagementBundle\Entity\User;
use Pico\MessagerieBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Response;

class MessagerieController extends Controller
{

    /**
     * Retourne un array contenant les elements essentiels a chaque fonction
     */
    public function getEssentiel()
    {
        // On chope les essentiels
        // $user = $this->get('security.context')->getToken()->getUser();
        $user = new User();
        $EntityManager = $this->getDoctrine()->getManager();
        return array(
            $EntityManager,
            $user
        );
    }

    public function addAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        
// Pour les tests, on crée un user
$user = new User();
$user->setLogin('punkoTest');
$user->setMdp('test');
$user->setSecurityLvl("99");
$user->setFirstName('Moi');
$user->setLastName('Leo');
$user->setEmail('Punkoleo@gmail.com');
$user->setPhone('0123456789');
$user->setBirthDate('un bug ici ;)');

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
        $Message1->setUser($user);
        $Message2->setUser($user);
        
        // On sauvegarde les entités
        $EntityManager->persist($user);
        $EntityManager->persist($Message1);
        $EntityManager->persist($Message2);
        
        // On balance en base
        $EntityManager->flush();
        
        return new Response('Ok');
    }

    public function viewAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        $user = $user->find(3);
        return new Response(var_dump($user));
        $em = $this->getDoctrine()->getManager();
        
        // On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }
        
        // On récupère la liste des candidatures de cette annonce
        $listApplications = $em->getRepository('OCPlatformBundle:Application')->findBy(array(
            'advert' => $advert
        ));
        
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications
        ));
    }

    /**
     * Liste les different messages recus
     */
    public function getListeMessageAction()
    {
        // On récupere le user en cours et on regarde s'il a des messages en attentes
        
        // sinon on retourne a l'accueil
        return $this->render('PicoMessagerieBundle:Default:index.html.twig', array(
            'name' => $name
        ));
    }

    /**
     * Affiche les detail d'un message
     */
    public function detailMessageAction($idMessage)
    {}
}