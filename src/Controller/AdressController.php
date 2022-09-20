<?php

namespace App\Controller;

use DateTime;
use App\Entity\Cart;
use App\Entity\User;
use App\Entity\UserPostalAdress;
use App\Form\UserAdressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdressController extends AbstractController
{
    #[Route('/checkout/adress-{user}-{cart}', name: 'choose_adress', methods:['GET', 'POST'])]
    public function chooseAdress(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $cart = $entityManager->getRepository(Cart::class)->findBy([
            'id' => $request->get('cart')
        ]);

        $cartProducts = null;

        $numberOfItem = null;

        if ($cart !== null) {
            $numberOfItem = $cart[0]->getCartProduct()->count();
        }

        if ($cart !== null) {
            $cartProducts = $cart[0]->getCartProduct()->toArray();
        }

        $totalPrice = 0;

        // Boucle pour récuper le prix total de tout les produits du panier
        if ($numberOfItem !== null) {
            foreach ($cartProducts as $value) {
                $totalPrice = $totalPrice + ($value->getPrice() * $value->getQuantity());
            }
        }

        $userPostAdress = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['user' => $user->getId()]);

        $formUpdate = $this->createForm(UserAdressFormType::class, $userPostAdress)->handleRequest($request);

        if($formUpdate->isSubmitted() && $formUpdate->isValid()) {

            $userPostAdress->setUpdatedAt(new DateTime());

            $entityManager->persist($userPostAdress);
            $entityManager->flush();

            return $this->redirectToRoute('choose_adress', [
                'user' => $user->getId(),
                'cart' => $request->get('cart')
            ]);
        }

        return $this->render('adress/enter_adress.html.twig', [
            'userPostAdress' => $userPostAdress,
            'formUpdate' => $formUpdate->createView(),
            'numberOfItem' => $numberOfItem,
            'totalPrice' => $totalPrice,
            'cartProducts' => $cartProducts,
            'cart' => $request->get('cart')
        ]);
    }

    #[Route('/checkout/new-adress-{user}-{cart}', name: 'new_adress', methods:['GET', 'POST'])]
    public function newAdress(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $cart = $entityManager->getRepository(Cart::class)->findBy([
            'id' => $request->get('cart')
        ]);

        $adress = new UserPostalAdress();

        $userPostAdress = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['user' => $user->getId()]);

        $formAdd = $this->createForm(UserAdressFormType::class, $adress)->handleRequest($request);

        if($formAdd->isSubmitted() && $formAdd->isValid()) {

            $adress->setCreatedAt(new DateTime());
            $adress->setUpdatedAt(new DateTime());
            $adress->setUser($user);

            $entityManager->persist($adress);
            $entityManager->flush();

            return $this->redirectToRoute('choose_adress', [
                'user' => $user->getId(),
                'cart' => $request->get('cart')
            ]);
        }

        return $this->render('adress/new_adress.html.twig', [
            'userPostAdress' => $userPostAdress,
            'formAdd' => $formAdd->createView(),
            'cart' => $cart
        ]);
    }
}
