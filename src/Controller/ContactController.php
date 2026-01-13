<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(): Response {
        return $this->render('contact/index.html.twig');
    }

    #[Route('/contact/create', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response {

        // 1. Créer le contact à insérer en base de données.
        $contact = new Contact();

        // 2a. Créer le type du formulaire
        // 2b. L'utiliser pour créer le formulaire
        $form = $this->createForm(ContactFormType::class, $contact);

        // 4. Associer au formulaire les données de la requête
        $form->handleRequest($request);

        // 5. Si le formulaire est soumis et validate
        if ( $form->isSubmitted() && $form->isValid() ) {
            
            // 6. Alors, insérer le nouveau contact en base de données
            dd('pause');

            // 7. Générer le message flash de succès de l'opération

            // 8. Effectuer une redirection vers la page d'accueil
                // Puis, arrêter l'exécution du script.
        }

        // 3. Passer la partie visible du formulaire à la vue pour affichage
        return $this->render('contact/create.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
