<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/profile/order-{id}', name: 'order_detail')]
    public function orderDetail(Order $order): Response
    {
        return $this->render('user/show_profile_order_detail.html.twig', [
            'order' => $order
        ]);
    }
}
