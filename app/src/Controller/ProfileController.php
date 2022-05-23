<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Auth\RegistrationFormType;
use App\Form\Profile\EditPasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{

    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('profile/dashboard.html.twig');
    }

    #[Route('/mon-compte', name:'profile_edit')]
    public function editAccount (ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $form = $this->createForm(RegistrationFormType::class, $this->getUser());
        $form->remove('password');
        $form->remove('agreeTerms');
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                $this->addFlash('success', 'Votre compte a bien été modifié');

                return $this->redirectToRoute('dashboard');
            }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    #[Route('mon-compte/modifier-mon-mot-de-passe', name:"profile_edit_password")]
    public function editPassword(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $em = $doctrine->getManager();

        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordHasher->hashPassword($user, $form->get('password')->getData());
            $user->setPassword($password);
            $em->flush();
            $this->addFlash('success', 'Votre mot de passe a été modifié');

            return $this->redirectToRoute('dashboard');
        }

        return $this->renderForm('profile/edit_password.html.twig', [
            'form' => $form,
        ]);
    }
}