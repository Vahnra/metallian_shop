<?php

namespace App\Form;

use App\Entity\CartProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CartProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'data' => '1',
                'attr' => [
                    'min' => '1'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter au panier',
                'attr' => [
                    'class' => 'btn btn-success no-border-radius border-0 mt-1',
                    'style' => 'background-color: rgb(10, 19, 32); width: 100%'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartProduct::class,
        ]);
    }
}
