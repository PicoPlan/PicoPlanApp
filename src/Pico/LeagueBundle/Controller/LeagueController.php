<?php

namespace Pico\LeagueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LeagueController extends Controller
{
    /**
     *   Gestion de l'affichage
     */

    
    /**
     * indexAction
     * Affiche le menu de choix des sous vues (récuperation en ajax)
     */
    public function indexAction($Type=false,$Id=false)
    {
        if($Type == false OR $Id==false) {
            return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
        } else {
            switch ($Type) {
                case 'Leagues':
                    $Liste = $EntityManager->getRepository('PicoLeagueBundle:League')->findBy(array(), array('nom' => 'Desc'));
                    $InfoComplementaire = array('sport');
                    break;
                case 'Clubs':
                    $Liste = $EntityManager->getRepository('PicoLeagueBundle:Club')->findBy(array(), array('nom' => 'Desc'));
                    $InfoComplementaire = array('sport');
                    break;
                case 'Equipes':
                    $Liste = $EntityManager->getRepository('PicoLeagueBundle:Equipe')->findBy(array(), array('nom' => 'Desc'));
                    $InfoComplementaire = array('sport','club');
                    break;
                default:
                    throw new \Exception('Quelque chose a mal tourné !');
                    break;
            }
        }
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
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:League')->findBy(array(), array('nom' => 'Desc'));
                $InfoComplementaire = array('sport');
            break;
            case 'Clubs':
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:Club')->findBy(array(), array('nom' => 'Desc'));
                $InfoComplementaire = array('sport');
            break;
            case 'Equipes':
                $Liste = $EntityManager->getRepository('PicoLeagueBundle:Equipe')->findBy(array(), array('nom' => 'Desc'));
                $InfoComplementaire = array('sport','club');
            break;
            default:
                throw new \Exception('Quelque chose a mal tourné !');
            break;
        }
        if(empty($Liste)) {
            $Error = 'Pas disponnible :/';
        } else {
            $Error = false;
        }
        return $this->render('PicoLeagueBundle:Affichage:liste.html.twig',array('Type'=>$Type,'Liste'=>$Liste,'InfoComplementaire'=>$InfoComplementaire,'Error'=>$Error));
    }
}
