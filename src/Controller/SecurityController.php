<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {


        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/redirect', name: 'app_redirect_after_login', methods: ['GET', 'POST'])]
    public function redirectAfterLogin(): Response
    {
        /**
         * @var Users
         */
        $user = $this->getUser();

        if (!$user->isVerified()) {
            return $this->redirectToRoute('app_email_unverified');
        }

        return $this->redirectToRoute('post.index');
    }

    #[Route('/email_unverified', name: 'app_email_unverified', methods: ['GET'])]
    public function emailUnverified(): Response
    {
        return $this->render('login/unverifiedEmail.html.twig');
    }
}
