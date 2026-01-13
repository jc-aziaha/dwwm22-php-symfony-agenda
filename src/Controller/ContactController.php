<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(): Response {
        return $this->render('contact/index.html.twig');
    }

    #[Route('/contact/create', name: 'app_contact_create', methods: ['GET'])]
    public function create(): Response {

        // 1. Créer le contact à insérer en base de données.
        $contact = new Contact();

        // 2a. Créer le type du formulaire
        // 2b. L'utiliser pour créer le formulaire
        $form = $this->createForm(ContactFormType::class, $contact);

        // 3. Passer la partie visible du formulaire à la vue pour affichage
        return $this->render('contact/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
