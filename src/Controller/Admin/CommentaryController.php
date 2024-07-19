<?php

namespace App\Controller\Admin;

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

#[Route('/admin/commentaries', 'admin.commentaries')]
class CommentaryController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private CommentariesRepository $commentRepo

    ) {
    }


    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Commentaries $commentary, Request $request): Response|RedirectResponse
    {

        $commentaryId = $commentary->getId();

        $form = $this->createForm(CommentaryType::class, $commentary, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($commentary);
            $this->em->flush();

            $this->addFlash('success', 'Avis modifié avec succès');

            return $this->redirectToRoute('books.details', ['id' => $commentary->getBook()->getId()]);
        }

        return $this->render(
            'admin/commentary/edit.html.twig',
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
            return $this->redirectToRoute('books.index');
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
