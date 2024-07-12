<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', 'admin.users')]
class UserController extends AbstractController

{
    public function __construct(
        private UsersRepository $userRepo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('', name: '.index')]
    public function index(): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $this->userRepo->findAll()
        ]);
    }
}
