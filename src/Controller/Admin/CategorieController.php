<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategorieType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categories', 'admin.categories')]
class CategorieController extends AbstractController

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
            'admin/categories/index.html.twig',
            ['categories' => $this->categRepo->findAllOrderByTitle()]
        );
    }

    #[Route('/create', '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    { {
            $categorie = new Categories;
            $form = $this->createForm(CategorieType::class, $categorie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($categorie);
                $this->em->flush();

                $this->addFlash('success', 'La catégorie a bien été créée');
                return $this->redirectToRoute('admin.categories.index');
            }

            return $this->render('admin/categories/create.html.twig', ['form' => $form]);
        }
    }

    #[Route('{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Categories $categorie, Request $request): Response|RedirectResponse
    {
        if (!$categorie) {
            $this->addFlash('error', 'Catégorie non trouvée');
            return $this->redirectToRoute('admin.categories.index');
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($categorie);
            $this->em->flush();

            $this->addFlash('success', 'Catégorie modifiée avec succès');

            return $this->redirectToRoute('admin.categories.index');
        }

        return $this->render(
            'admin/categories/edit.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Categories $categorie, Request $request): RedirectResponse
    {
        if (!$categorie) {
            $this->addFlash('error', 'Catégorie non trouvée');
            return $this->redirectToRoute('admin.categories.index');
        }
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('token'))) {
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie supprimée');
        } else {
            $this->addFlash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('admin.categories.index');
    }
}
