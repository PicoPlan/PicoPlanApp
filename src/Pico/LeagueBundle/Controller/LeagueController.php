<?php
namespace Pico\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeagueController extends Controller
{

    /**
     * Gestion de l'affichage
     */
    
    /**
     * indexAction
     * Affiche la page du $Type $Id
     * Default :
     * Affiche le menu de choix des sous vues (récuperation en ajax)
     */
    public function indexAction($Type = false, $Id = false)
    {
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
                    return $this->render('PicoLeagueBundle:AffichageClub:index.html.twig');
                    break;
                case 'Equipes':
                    $Liste = $EntityManager->getRepository('PicoLeagueBundle:Equipe')->find($Id);
                    // Si pas de liste en renvois sur la page par defaut
                    return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
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
                $InfoComplementaire = array(
                    'sport'
                );
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
