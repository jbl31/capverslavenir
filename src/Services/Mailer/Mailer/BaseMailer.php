<?php

namespace App\Services\Mailer\Mailer;

use App\Services\Mailer\MailerInterface;

class BaseMailer implements MailerInterface
{
    private $sender, $recipient, $object, $message;

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
        $headers   = '';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = sprintf("From: %s <%s>", $this->sender, $this->sender);

        return mail($this->recipient, $this->object, $this->message, implode("\r\n", $headers));
    }

}