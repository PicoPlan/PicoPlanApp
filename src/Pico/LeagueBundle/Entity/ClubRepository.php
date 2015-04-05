<?php

namespace Pico\LeagueBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClubRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClubRepository extends EntityRepository
{
    /**
     * Is the user owned at least one club
     * @param User $User
     * @return boolean
     */
    public function isClubLeader($User)
    {
        $Clubs =  $this->_em->getRepository('PicoLeagueBundle:Club')->findBy(array('userCreator' => $User));
        return !empty($Clubs);
    }
}
