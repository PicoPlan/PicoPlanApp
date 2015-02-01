<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LeagueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LeagueRepository extends EntityRepository
{
    public function getLeagueFromEquipe($Equipe)
    {
        $League = $this->_em->getRepository('PicoLeagueBundle:League')->findBy(array('sport' => $Equipe->getSport()));
        return $League;
    }
}
