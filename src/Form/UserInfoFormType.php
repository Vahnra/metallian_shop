<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class UserInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label' => 'Votre date de naissance',
                'input' => 'datetime'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier votre profile',
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
