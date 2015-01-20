<?php

namespace Pico\CalendarManagerBundle\Controller;

use Pico\CalendarManagerBundle\Entity\Event;
use Pico\CalendarManagerBundle\Entity\Repeatingevent;
use Pico\CalendarManagerBundle\Entity\Userevent;
use Pico\CalendarManagerBundle\Entity\Groupevent;
use Pico\CalendarManagerBundle\Entity\Clubevent;
use Pico\CalendarManagerBundle\Entity\Leagueevent;

use Pico\CalendarManagerBundle\Form\EventType;
use Pico\CalendarManagerBundle\Form\RepeatingeventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function addAction($type, $id, Request $request)
  {
    $event = new Event();
    $form = $this->get('form.factory')->create(new EventType(), $event);

    // If form is returned
    if ($form->handleRequest($request)->isValid()) {
      $intels = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($event);
      $em->flush();
    // If event is repeating
      $ifrepeat = $form->get('repeating')->get('repeat')->getData();
      if($ifrepeat){
        $repeating = new Repeatingevent();
        $repeating = $form->get('repeating')->getData();
        $repeating->setEvent($event->getId());
        $em->persist($repeating);
        $em->flush();
      }
    //Set type of owner
    if($type == 'user'){$ownership = new Userevent();}
    if($type == 'groupe'){$ownership = new Groupevent();}
    if($type == 'league'){$ownership = new Leagueevent();}
    if($type == 'club'){$ownership = new Clubevent();}
    $ownership->setParam($id, $event->getId());
    $em->persist($ownership);
    $em->flush();

      return $this->render('CalendarManagerBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

    return $this->render('CalendarManagerBundle:Default:index.html.twig', array('form' => $form->createView()));
  }

  public function modifyAction($id, Request $request)
  {
    //Event Info
    $doctrine = $this->getDoctrine();
    $em = $doctrine->getManager();
    $repo = $em->getRepository("CalendarManagerBundle:Event");
    $eventfind = $repo->find($id);

    //Repeatingevent info
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('CalendarManagerBundle:Repeatingevent')
      ;
    $repeatingexist = $repository->findOneByEvent($id);

    // Create form
    $event = $eventfind;
    $form = $this->get('form.factory')->create(new EventType(), $event);

    //Requete envoyé
    if ($form->handleRequest($request)->isValid()) {
      $intels = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($event);
      $em->flush();

      // Reset repeating
      if(!is_null($repeatingexist))
      {
        $em->remove($repeatingexist);
        $em->flush();
      }

      // If event is repeating
      $ifrepeat = $form->get('repeating')->get('repeat')->getData();
      if($ifrepeat){
        $repeating = new Repeatingevent();
        $repeating = $form->get('repeating')->getData();
        $repeating->setEvent($event->getId());
        $em->persist($repeating);
        $em->flush();
      }
       return $this->render('CalendarManagerBundle:Default:index.html.twig', array('form' => $form->createView()));

    }

    return $this->render('CalendarManagerBundle:Default:index.html.twig', array('form' => $form->createView(), 'event'=>$eventfind));
  }

  public function seeAction($id)
  {
    $doctrine = $this->getDoctrine();
    $em = $doctrine->getManager();
    $repo = $em->getRepository("CalendarManagerBundle:Event");
    $eventfind = $repo->find($id);
    $returnedarray = array('event'=>$eventfind);
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('CalendarManagerBundle:Repeatingevent')
      ;
    $repeatingexist = $repository->findOneByEvent($id);
    if(!is_null($repeatingexist)){ $returnedarray = array('event'=>$eventfind, 'repeatingexist'=>$repeatingexist);}
    return $this->render('CalendarManagerBundle:Default:see.html.twig', $returnedarray);
  }  

  public function deleteAction($id)
  {
    $doctrine = $this->getDoctrine();
    $em = $doctrine->getManager();
    $repo = $em->getRepository("CalendarManagerBundle:Event");
    $eventfind = $repo->find($id);
    $returnedarray = array('event'=>$eventfind);
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('CalendarManagerBundle:Repeatingevent')
      ;
    $repeatingexist = $repository->findOneByEvent($id);
    $em->remove($eventfind);
    if(!is_null($repeatingexist)){$em->remove($repeatingexist);}
    $em->flush();
    return $this->redirect('');
  } 
}
