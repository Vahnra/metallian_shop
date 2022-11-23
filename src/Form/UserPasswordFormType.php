<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword',PasswordType::class, [
                'label' => 'Votre ancien mot de passe',
                'mapped' => false
            ])
            ->add('password', RepeatedType::class, [
                'label' => 'Votre nouveau mot',
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe doit être le même.',
                'required' => true,
                'first_options'  => ['label' => 'Votre nouveau mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier votre mot de passe',
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
