<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response {

        // 1. La méthode findAll() permet de récupérer la liste des tous les contacts de la base de données 
        // sous forme de tableau.
        $contacts = $contactRepository->findAll();

        // 2. Passer le taleau des contacts à la vue pour affichage.
        return $this->render('contact/index.html.twig', [
            "contacts" => $contacts
        ]);
    }

    #[Route('/contact/create', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {

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
            $entityManager->persist($contact); // Préparer la requête d'insertion des informations en base de données
            $entityManager->flush(); // Exécuter la requête

            // 7. Générer le message flash de succès de l'opération
            $this->addFlash('success', 'Le contact a été ajouté à la liste.');

            // 8. Effectuer une redirection vers la page d'accueil
                // Puis, arrêter l'exécution du script.
            return $this->redirectToRoute('app_contact_index');
        }

        // 3. Passer la partie visible du formulaire à la vue pour affichage
        return $this->render('contact/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/contact/edit/{id}', name: 'app_contact_edit', methods:['GET', 'POST'])]
    public function edit(Contact $contact, Request $request, EntityManagerInterface $entityManager): Response {
        
        // 1. Une fois que le contact à modifier est récupéré,
        // 2. Créer le formulaire de modification qui lui est associé.
        $form = $this->createForm(ContactFormType::class, $contact);

        // 4. Associer au formulaire, les données de la requête
        $form->handleRequest($request);

        // 5. Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // 6. Alors, effectuer la requête de modification du contact en base de données
            $entityManager->persist($contact);
            $entityManager->flush();

            // 7. Générer le message flash de succès de l'opération
            $this->addFlash("success", "Le contact a été modifié");

            // 8. Effectuer une redirection vers la route menant à la page d'accueil
                // Puis, arrêter l'exécution du script.7
            return $this->redirectToRoute('app_contact_index');
        }

        // 3. Passer la partie visible de ce formulaire à la vue, pour affichage.
        return $this->render('contact/edit.html.twig', [
            "form" => $form->createView(),
            "contact" => $contact
        ]);
    }

}