<?php
namespace Pico\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Pico\MessageBundle\Entity\messages;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Pico\MessageBundle\Form\messagesType;

class MessageController extends Controller
{

    /**
     * Retourne un array contenant les elements essentiels a chaque fonction
     */
    public function getEssentiel()
    {
        // On chope les essentiels
        if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->get('security.context')
                ->getToken()
                ->getUser();
            
            $EntityManager = $this->getDoctrine()->getManager();
            return array(
                $EntityManager,
                $user
            );
        } else {
            throw new AccessDeniedException('Vous devez etre connecté !!');
        }
    }

    public function addAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        $Message = new messages();
        $Form = $this->get('form.factory')->create(new messagesType(), $Message);
        if ($Form->handleRequest($this->getRequest())
            ->isValid()) {
            // On lie les messages à l'user
            $Message->setUserFrom($user);
            $Message->setUserTo($user);
            
            // On sauvegarde les entités
            $EntityManager->persist($user);
            $EntityManager->persist($Message);
            
            // On balance en base
            $EntityManager->flush();
            
            return new Response('Message Ajouté');
        } else {
            
            return $this->render('PicoMessageBundle:Message:add.html.twig', array(
                'Form' => $Form->createView()
            ));
        }
    }

    public function viewAction()
    {
        list ($EntityManager, $user) = $this->getEssentiel();
        
        // On récupère la liste des candidatures de cette annonce
        $ListeMessages = $EntityManager->getRepository('PicoMessageBundle:messages')->findBy(array(
            'userTo' => $user
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