<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserMailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'label' => 'Votre nouveau mail',
                'type' => EmailType::class,
                'invalid_message' => 'Le mail doit être le même.',
                'required' => true,
                'first_options'  => ['label' => 'Mail'],
                'second_options' => ['label' => 'Répétez le mail'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier votre mail',
                'validate' => False,
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
