<?php

namespace App\Controller\Users;

use App\Entity\Book;
use App\Entity\Commentaries;
use App\Form\CommentaryType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentariesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('commentaries', 'commentaries')]
class CommentaryController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private CommentariesRepository $commentRepo,
    ) {
    }

    #[Route('/', '.index', methods: ['GET'])]
    public function index(?Book $book): Response|RedirectResponse
    {
        if (!$book) {
            $this->addFlash('error', 'Fiche livre non trouvée');
            return $this->redirectToRoute('books.details');
        }

        return $this->render('Users/commentaries/index.html.twig', [
            'commentaires' => $book->getCommentaries()
        ]);
    }

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    { {
            $commentary = new Commentaries;
            $form = $this->createForm(CommentaryType::class, $commentary);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($commentary);
                $this->em->flush();

                $this->addFlash('success', 'Votre commentaire a bien été publié');

                return $this->redirectToRoute('books.details', ['id' => $commentary->getBook()->getId()]);
            }

            return $this->render('users/commentary/create.html.twig', ['form' => $form]);
        }
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Commentaries $commentary, Request $request): Response|RedirectResponse
    {

        $commentaryId = $commentary->getId();

        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($commentary);
            $this->em->flush();

            $this->addFlash('success', 'Avis modifié avec succès');

            return $this->redirectToRoute('books.details', ['id' => $commentary->getBook()->getId()]);
        }

        return $this->render(
            'users/commentary/edit.html.twig',
            [
                'form' => $form,
                'commentary' => $this->commentRepo->findOneById($commentaryId),
                'book' => $commentary->getBook()
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Commentaries $comment, ?Request $request): RedirectResponse
    {
        if (!$comment) {
            $this->addFlash('error', 'Commentaire non trouvé');
            return $this->redirectToRoute('books.details');
        }

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('token'))) {
            $this->em->remove($comment);
            $this->em->flush();

            $this->addFlash('success', 'Commentaire supprimé avec succès');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }
        return $this->redirectToRoute('books.details', ['id' => $comment->getBook()->getId()]);
    }
}
