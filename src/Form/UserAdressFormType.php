<?php

namespace App\Form;

use App\Entity\UserPostalAdress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
                'empty_data' => 'Domicile'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays'
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('additionalAdress', TextType::class, [
                'label' => 'Complément d\'addresse'
            ])
            ->add('postCode', TextType::class, [
                'label' => 'Code Postal'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter cette adresse',
                'validate' => False,
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
