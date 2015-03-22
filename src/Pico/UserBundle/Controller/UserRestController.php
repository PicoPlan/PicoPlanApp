<?php

namespace Pico\UserBundle\Controller;

use Pico\UserBundle\Entity\User;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserRestController extends Controller
{
  public function getUserAction($username){

  	$repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('PicoUserBundle:User');

    $user = $repository->findOneByUsername($username);
    if(!is_object($user)){
      throw $this->createNotFoundException();
    }
    return $user;
  }

  /**
   * 
   * @View(serializerGroups={"Default","Me","Details"})
   */
  public function getMeAction(){
    $this->forwardIfNotAuthenticated();
    return $this->getUser();
  }

  /**
   * Shortcut to throw a AccessDeniedException($message) if the user is not authenticated
   * @param String $message The message to display (default:'warn.user.notAuthenticated')
   */
  protected function forwardIfNotAuthenticated($message='warn.user.notAuthenticated'){
    if (!is_object($this->getUser()))
    {
        throw new AccessDeniedException($message);
    }
  }
}