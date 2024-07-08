<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Entity\Publisher;
use App\Form\PublisherType;
use App\Repository\AuthorRepository;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/publisher', 'admin.publishers')]
class PublisherController extends AbstractController

{
    public function __construct(
        private PublisherRepository $publiRepo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('admin/publishers/index.html.twig', [
            'publishers' => $this->publiRepo->findAll()
        ]);
    }

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    { {
            $publisher = new Publisher;
            $form = $this->createForm(PublisherType::class, $publisher);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($publisher);
                $this->em->flush();

                $this->addFlash('success', 'La fiche de l\'éditeur a bien été créé');

                return $this->redirectToRoute('admin.publishers.index');
            }

            return $this->render('admin/publishers/create.html.twig', ['form' => $form]);
        }
    }

    #[Route('/{id}/profil', '.profile', methods: ['GET'])]
    public function show(?Publisher $publisher): Response|RedirectResponse

    {
        $publisherId = $publisher->getId();

        return $this->render(
            'admin/publishers/profile.html.twig',
            [
                'publisher' => $this->publiRepo->findOneById($publisherId)
            ]
        );
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Publisher $publisher, Request $request): Response|RedirectResponse
    {
        if (!$publisher) {
            $this->addFlash('error', 'Editeur non trouvé');
            return $this->redirectToRoute('admin.publisher.index');
        }
        $publisherId = $publisher->getId();

        $form = $this->createForm(PublisherType::class, $publisher, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($publisher);
            $this->em->flush();

            $this->addFlash('success', 'Fiche éditeur modifiée avec succès');

            return $this->redirectToRoute('admin.publisher.index');
        }

        return $this->render(
            'Admin/Publishers/edit.html.twig',
            [
                'form' => $form,
                'publisher' => $this->publiRepo->findOneById($publisherId)
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Publisher $publisher, Request $request): RedirectResponse
    {
        if (!$publisher) {
            $this->addFlash('error', 'Fiche éditeur non trouvé');
            return $this->redirectToRoute('admin.publishers.index');
        }
        if ($this->isCsrfTokenValid('delete' . $publisher->getId(), $request->request->get('token'))) {
            $this->em->remove($publisher);
            $this->em->flush();

            $this->addFlash('success', 'Fiche éditeur supprimée avec succès');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('admin.publishers.index');
    }
}
