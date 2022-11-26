<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SavFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'attr' => [
                    'rows' => 6
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne doit pas être vide'
                    ])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
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
            // Configure your form options here
        ]);
    }
}
