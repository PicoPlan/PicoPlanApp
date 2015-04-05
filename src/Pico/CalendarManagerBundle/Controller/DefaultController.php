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
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    private $type = array(
        'user' => 'user',
        'groupe' => 'groupe',
        'league' => 'league',
        'club' => 'club'
    );

    public function getEntityFromType($type)
    {
        switch ($type) {
            case $this->type['user']:
                return new Userevent();
                break;
            case $this->type['groupe']:
                return new Groupevent();
                break;
            case $this->type['league']:
                return new Leagueevent();
                break;
            case $this->type['club']:
                return new Clubevent();
                break;
            default:
                throw new NotFoundHttpException("Page not found");
                break;
        }
    }

    public function addAction($type, $id, Request $request)
    {
        $event = new Event();
        $form = $this->get('form.factory')->create(new EventType(), $event, array('action'=>'javascript:validateform("'.$type.'",'.$id.')','attr'=>array('id' => 'eventform')));
        
        // If form is returned
        if ($form->handleRequest($request)->isValid()) {
            $intels = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            // If event is repeating
            $ifrepeat = $form->get('repeating')
                ->get('repeat')
                ->getData();
            if ($ifrepeat) {
                $repeating = new Repeatingevent();
                $repeating = $form->get('repeating')->getData();
                $repeating->setEvent($event->getId());
                $em->persist($repeating);
                $em->flush();
            }
            $ownership = $this->getEntityFromType($type);
            $ownership->setParam($id, $event->getId());
            $em->persist($ownership);
            $em->flush();

            return new JsonResponse(array('status' => 'ok'));
        }
        
        return $this->render('CalendarManagerBundle:Default:index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modifyAction($id, Request $request)
    {
        // Event Info
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repo = $em->getRepository("CalendarManagerBundle:Event");
        $eventfind = $repo->find($id);
        
        // Repeatingevent info
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Repeatingevent');
        $repeatingexist = $repository->findOneByEvent($id);
        
        // Create form
        $event = $eventfind;
        $thearray = array(
            'event' => $event,
            'repeatingevent' => $repeatingexist
        );
        $form = $this->get('form.factory')->create(new EventType(), $event, array('action'=>'javascript:validateform('.$id.')','attr'=>array('id' => 'eventform')));
        
        // Requete envoyé
        if ($form->handleRequest($request)->isValid()) {
            $intels = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            
            // Reset repeating
            if (! is_null($repeatingexist)) {
                $em->remove($repeatingexist);
                $em->flush();
            }
            
            // If event is repeating
            $ifrepeat = $form->get('repeating')
                ->get('repeat')
                ->getData();
            if ($ifrepeat) {
                $repeating = new Repeatingevent();
                $repeating = $form->get('repeating')->getData();
                $repeating->setEvent($event->getId());
                $em->persist($repeating);
                $em->flush();

            }
            return new JsonResponse(array('status' => 'ok'));
        }
        
        return $this->render('CalendarManagerBundle:Default:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function seeAction($id)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $repo = $em->getRepository("CalendarManagerBundle:Event");
        $eventfind = $repo->find($id);
        $returnedarray = array(
            'event' => $eventfind
        );
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Repeatingevent');
        $repeatingexist = $repository->findOneByEvent($id);
        if (! is_null($repeatingexist)) {
            $returnedarray = array(
                'event' => $eventfind,
                'repeatingexist' => $repeatingexist
            );
        }
        return $this->render('CalendarManagerBundle:Default:see.html.twig', $returnedarray);
    }

    public function deleteAction($id)
    {
        
        // parmeters
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        
        //event
        $EventRepository = $em->getRepository("CalendarManagerBundle:Event");
        $eventfind = $EventRepository->find($id);
        if(empty($eventfind)){
            //If no event, it's a bug
            return new response('ko');
        } else {
            $em->remove($eventfind);
        }
        
        // search repeatingevent related
        $repeatingexist = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Repeatingevent')
            ->findOneByEvent($id);
        if (! is_null($repeatingexist)) {
            $em->remove($repeatingexist);
        }
        
        // search ownership
        $UserEventexist = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Userevent')
            ->findOneByEvent($id);
        if (! is_null($UserEventexist)) {
            $em->remove($UserEventexist);
        }

        
        $ClubEventexist = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Clubevent')
            ->findOneByEvent($id);
        if (! is_null($ClubEventexist)) {
            $em->remove($ClubEventexist);
        }
        
        $GroupEventexist = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Groupevent')
            ->findOneByEvent($id);
        if (! is_null($GroupEventexist)) {
            $em->remove($GroupEventexist);
        }
        
        $LeagueEventexist = $this->getDoctrine()
            ->getManager()
            ->getRepository('CalendarManagerBundle:Leagueevent')
            ->findOneByEvent($id);
        if (! is_null($LeagueEventexist)) {
            $em->remove($LeagueEventexist);
        }
        
        // Do it
        $em->flush();

        //Return ok
        return new response('ok');
    }
    

    public function geteventsAction($type, $id)
    {
        $DoctrineManager = $this->getDoctrine()->getManager();
        $EventRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Event');
        $eventlist = array();
        
        // User
        function byUser($id, $DoctrineManager, $eventlist)
        {
            $EventRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Event');
            $UserEvents = $DoctrineManager->getRepository('CalendarManagerBundle:Userevent')->findByUser($id);
            foreach ($UserEvents as $eventtoload) {
                $eventfind = $EventRepository->find($eventtoload->getEvent());
                $eventlist[] = $eventfind;
            }
            
            // Groupe liés
            $Groupattached = $DoctrineManager->getRepository('PicoLeagueBundle:UserToEquipe')->findByUser($id);
            foreach ($Groupattached as $groupefind) {
                $eventlist = array_merge(byGroup($groupefind->getEquipe(), $DoctrineManager, $eventlist));
            }
            
            return $eventlist;
        }
        
        // Group
        function byGroup($id, $DoctrineManager, $eventlist)
        {
            $EventRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Event');
            $GroupEvents = $DoctrineManager->getRepository('CalendarManagerBundle:Groupevent')->findByEquipe($id);
            foreach ($GroupEvents as $eventtoload) {
                $eventfind = $EventRepository->find($eventtoload->getEvent());
                $eventlist[] = $eventfind;
            }
            
            // Club lié
            $Club = $DoctrineManager->getRepository('PicoLeagueBundle:Equipe')->find($id);
            if (! is_null($Club)) {
                $ClubId = $Club->getClub()->getId();
                $eventlist = array_merge(byClub($ClubId, $DoctrineManager, $eventlist));
            }
            
            return $eventlist;
        }
        
        // Club
        function byClub($id, $DoctrineManager, $eventlist)
        {
            $EventRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Event');
            $ClubEvents = $DoctrineManager->getRepository('CalendarManagerBundle:Clubevent')->findByClub($id);
            foreach ($ClubEvents as $eventtoload) {
                $eventfind = $EventRepository->find($eventtoload->getEvent());
                $eventlist[] = $eventfind;
            }
            
            return $eventlist;
        }
        
        // League
        function byLeague($id, $DoctrineManager, $eventlist)
        {
            $EventRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Event');
            $LeagueEvents = $DoctrineManager->getRepository('CalendarManagerBundle:Leagueevent')->findByLeague($id);
            foreach ($LeagueEvents as $eventtoload) {
                $eventfind = $EventRepository->find($eventtoload->getEvent());
                $eventlist[] = $eventfind;
            }
            
            return $eventlist;
        }
        
        if ($type == $this->type['user']) {
            $eventlist[] = byUser($id, $DoctrineManager, $eventlist);
        }
        if ($type == $this->type['groupe']) {
            $eventlist[] = byGroup($id, $DoctrineManager, $eventlist);
        }
        if ($type == $this->type['club']) {
            $eventlist[] = byClub($id, $DoctrineManager, $eventlist);
        }
        if ($type == $this->type['league']) {
            $eventlist[] = byLeague($id, $DoctrineManager, $eventlist);
        }

        
        // Search Repeating
        $RepeatingRepository = $DoctrineManager->getRepository('CalendarManagerBundle:Repeatingevent');
        $arrayreturned = array();
        foreach ($eventlist[0] as $event) {
            $Repeatingfind = $RepeatingRepository->findOneByEvent($event->getId());
            // +1 jour +1semaine +2semaine +1mois
            if (!is_null($Repeatingfind)) {
                $frequency = $Repeatingfind->getFrequency();
                while ($Repeatingfind->getDateEndrepeat() > $event->getDatetimeEnd()) {
                    $arrayreturned[] = clone $event;
                    $datestart = clone $event->getDatetimeStart();
                    $datestart2 = $datestart->modify($frequency);
                    $event->setDatetimeStart($datestart2);
                    
                    $dateend = clone $event->getDatetimeEnd();
                    $dateend2 = $dateend->modify($frequency);
                    $event->setDatetimeEnd($dateend2);
                }
            }
            else{
                $arrayreturned[] = clone $event;
            }
        }
        
        return $this->render('CalendarManagerBundle:Default:getevents.html.twig', array(
            'eventlist' => $arrayreturned,
            'type' => $type
        ));
    }
}
