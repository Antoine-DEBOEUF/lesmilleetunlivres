<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Commentaries;
use App\Form\CommentaryType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/books', 'admin.books')]
class BookController extends AbstractController

{
    public function __construct(
        private BookRepository $bookRepo,
        private EntityManagerInterface $em
    ) {}


    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    { {
            $book = new Book;
            $form = $this->createForm(BookType::class, $book);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($book);
                $this->em->flush();

                $this->addFlash('success', 'La fiche du livre a bien été créé');

                return $this->redirectToRoute('books.index');
            }

            return $this->render('admin/books/create.html.twig', ['form' => $form]);
        }
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Book $book, Request $request): Response|RedirectResponse
    {
        if (!$book) {
            $this->addFlash('error', 'Livre non trouvé');
            return $this->redirectToRoute('books.index');
        }

        $form = $this->createForm(BookType::class, $book, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($book);
            $this->em->flush();

            $this->addFlash('success', 'Fiche du livre modifiée avec succès');

            return $this->redirectToRoute('books.details', ['id' => $book->getId()]);
        }

        return $this->render(
            'admin/books/edit.html.twig',
            [
                'form' => $form,
                'book' => $book
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Book $book, Request $request): RedirectResponse
    {
        if (!$book) {
            $this->addFlash('error', 'Livre non trouvé');
            return $this->redirectToRoute('books.index');
        }
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('token'))) {
            $this->em->remove($book);
            $this->em->flush();

            $this->addFlash('success', 'Fiche livre supprimée avec succès');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('books.index');
    }
}
