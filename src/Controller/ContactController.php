<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_email', methods:['GET', 'POST'])]
    public function email(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('vahnra@gmail.com')
                ->subject('Vous avez reçu un email')
                ->text('Sender : ' . $contactFormData['email'] . ' ' . $contactFormData['message']);

            $mailer->send($message);

            $this->addFlash('success', 'Vore message a été envoyé');

            return $this->redirectToRoute('contact_email');
        }


        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
