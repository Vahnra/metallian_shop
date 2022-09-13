<?php

namespace App\Controller;

use DateTime;
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
    #[Route('/adresse-{id}', name: 'choose_adress', methods:['GET', 'POST'])]
    public function chooseAdress(User $user, EntityManagerInterface $entityManager, Request $request): Response
    {
        $adress = new UserPostalAdress();

        $userPostAdresses = $entityManager->getRepository(UserPostalAdress::class)->findBy(['user' => $user->getId()]);

        $formAdd = $this->createForm(UserAdressFormType::class, $adress)->handleRequest($request);

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

        return $this->render('adress/enter_adress.html.twig', [
            'userPostAdresses' => $userPostAdresses,
            'formAdd' => $formAdd->createView(),
        ]);
    }
}
