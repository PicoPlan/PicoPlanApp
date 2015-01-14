<?php
namespace Pico\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pico\LeagueBundle\Entity\Equipe;
use Pico\LeagueBundle\Entity\Sport;
use Pico\LeagueBundle\Entity\League;
use Pico\LeagueBundle\Entity\Club;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LeagueController extends Controller
{

    /**
     * Gestion de l'affichage
     */
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

    public function test()
    {
        list ($EntityManager, $User) = $this->getEssentiel();

        $Sport = new Sport();
        $Sport->setNom('Rugby');
        $Sport->setDescription('Un sport de gentlemen joué par des hooligans');
        $EntityManager->persist($Sport);
        
        $Sport2 = new Sport();
        $Sport2->setNom('BabyFoot');
        $Sport2->setDescription('Un sport de gentlemen joué par des hooligans');
        $EntityManager->persist($Sport2);
        
        $League = new League();
        $League->setNom('Rugby');
        $League->setDescription('La ligue des rugbyman');
        $League->setSport($Sport);
        $League->setUserCreator($User);
        $EntityManager->persist($League);
        
        $Club = new Club();
        $Club->setUserCreator($User);
        $Club->setNom('Le club de Ynov');
        $Club->setAdresse('42 rue de Ynov - 75020 - Paris');
        $Club->setDescription('Club de geek !');
        $EntityManager->persist($Club);
        
        $Equipe = new Equipe();
        $Equipe->setSport($Sport);
        $Equipe->setClub($Club);
        $Equipe->setNom('Les vrais rugbyman !');
        $Equipe->setListeModo(serialize(array('1','2','3')));
        $EntityManager->persist($Equipe);
        
        $Equipe = new Equipe();
        $Equipe->setSport($Sport2);
        $Equipe->setClub($Club);
        $Equipe->setNom('Les vrais Babyfooteux !');
        $Equipe->setListeModo(serialize(array('1','2','3')));
        $EntityManager->persist($Equipe);
        
        // On balance en base
        $EntityManager->flush();
    }

    /**
     * indexAction
     * Affiche la page du $Type $Id
     * Default :
     * Affiche le menu de choix des sous vues (récuperation en ajax)
     */
    public function indexAction($Type = false, $Id = false)
    {
        $this->test();
        $EntityManager = $this->getDoctrine()->getManager();
        if ($Type !== false and $Id !== false) {
            switch ($Type) {
                case 'Leagues':
                    $League = $EntityManager->getRepository('PicoLeagueBundle:League')->find($Id);
                    if (is_null($League)) {
                        break;
                    }
                    // Si pas de liste en renvois sur la page par defaut
                    return $this->render('PicoLeagueBundle:Affichage:AffichageLeague.html.twig', array(
                        'League' => $League
                    ));
                    break;
                case 'Clubs':
                    $Club = $EntityManager->getRepository('PicoLeagueBundle:Club')->find($Id);
                    if (is_null($Club)) {
                        break;
                    }
                    // Si pas de liste en renvois sur la page par defaut
                    return $this->render('PicoLeagueBundle:Affichage:AffichageClub.html.twig',array('Club'=>$Club));
                    break;
                case 'Equipes':
                    $Equipe = $EntityManager->getRepository('PicoLeagueBundle:Equipe')->find($Id);
                    if (is_null($Equipe)) {
                        break;
                    }
                    // Si pas de liste en renvois sur la page par defaut
                    return $this->render('PicoLeagueBundle:Affichage:AffichageEquipe.html.twig',array('Equipe'=>$Equipe));
                    break;
                default:
                    throw new \Exception('Quelque chose a mal tourné !');
                    break;
            }
        }
        
        return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
    }

    /**
     * Renvois la liste des entitées en fonction du type
     * Valeurs possibles : Leagues, Clubs, Equipes
     */
    public function getAffichageAction($Type)
    {
        $EntityManager = $this->getDoctrine()->getManager();
        switch ($Type) {
            case 'Leagues':
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:League')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                $InfoComplementaire = array(
                    'sport'
                );
                break;
            case 'Clubs':
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:Club')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                $InfoComplementaire = array();
                break;
            case 'Equipes':
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:Equipe')->findBy(array(), array(
                    'nom' => 'Desc'
                ));
                $InfoComplementaire = array(
                    'sport',
                    'club'
                );
                break;
            default:
                throw new \Exception('Quelque chose a mal tourné !');
                break;
        }
        if (empty($Liste)) {
            $Error = 'Pas disponnible :/';
        } else {
            $Error = false;
        }
        return $this->render('PicoLeagueBundle:Affichage:liste.html.twig', array(
            'Type' => $Type,
            'Liste' => $Liste,
            'InfoComplementaire' => $InfoComplementaire,
            'Error' => $Error
        ));
    }
}
