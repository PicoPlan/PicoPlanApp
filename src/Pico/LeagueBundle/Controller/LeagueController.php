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
    public function indexAction()
    {
        return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
    }
    
    /**
     * 
     */
    public function getAffichageAction($Type)
    {
        var_dump($Type);
        return $this->render('PicoLeagueBundle:Affichage:index.html.twig');
    }
}
