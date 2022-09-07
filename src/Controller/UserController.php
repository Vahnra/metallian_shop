<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function showProfile(User $user, EntityManagerInterface $entityManager): Response
    {
        return $this->render('user/show_profile.html.twig', [
            
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
