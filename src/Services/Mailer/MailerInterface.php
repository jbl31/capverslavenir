<?php

namespace App\Services\Mailer;

interface MailerInterface
{
    public function setSender(string $email) : MailerInterface;
    public function setRecipient(string $email) : MailerInterface;
    public function setObject(string $object) : MailerInterface;
    public function setMessage(string $message) : MailerInterface;
    public function send() : bool ;
}