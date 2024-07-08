<?php

namespace App\Controller\Users;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('categories', 'categories')]
class CategoryController extends AbstractController

{
    public function __construct(
        private CategoriesRepository $categRepo,
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', '.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            'Users/categories/index.html.twig',
            ['categories' => $this->categRepo->findAllOrderByTitle()]
        );
    }

    #[Route('/{id}/details', '.details', methods: ['GET'])]
    public function show(?Categories $category): Response|RedirectResponse

    {
        $categoryId = $category->getId();

        return $this->render(
            'Users/authors/profile.html.twig',
            [
                'author' => $this->categRepo->findOneById($categoryId)
            ]
        );
    }
}
