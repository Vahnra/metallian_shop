<?php

namespace App\Form;

use App\Entity\UserPostalAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserAdressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé de l\'adresse',
                'empty_data' => 'Domicile',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('additionalAdress', TextType::class, [
                'label' => 'Complément d\'addresse',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('postCode', TextType::class, [
                'label' => 'Code Postal',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter cette adresse',
                'validate' => true,
                'attr' => [
                    'class' => 'd-block my-3 col-6 btn btn-success'
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
