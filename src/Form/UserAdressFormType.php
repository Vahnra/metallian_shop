<?php

namespace App\Form;

use App\Entity\UserPostalAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserAdressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé de l\'adresse',
                'empty_data' => 'Domicile',
                'empty_data' => 'Maison',
                'attr' => array(
                    'placeholder' => 'Maison',
                    'class' => 'no-border-radius',
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays',
                'choices' => [
                    'France' => 'France',
                ],
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('additionalAdress', TextType::class, [
                'label' => 'Complément d\'addresse',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
            ])
            ->add('postCode', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'no-border-radius',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter cette adresse',
                'validate' => false,
                'attr' => [
                    'class' => 'd-block my-3 mx-auto col-6 btn btn-success btn no-border-radius border-0',
                    'style' => 'color: white; background-color: #cd0019'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPostalAdress::class,
        ]);
    }
}
