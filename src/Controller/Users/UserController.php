<?php

namespace App\Controller\Users;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/users', 'users')]
class UserController extends AbstractController

{
    public function __construct(
        private UsersRepository $userRepo,
        private EntityManagerInterface $em
    ) {
    }

    #[Route('/profil/{id}', '.profile', methods: ['GET'])]
    public function show(Request $request, Users $id): Response|RedirectResponse

    {
        $userForm = $this->getUser();
        $form = $this->createForm(UserType::class, $userForm, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($userForm);
            $this->em->flush();
        }


        return $this->render(
            'Users/user/profile.html.twig',
            [
                'user' => $id,
                'form' => $form,
                'commentaries' => $this->userRepo->findOneById($id)->getCommentaries(),
                'comments' => $this->userRepo->findOneById($id)->getPostComments()
            ]
        );
    }

    #[Route('/{id}/edit', '.edit', methods: ['GET', 'POST'])]
    public function edit(?Users $user, Request $request): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('admin.users.index');
        }
        $userId = $user->getId();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès');

            return $this->redirectToRoute('users.index');
        }

        return $this->render(
            'Users/user/edit.html.twig',
            [
                'form' => $form,
                'user' => $this->userRepo->findOneById($userId)
            ]
        );
    }

    #[Route('/{id}/delete', '.delete', methods: ['POST'])]
    public function delete(?Users $user, Request $request): RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('users.profile');
        }
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            $this->em->remove($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        } else {
            $this->addflash('error', 'token CSRF invalide');
        }

        return $this->redirectToRoute('books.index');
    }
}
