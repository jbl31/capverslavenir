<?php

namespace App\EventListener;

use App\Events;
use App\Event\ContactEvent;
use App\Services\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailerSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $destinataire;

    public function __construct(MailerInterface $mailer, string $destinataire)
    {
        $this->mailer = $mailer;
        $this->destinataire = $destinataire;
    }

    public static function getSubscribedEvents()
    {
        return [Events::ON_CONTACT => "send"];
    }

    public function send(ContactEvent $event)
    {
        $contact = $event->getContact();

        $this
            ->mailer
            ->setSender($contact->getEmail())
            ->setRecipient($this->destinataire)
            ->setMessage($contact->getMessage())
            ->setObject("Demande de contact")
            ->send();
    }
}