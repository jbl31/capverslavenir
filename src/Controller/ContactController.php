<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Event\ContactEvent;
use App\Form\ContactType;
use App\Events;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $event = new ContactEvent($contact);
            $this
                ->get("event_dispatcher")// je récupère l'event dispatcher
                ->dispatch(Events::ON_CONTACT, $event);

            $this->addFlash('success','Votre message a bien été envoyé');

            return $this->redirectToRoute('homepage');

        }
        return $this->render('contact/contact.html.twig', ['form' => $form->createView()]);
    }
}
