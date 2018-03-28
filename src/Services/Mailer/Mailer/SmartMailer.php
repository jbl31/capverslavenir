<?php

namespace App\Services\Mailer\Mailer;

use App\Services\Mailer\MailerInterface;

use Swift_Mailer;
use Swift_Message;

class SmartMailer implements MailerInterface
{
    private $sender, $recipient, $name, $phone, $object, $message;
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setSender(string $email): MailerInterface
    {
        $this->sender = $email;

        return $this;
    }

    public function setRecipient(string $email): MailerInterface
    {
        $this->recipient = $email;

        return $this;
    }

    public function setObject(string $object): MailerInterface
    {
        $this->object = $object;

        return $this;
    }

    public function setMessage(string $message): MailerInterface
    {
        $this->message = $message;

        return $this;
    }

    public function send(): bool
    {
        $message = new Swift_Message($this->object);
        $message
            ->setFrom($this->sender)
            ->setTo($this->recipient)
            ->setBody($this->message);

        $err = [];
        $this->mailer->send($message, $err);

        return count($err) == 0;
    }

}