<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 23/03/2018
 * Time: 10:42
 */

namespace App\Event;


use App\Entity\Contact;
use Symfony\Component\EventDispatcher\Event;


class ContactEvent extends Event
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }
}