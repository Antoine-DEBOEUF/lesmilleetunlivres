<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/authors', 'admin.authors')]
class AuthorController extends AbstractController

{
    public function __construct(
        private AuthorRepository $authorRepo,
        private EntityManagerInterface $em
    ) {}

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    { {
            $author = new Author;
            $form = $this->createForm(AuthorType::class, $author);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($author);
                $this->em->flush();

                $this->addFlash('success', 'La fiche de l\'auteur a bien été créé');

                return $this->redirectToRoute('authors.index');
            }

            return $this->render('admin/authors/create.html.twig', ['form' => $form]);
        }
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Author $author, Request $request): Response|RedirectResponse
    {
        if (!$author) {
            $this->addFlash('error', 'Auteur non trouvé');
            return $this->redirectToRoute('authors.index');
        }
        $authorId = $author->getId();

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($author);
            $this->em->flush();

            $this->addFlash('success', 'Fiche auteur modifiée avec succès');

            return $this->redirectToRoute('authors.index');
        }

        return $this->render(
            'Admin/Authors/edit.html.twig',
            [
                'form' => $form,
                'author' => $this->authorRepo->findOneById($authorId)
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Author $author, Request $request): RedirectResponse
    {
        if (!$author) {
            $this->addFlash('error', 'Auteur non trouvé');
            return $this->redirectToRoute('authors.index');
        }
        if ($this->isCsrfTokenValid('delete' . $author->getId(), $request->request->get('token'))) {
            $this->em->remove($author);
            $this->em->flush();

            $this->addFlash('success', 'Fiche auteur supprimée avec succès');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('authors.index');
    }
}
