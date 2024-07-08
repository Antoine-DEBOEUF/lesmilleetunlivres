<?php

namespace App\Controller\Users;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/Author', 'authors')]
class AuthorController extends AbstractController

{
    public function __construct(
        private AuthorRepository $authorRepo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('Users/authors/index.html.twig', [
            'authors' => $this->authorRepo->findAll()
        ]);
    }

    #[Route('/{id}/profil', '.profile', methods: ['GET'])]
    public function show(?Author $author): Response|RedirectResponse

    {
        $authorId = $author->getId();

        return $this->render(
            'Users/authors/profile.html.twig',
            [
                'author' => $this->authorRepo->findOneById($authorId)
            ]
        );
    }
}