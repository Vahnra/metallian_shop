<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\RegisterFormType;
use App\Form\UserInfoFormType;
use App\Form\UserMailFormType;
use App\Entity\FavoriteProduct;
use App\Entity\Order;
use App\Entity\UserPostalAdress;
use App\Form\UserAdressFormType;
use Symfony\Component\Mime\Email;
use App\Form\UserPasswordFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class UserController extends AbstractController
{
    #[Route('/inscription', name: 'user_register', methods:['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer): Response
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

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'verify_email',
                $user->getId(),
                $user->getEmail(),
                ['id' => $user->getId()]
            );

            $message = (new TemplatedEmail())
                ->from(new Address('test@ornchanarong.com', 'Metallian Store'))
                ->to($user->getEmail())
                ->subject('Vérifiez votre mail pour créer votre compte Metallian Eshop')
                ->htmlTemplate('email/verification_mail.html.twig')
                ->context([
                    'link' => $signatureComponents->getSignedUrl(),
                    'user' => $user
                ]);

            $mailer->send($message);

            $this->addFlash('Mail Vérification', "Un mail de confirmation vous a été envoyé");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/verify', name:"verify_email")]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }

        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                $user->getId(),
                $user->getEmail(),
            );
        }   catch (VerifyEmailExceptionInterface $e) {
                $this->addFlash('error', $e->getReason());
                return $this->redirectToRoute('user_register');
            }

        $user->setIsVerified(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
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
    public function showProfileAdress(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $adress = new UserPostalAdress();

        $userPostAdresses = $entityManager->getRepository(UserPostalAdress::class)->findBy(['user' => $user->getId()]);

        $formAdd = $this->createForm(UserAdressFormType::class, $adress)->handleRequest($request);

        $formUpdate = $this->createForm(UserAdressFormType::class, $adress)->handleRequest($request);

        if($formAdd->isSubmitted() && $formAdd->isValid()) {

            $adress->setCreatedAt(new DateTime());
            $adress->setUpdatedAt(new DateTime());
            $adress->setUser($user);

            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('show_profile_adress', [
                'id' => $user->getId()
            ]);
        }

        if($formUpdate->isSubmitted() && $formUpdate->isValid()) {

            $adress->setUpdatedAt(new DateTime());

            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('show_profile_adress', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/show_profile_adress.html.twig', [
            'userPostAdresses' => $userPostAdresses,
            'formAdd' => $formAdd->createView(),
            'formUpdate' => $formUpdate->createView(),
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}/orders', name: 'show_profile_orders', methods:['GET', 'POST'])]
    public function showProfileOrders(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $orders = $entityManager->getRepository(Order::class)->findBy(['user' => $user]);

        return $this->render('user/show_profile_orders.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}/delete-adress-{id2}', name: 'hard_delete_adress', methods:['GET', 'POST'])]
    public function hardDeleteAdress(User $user, EntityManagerInterface $entityManager, Request $request)
    {
        $userPostAdressesId = $request->get('id2');

        $userPostAdresses = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['id' => $userPostAdressesId]);

        $entityManager->remove($userPostAdresses);
        $entityManager->flush();

        return $this->redirectToRoute('show_profile_adress', [
            'id' => $user->getId()
        ]);
    }

    #[Route('/profile/mon-espace-perso-{id}/favorite', name: 'show_favorite_products', methods:['GET', 'POST'])]
    public function showFavoriteProducts(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        PaginatorInterface $paginator,
        ): Response
    {
        $favoriteProducts = $entityManager->getRepository(FavoriteProduct::class)->findBy(['user' => $this->getUser()]);

        $requestStack = $requestStack->getMainRequest();

        $page = $requestStack->query->getInt('page', 1);

        $searchResults = $paginator->paginate($favoriteProducts, $page, 6);

        return $this->render('user/show_profile_favorites.html.twig',[
            'favoriteProducts' => $searchResults
        ]);
    }
}
