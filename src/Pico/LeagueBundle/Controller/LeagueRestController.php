<?php 

namespace Pico\LeagueBundle\Controller;

Use Pico\LeagueBundle\Entity\League;
Use Pico\LeagueBundle\Entity\Equipe;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LeagueRestController extends Controller {

    public function __inti() {
        $em = $this->getDoctrine()->getManager();
    }

    public function getLeaguesAction(){

        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository("PicoLeagueBundle:League");

        $leagues = $repo->findBy(array(), array(
            "nom" => "Desc"
        ));

        return $leagues;
    }

    public function getTeamsAction() {

        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository("PicoLeagueBundle:Equipe");

        $teams = $repo->findBy(array(), array(
            "score" => "Desc"
        ));

        return $teams;
    } 
}
