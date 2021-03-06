<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EquipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EquipeRepository extends EntityRepository
{
    public function getEquipesFromLeague($League)
    {
        $Equipes = $this->_em->getRepository('PicoLeagueBundle:Equipe')->findBy(array('sport' => $League->getSport()));
        return $Equipes;
    }   
    
    public function getEquipeFromClub($Club)
    {
        $Equipes =  $this->_em->getRepository('PicoLeagueBundle:Equipe')->findBy(array('club' => $Club));
        return $Equipes;
    }

    public function isTeamLeader($User)
    {
        $Equipes =  $this->_em->getRepository('PicoLeagueBundle:Equipe')->findAll();
        foreach ($Equipes as $Equipe) {
            $arrayListeModo = explode(',',$Equipe->getListeModo());
            if(in_array($User->getId(),$arrayListeModo)){
                return true;
            }
        }
        return false;
    }
}