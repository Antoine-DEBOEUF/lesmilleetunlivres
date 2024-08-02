<?php

namespace App\Controller\Admin;

use App\Entity\PostComment;
use App\Form\PostCommentType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostCommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/post/comment', 'admin.post.comment')]
class PostCommentController extends AbstractController

{

    public function __construct(
        private EntityManagerInterface $em,
        private PostCommentRepository $commentRepo

    ) {
    }


    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?PostComment $comment, Request $request): Response|RedirectResponse
    {

        $commentId = $comment->getId();

        $form = $this->createForm(PostCommentType::class, $comment, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($comment);
            $this->em->flush();

            $this->addFlash('success', 'Commentaire modifié avec succès');

            return $this->redirectToRoute('post.details', ['id' => $comment->getPost()->getId()]);
        }

        return $this->render(
            'users/comment/edit.html.twig',
            [
                'form' => $form,
                'comment' => $this->commentRepo->findOneById($commentId),
                'post' => $comment->getPost()
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?PostComment $comment, ?Request $request): RedirectResponse
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
        return $this->redirectToRoute('post.details', ['id' => $comment->getPost()->getId()]);
    }
}
