<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\UserPostalAdress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    #[Route('/checkout/payment-{user}-{cart}', name: 'payment', methods:['GET', 'POST'])]
    public function payment(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $livraison = $request->get('postFee');

        $cart = $entityManager->getRepository(Cart::class)->findBy([
            'id' => $request->get('cart')
        ]);

        $userPostAdress = $entityManager->getRepository(UserPostalAdress::class)->findOneBy(['user' => $user->getId()]);

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

        $totalPriceFinal = $totalPrice + $livraison;

        $cart[0]->setTotalPrice($totalPrice);

        $entityManager->persist($cart[0]);
        $entityManager->flush();

        return $this->render('payment/payment.html.twig', [
            'userPostAdress' => $userPostAdress,
            'totalPriceFinal' => $totalPriceFinal,
            'livraison' => $livraison,
            'totalPrice' => $totalPrice,
            'cart' => $cart[0]
        ]);
    }
}
