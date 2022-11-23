<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserMailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Votre mot de passe',
                'mapped' => false
            ])
            ->add('email', RepeatedType::class, [
                'label' => 'Votre nouveau mail',
                'type' => EmailType::class,
                'invalid_message' => 'Le mail doit être le même.',
                'required' => true,
                'first_options'  => ['label' => 'Mail'],
                'second_options' => ['label' => 'Répétez le mail'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier votre mail',
                'validate' => False,
                'attr' => [
                    'class' => 'btn no-border-radius',
                    'style' => 'color: white; background-color: #cd0019'
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
