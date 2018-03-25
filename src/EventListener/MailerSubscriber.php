<?php

namespace App\EventListener;

use App\Events;
use App\Event\ContactEvent;
use App\Services\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailerSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $sender;

    public function __construct(MailerInterface $mailer, string $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
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
            ->setSender($this->sender)
            ->setRecipient($contact->getEmail())
            ->setMessage($contact->getMessage())
            ->setObject("Demande de contact")
            ->send();
    }
}