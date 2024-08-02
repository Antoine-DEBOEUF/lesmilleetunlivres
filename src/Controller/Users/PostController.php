<?php

namespace App\Controller\Users;

use App\Entity\Post;
use App\Entity\PostComment;
use App\Form\PostCommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('', 'post')]
class PostController extends AbstractController
{
    public function __construct(
        private PostRepository $postRepo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('users/posts/index.html.twig', [
            'posts' => $this->postRepo->findAllOrderByDate(),
        ]);
    }

    #[Route('/{id}/details', '.details')]
    public function show(Post $post, Request $request): Response|RedirectResponse
    {
        $comment = new PostComment;
        $form = $this->createForm(PostCommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $comment
                ->setAuthor($user)
                ->setPost($post)
                ->setEnable(1);

            $this->em->persist($comment);
            $this->em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été publié');

            return $this->redirectToRoute('post.details', ['id' => $post->getId()]);
        }

        $postId = $post->getId();

        return $this->render(
            'users/posts/details.html.twig',
            [
                'post' => $this->postRepo->findOneById($postId),
                'form' => $form,
                'user' => $user
            ]
        );
    }
}
