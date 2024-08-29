<?php

namespace App\Controller\Users;


use App\Entity\Publisher;
use App\Repository\PublisherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('publisher', 'publishers')]
class PublisherController extends AbstractController

{
    public function __construct(
        private PublisherRepository $publiRepo,
        private EntityManagerInterface $em
    ) {}

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('Users/publishers/index.html.twig', [
            'publishers' => $this->publiRepo->findBy([], ['Name' => 'ASC'])
        ]);
    }

    #[Route('/{id}/details', '.details', methods: ['GET'])]
    public function show(?Publisher $publisher): Response|RedirectResponse

    {
        $publisherId = $publisher->getId();


        return $this->render(
            'Users/publishers/details.html.twig',
            [
                'publisher' => $this->publiRepo->findOneById($publisherId),

            ]
        );
    }
}
