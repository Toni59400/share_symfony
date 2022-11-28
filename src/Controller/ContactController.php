<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    #[Route('/liste-contacts', name: 'liste-contacts')]
    public function listeContact(): Response
    {
        $repoContacts = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repoContacts->findAll();
        return $this->render('contact/liste-contacts.html.twig', [
            'contacts' => $contact
        ]);
    }
}
