<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom'
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Votre numéro de téléphone'
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label' => 'Votre date de naissance',
                'input' => 'datetime'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier votre profile',
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
