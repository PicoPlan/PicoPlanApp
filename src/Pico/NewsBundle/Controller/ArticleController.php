<?php
namespace Pico\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Pico\UserBundle\Entity\User;
use Pico\NewsBundle\Entity\Article;
use Pico\NewsBundle\Form\Type\ArticleFormType;

class ArticleController extends Controller
{
    
    // Usefull attributes
    private $user;

    private $em; // Entity manager

    public function __init()
    {
        // Current user
        if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->user = $this->get('security.context')
                ->getToken()
                ->getUser();
        } else {
            $this->user = false;
        }
        // Entity Manager
        $this->em = $this->getDoctrine()->getManager();
    }

    public function showAction()
    {
        $this->__init();
        
        $articleList = $this->em->getRepository("PicoNewsBundle:Article")->findAll();
        foreach ($articleList as $article) {
            $list[$article->getId()] = array(
                "author" => $article->getAuthor(),
                "title" => $article->getTitle(),
                "content" => $article->getContent(),
                "date" => $article->getDate()->format("d-m-Y"),
                "id" => $article->getId()
            );
        }
        
        $response = [];
        
        if ($articleList) {
            $response["articles"] = $list;
        }
        $response["showEditButton"] = $this->calculateUserRight();
        return $this->render("PicoNewsBundle:Article:show.html.twig", $response);
    }

    public function showDetailAction($idNews)
    {
        $this->__init();
        $article = $this->em->getRepository("PicoNewsBundle:Article")->findOneById($idNews);
        if (empty($article)) {
            return $this->redirect($this->generateUrl("pico_news_show"));
        }
        $response = array(
            "author" => $article->getAuthor(),
            "title" => $article->getTitle(),
            "content" => $article->getContent(),
            "date" => $article->getDate()->format("d-m-Y"),
            "id" => $article->getId()
        );
        return $this->render("PicoNewsBundle:Article:detail.html.twig", $response);
    }

    public function createAction(Request $request)
    {
        $this->__init();
        
        $article = new Article();
        
        if (! $this->calculateUserRight()) {
            throw new AccessDeniedException("Cet utilisateur n'a pas accès à cette section.");
        }
        
        // Instanciate form
        $form = $this->createForm(new ArticleFormType(), $article);
        $form->handleRequest($request);
        $response["form"] = $form->createView();
        
        if ($form->isValid()) {
            $article->setAuthor($this->user);
            $this->em->persist($article);
            $this->em->flush();
            $response["alert_info"] = "Votre article a bien été enregistré.";
            $response["alert_class"] = "success";
            
            // Redirect if success
            return $this->redirect($this->generateUrl("pico_news_show", $response));
        }
        
        return $this->render("PicoNewsBundle:Article:create.html.twig", $response);
    }

    public function deleteAction(Request $request)
    {
        $this->__init();
        
        if (! $this->calculateUserRight()) {
            throw new AccessDeniedException("Cet utilisateur n'a pas accès à cette section.");
        }
        
        $toDelete = $request->get("delete_article");
        if ($toDelete) {
            $article = $this->em->getRepository("PicoNewsBundle:Article")->findBy(array(
                "id" => $toDelete
            ));
            foreach ($article as $item) {
                $this->em->remove($item);
            }
            $this->em->flush();
        }
        return $this->redirect($this->generateUrl("pico_news_show"));
    }

    public function calculateUserRight($VerifOnly = array('M2LAdmin' => false,'ClubLeader'=>false,'TeamLeader'=>false))
    {
        // User auth ?
        if ($this->user == false) {
            return false;
        }
        
        // M2L admin ?
        $isM2LAdmin = $this->get('security.context')->isGranted('ROLE_LIGUE_CREATEUR');
        if(isset($VerifOnly['M2LAdmin']) && $VerifOnly['M2LAdmin']) {
            return $isM2LAdmin;
        }
        
        // Club Leader ?
        $isClubLeader = $this->em->getRepository("PicoLeagueBundle:Club")->isClubLeader($this->user);
        if(isset($VerifOnly['ClubLeader']) && $VerifOnly['ClubLeader']) {
            return $isClubLeader;
        }
        
        // Team Leader ?
        $isTeamLeader = $this->em->getRepository("PicoLeagueBundle:Equipe")->isTeamLeader($this->user);
        if(isset($VerifOnly['TeamLeader']) && $VerifOnly['TeamLeader']) {
            return $isTeamLeader;
        }
        
        return ($isM2LAdmin || $isClubLeader || $isTeamLeader);
    }
}
