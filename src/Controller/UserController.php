<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\RegisterFormType;
use App\Form\UserInfoFormType;
use App\Form\UserMailFormType;
use App\Form\UserPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'user_register', methods:['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User;

        $form = $this->createForm(RegisterFormType::class, $user)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());

            $user->setPassword($passwordHasher->hashPassword(
                $user, $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}', name: 'show_profile', methods:['GET', 'POST'])]
    public function showProfile(User $user, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Form pour les infos perso
        $form = $this->createForm(UserInfoFormType::class, $user)->handleRequest($request);
        
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $this->getUser()]);

        if($form->isSubmitted() && $form->isValid()) {
            
            $user->setUpdatedAt(new DateTime());

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('show_profile', [
                'id' => $user->getId()
            ]);
        }

        // Form pour le mail

        $formMail = $this->createForm(UserMailFormType::class)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $user->setUpdatedAt(new DateTime());

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('show_profile', [
                'id' => $user->getId()
            ]);
        }

        // Form pour le nouveau mot de passe

        $formPassword = $this->createForm(UserPasswordFormType::class)->handleRequest($request);

        if($formPassword->isSubmitted() && $formPassword->isValid()) {
            
            $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $this->getUser()]);

            $user->setUpdatedAt(new DateTime());

            $user->setPassword($passwordHasher->hashPassword(
                $user, $formPassword->get('password')->getData()
                )
            );


            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "Votre mot de passe a bien été changé");
            return $this->redirectToRoute('show_profile', [
                'id' => $user->getId()
            ]);
        }
        
        return $this->render('user/show_profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formMail' => $formMail->createView(),
            'formPassword' => $formPassword->createView()
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}/adress', name: 'show_profile_adress', methods:['GET', 'POST'])]
    public function showProfileAdress(User $user, EntityManagerInterface $entityManager): Response
    {
        return $this->render('user/show_profile_adress.html.twig', [
            
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}/orders', name: 'show_profile_orders', methods:['GET', 'POST'])]
    public function showProfileOrders(User $user, EntityManagerInterface $entityManager): Response
    {
        return $this->render('user/show_profile_orders.html.twig', [
            
        ]);
    }
}
