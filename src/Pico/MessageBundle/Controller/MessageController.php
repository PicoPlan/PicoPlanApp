<?php
namespace Pico\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Pico\MessageBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageController extends Controller
{

    /**
     * Retourne un array contenant les elements essentiels a chaque fonction
     */
    public function getEssentiel()
    {
        // On chope les essentiels
        // $user = $this->get('security.context')->getToken()->getUser();
        $user = $this->container->get('security.context')
            ->getToken()
            ->getUser();
        $EntityManager = $this->getDoctrine()->getManager();
        return array(
            $EntityManager,
            $user
        );
    }

    public function addAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        $Message = new messages();
        $Form = $this->get('form.factory')
            ->createBuilder('form', $Message)
            ->add('title', 'text')
            ->add('text', 'textarea')
            ->add('save', 'submit')
            ->getForm();
        $request = $this->getRequest();
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            // On lie les messages à l'user
            $Message->setUser($user);
            
            // On sauvegarde les entités
            $EntityManager->persist($user);
            $EntityManager->persist($Message);
            
            // On balance en base
            $EntityManager->flush();
        } else {
            
            echo $Form;
            
            return new Response('Ok');
        }
    }

    public function viewAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        // $user = $user->find(3);
        
        // var_dump($user);
        if (null === $user) {
            throw new NotFoundHttpException("Vous n'êtes pas connecté.");
        }
        
        // On récupère la liste des candidatures de cette annonce
        $ListeMessages = $EntityManager->getRepository('PicoMessageBundle:messages')->findBy(array(
            'user' => $user
        ));
        
        return $this->render('PicoMessageBundle:Message:view.html.twig', array(
            'ListeMessages' => $ListeMessages
        ));
    }

    /**
     * Liste les different messages recus
     */
    public function getListeMessageAction()
    {
        // On récupere le user en cours et on regarde s'il a des messages en attentes
        
        // sinon on retourne a l'accueil
        return $this->render('PicoMessageBundle:Default:index.html.twig', array(
            'name' => $name
        ));
    }

    /**
     * Affiche les detail d'un message
     */
    public function detailMessageAction($idMessage)
    {}
}