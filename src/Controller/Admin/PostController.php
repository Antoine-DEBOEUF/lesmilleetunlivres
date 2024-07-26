<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/post', 'admin.post')]
class PostController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly PostRepository $postRepo

    ) {
    }

    #[Route('/create', name: '.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response
    {
        $post = new Post;
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setAuthor($user);

            $this->em->persist($post);
            $this->em->flush();

            $this->addFlash('success', 'L\'article a bien été créé');

            return $this->redirectToRoute('post.index');
        }

        return $this->render('admin/posts/create.html.twig', ['form' => $form]);
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?post $post, Request $request): Response|RedirectResponse
    {
        if (!$post) {
            $this->addFlash('error', 'Article non trouvé');
            return $this->redirectToRoute('posts.index');
        }

        $form = $this->createForm(PostType::class, $post, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();

            $this->addFlash('success', 'Article modifié avec succès');

            return $this->redirectToRoute('post.details', ['id' => $post->getId()]);
        }

        return $this->render(
            'admin/post/edit.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Post $post, Request $request): RedirectResponse
    {
        if (!$post) {
            $this->addFlash('error', 'Article non trouvé');
            return $this->redirectToRoute('post.index');
        }
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('token'))) {
            $this->em->remove($post);
            $this->em->flush();

            $this->addFlash('success', 'Article supprimé');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('post.index');
    }
}
