<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderTrackingInformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trackingNumber', TextType::class, [
                'label' => 'Numéro de suivi'
            ])
            ->add('trackingLink', TextType::class, [
                'label' => 'Lien de suivi direct'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'validate' => true,
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
            'data_class' => Order::class,
        ]);
    }
}
