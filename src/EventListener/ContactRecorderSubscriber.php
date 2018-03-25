<?php

namespace App\EventListener;

use App\Events;
use App\Event\ContactEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class ContactRecorderSubscriber implements EventSubscriberInterface
{
    private $doctrine;

    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public static function getSubscribedEvents()
    {
        return [Events::ON_CONTACT => "save"];
    }

    public function save(ContactEvent $event)
    {
        $em = $this->doctrine->getManager();
        $em->persist($event->getContact());
        $em->flush();
    }
}