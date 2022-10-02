<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail'
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Civilité',
                'expanded' => true,
                'choices' => [
                    "Homme" => 'homme',
                    "Femme" => 'femme'
                ],
                'choice_attr' => [
                    "Homme" => ['selected' => true],
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Votre mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        // 'placeholder' => 'Votre mot de passe'
                    ],
                ],
                'second_options' => [
                    'label' => 'Répetez le mot de passe',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        // 'placeholder' => 'Répetez le mot de passe'
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'validate' => false,
                'attr' => [
                    'class' => 'btn btn-lg no-border-radius',
                    'style' => 'padding-left: 2.5rem; padding-right: 2.5rem ;color: white; background-color: #cd0019'
                ]
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
