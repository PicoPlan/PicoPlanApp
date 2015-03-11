<?php
namespace Pico\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pico\LeagueBundle\Form\EquipeType;
use Pico\LeagueBundle\Entity\Equipe;
use Pico\LeagueBundle\Entity\Sport;
use Pico\LeagueBundle\Entity\League;
use Pico\LeagueBundle\Entity\Club;
use Pico\LeagueBundle\Entity\UserToEquipe;

class LeagueController extends Controller
{

    private $CurrentUser;

    private $em;

    /**
     * Initialisation
     * Récuperation de l'entity manger
     * Récuperation de l'utilisateur courant
     */
    public function __init()
    {
        if ($this->get("security.context")->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->CurrentUser = $this->get('security.context')
                ->getToken()
                ->getUser();
        } else {
            $this->CurrentUser = false;
        }
        
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * Macro :
     * Demande de connexion
     */
    private function throwAccessDenied()
    {
        throw new AccessDeniedException('Vous devez etre connecté');
    }


    /**
     * Affiche la page specifique d'une league, d'un club ou d'une equipe
     * Default :
     * Affiche le menu de choix
     */
    public function indexAction($Type = false, $Id = false, $InfoSupp = false)
    {
        $this->__init();
//         $this->test();
        // Si les parametres sont remplis, on va chercher les infos
        if ($Type !== false and $Id !== false) {
            switch ($Type) {
                case 'Ligues':
                    
                    // La league
                    $League = $this->em->getRepository('PicoLeagueBundle:League')->find($Id);
                    if (is_null($League)) {
                        break;
                    }
                    // Les equipes
                    $Equipes = $this->em->getRepository('PicoLeagueBundle:Equipe')->getEquipesFromLeague($League);
                    // Verfication des droit du user
                    $IsAllowedUser = true;
                    // Vue League
                    return $this->render('PicoLeagueBundle:Affichage:AffichageLeague.html.twig', array(
                        'League' => $League,
                        'Equipes' => $Equipes,
                        'isAllowed' => $IsAllowedUser,
                        'alert_info' => $InfoSupp,
                        'alert_class' => 'info'
                    ));
                    break;
                case 'Clubs':
                    
                    // Le club
                    $Club = $this->em->getRepository('PicoLeagueBundle:Club')->find($Id);
                    if (is_null($Club)) {
                        break;
                    }
                    // Les equipes
                    $Equipes = $this->em->getRepository('PicoLeagueBundle:Equipe')->getEquipeFromClub($Club);
                    // Verfication des droit du user
                    $IsAllowedUser = ($Club->getUserCreator() == $this->CurrentUser);
                    // Vue Club
                    return $this->render('PicoLeagueBundle:Affichage:AffichageClub.html.twig', array(
                        'Club' => $Club,
                        'Equipes' => $Equipes,
                        'isAllowed' => $IsAllowedUser,
                        'alert_info' => $InfoSupp,
                        'alert_class' => 'info'
                    ));
                    break;
                case 'Equipes':
                    
                    // L'equipe
                    $Equipe = $this->em->getRepository('PicoLeagueBundle:Equipe')->find($Id);
                    if (is_null($Equipe)) {
                        break;
                    }
                    // La league
                    $League = $this->em->getRepository('PicoLeagueBundle:League')->getLeagueFromEquipe($Equipe);
                    // Les membres
                    $Membres = $this->em->getRepository('PicoLeagueBundle:UserToEquipe')->getUserFromEquipe($Equipe);
                    // Verfication des droit du user
                    $ListeModo = explode(',', $Equipe->getListeModo());
                    $ListeModo[] = $Equipe->getClub()
                        ->getUserCreator()
                        ->getId();
                    $IsAllowedUser = ($this->CurrentUser != false && in_array($this->CurrentUser->getId(), $ListeModo));
                    // Vue Equipe
                    return $this->render('PicoLeagueBundle:Affichage:AffichageEquipe.html.twig', array(
                        'League' => $League,
                        'Equipe' => $Equipe,
                        'Membres' => $Membres,
                        'isAllowed' => $IsAllowedUser,
                        'alert_info' => $InfoSupp,
                        'alert_class' => 'info'
                    ));
                    break;
                default:
                    throw new \Exception('Quelque chose a mal tourné !');
                    break;
            }
        }
        // Vue principale : on demande les infos
        return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
    }

    /**
     * Renvois la liste des leagues, club ou equipe
     */
    public function getAffichageAction($Type)
    {
        $this->__init();
        switch ($Type) {
            case 'Ligues':
                
                // Récuperation des leagues par nom décroissant
                $Liste = $this->em->getRepository('PicoLeagueBundle:League')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                // Information propre au type
                $InfoComplementaire = array(
                    'sport'
                );
                break;
            case 'Clubs':
                
                // Récuperation des clubs par nom décroissant
                $Liste = $this->em->getRepository('PicoLeagueBundle:Club')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                $InfoComplementaire = array();
                break;
            case 'Equipes':
                
                // Récuperation des equipes par nom décroissant
                $Liste = $this->em->getRepository('PicoLeagueBundle:Equipe')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                // Information propre au type
                $InfoComplementaire = array(
                    'sport',
                    'club'
                );
                break;
            default:
                throw new \Exception('Quelque chose a mal tourné !');
                break;
        }
        
        // Verification des data
        if (empty($Liste)) {
            $Error = 'Pas disponnible :/';
        } else {
            $Error = false;
        }
        
        // On retourne la vue
        return $this->render('PicoLeagueBundle:Affichage:liste.html.twig', array(
            'Type' => $Type,
            'Liste' => $Liste,
            'InfoComplementaire' => $InfoComplementaire,
            'Error' => $Error
        ));
    }

    /**
     * Valide le formulaire et impact en database
     * Default : Renvois le formulaire de créeation de Type
     * Renvois le formulaire de modification de IdCible
     *
     * @param string $Type            
     * @param int $Id            
     * @param int $IdCible            
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function manageFormAction($Type, $Id, $IdCible = false)
    {
        // Initialisation du formulaire
        $this->__init();
        switch ($Type) {
            case 'Equipes':
                // On récupere les entitées
                if ($IdCible != false) {
                    $Entity = $this->em->getRepository('PicoLeagueBundle:Equipe')->find($IdCible);
                    $Entity->setEm($this->em);
                } else {
                    // Ou l'on en crée une nouvelle
                    $Entity = new Equipe($this->em);
                    $Club = $this->em->getRepository('PicoLeagueBundle:Club')->find($Id);
                    $Entity->setClub($Club);
                }
                // On crée le form
                $Form = $this->get('form.factory')->create(new EquipeType(), $Entity, array(
                    'action' => 'javascript:validateForm("' . $this->generateUrl('pico_league_get_form', array(
                        'Type' => 'Equipes',
                        'Id' => $Id,
                        'IdCible' => $IdCible
                    )) . '");'
                ));
                // On recupere le vue de retour
                $RedirectUrl = $this->generateUrl('pico_league_affichage', array(
                    'Type' => 'Clubs',
                    'Id' => $Id,
                    'InfoSupp' => 'L\'equipe à bien été crée'
                ));
        }
        
        // Verification si validation :
        $Request = $this->getRequest();
        if ($Form->handleRequest($Request)->isValid()) {
            $this->em->merge($Entity);
            $this->em->flush();
            // On renvois la reponse en json
            return new JsonResponse(array(
                'status' => 'Ok',
                'url' => $RedirectUrl
            ));
        } else {
            // On affiche le form
            return $this->render('PicoLeagueBundle:Affichage:subView/Formulaire.html.twig', array(
                'Form' => $Form->createView()
            ));
        }
    }

    public function deleteAction($Type, $Id)
    {
        $this->__init();
        switch ($Type) {
            case 'Equipes':
                $Equipe = $this->em->getRepository('PicoLeagueBundle:Equipe')->find($Id);
                $Entitys = $this->em->getRepository('PicoLeagueBundle:UserToEquipe')->findBy(array('equipe'=>$Equipe));
                $Entitys[] = $Equipe;
                $AllowedTo = ($Equipe->getClub()->getUserCreator() == $this->CurrentUser);
                break;
            
            default:
                ;
            break;
        }
        if (isset($AllowedTo) && $AllowedTo == true) {
            foreach ($Entitys as $Entity){
                $this->em->remove($Entity);
            }
            $this->em->flush();
            return new JsonResponse(array('status'=>'OK'));
        } else {
            return new JsonResponse(array('status'=>'KO'));
        }
    }

    /**
     * Action de soubscription a l'equipe du membre courant
     *
     * @param Equipe.Id $Id            
     */
    public function subscribeToEquipeAction($Id)
    {
        $this->__init();
        // On vérifie les droits
        if (! $this->CurrentUser) {
            $this->throwAccessDenied();
        }
        // On récupere l'equipe
        $Equipe = $this->em->getRepository('PicoLeagueBundle:Equipe')->find($Id);
        
        // On ajoute le membre
        $Succes = $this->em->getRepository('PicoLeagueBundle:UserToEquipe')->addUser($this->CurrentUser, $Equipe);
        
        if ($Succes) {
            $Message = "Votre demande à bien été prise en compte";
        } else {
            $Message = "Vous aviez déjà postulé dans cette equipe. Un message vous sera envoyé lorsque votre requete aura été traitée.";
        }
        // On redirige sur la vue de l'equipe
        return $this->redirect($this->generateUrl('pico_league_affichage', array(
            'Type' => 'Equipes',
            'Id' => $Id,
            'InfoSupp' => $Message
        )));
    }

    /**
     *
     * @param unknown $Id            
     */
    public function gestionEquipeAction($Id)
    {
        $this->__init();
        // On vérifie les droits
        if (! $this->CurrentUser) {
            $this->throwAccessDenied();
        }
        // Verification de la requete
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            // On récupere les parametres qui nous interesses :
            $Params = array();
            foreach ($request->request->all() as $Key => $Post) {
                if (preg_match('#^etat_([0-9]+)$#i', $Key, $IdUserToEquipeMatch)) {
                    $Params[(int) $IdUserToEquipeMatch[1]] = $Post;
                }
            }
            
            if (empty($Params)) {
                // Si aucun parametre
                $Status = 'KO';
                $Error = 'Aucune séléction';
            } else {
                $Status = 'OK';
                $Error = false;
                // Sinon, pour chaque user
                foreach ($Params as $IdUserToEquipe => $Action) {
                    $UserToEquipe = $this->em->getRepository('PicoLeagueBundle:UserToEquipe')->find($IdUserToEquipe);
                    switch ($Action) {
                        case 'verify':
                            $UserToEquipe->setBoolAccepted(1);
                            $this->em->persist($UserToEquipe);
                            break;
                        case 'delete':
                            $this->em->remove($UserToEquipe);
                            break;
                        
                        default:
                            $Status = 'KO';
                            $Error = 'Une erreur à été rencontrée. Celle ci à été historisée';
                            break;
                    }
                    $this->em->flush();
                }
            }
            
            $Url = $this->generateUrl('pico_league_affichage', array(
                'Type' => 'Equipes',
                'Id' => $Id,
                'InfoSupp' => "Les modifications ont bien été prisent en compte"
            ));
            $ArrayRetour = array(
                'status' => $Status,
                'error' => $Error,
                'url' => $Url
            );
        } else {
            $ArrayRetour = array(
                'status' => 'KO',
                'Error' => 'Une erreur est survenue'
            );
        }
        
        return new JsonResponse($ArrayRetour);
    }
}