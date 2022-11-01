<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Size;
use App\Entity\Color;
use App\Entity\Marques;
use App\Entity\Material;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VetementFilterFormType extends AbstractType
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $marques = $this->entityManager->getRepository(Marques::class)->findAll();

        $colors = $this->entityManager->getRepository(Color::class)->findAll();

        $materials = $this->entityManager->getRepository(Material::class)->findAll();

        $sizes = $this->entityManager->getRepository(Size::class)->findAll();

        $artist = $this->entityManager->getRepository(Artist::class)->findAll();
        
        $builder
            ->add('Couleur', ChoiceType::class, [
                'placeholder' => 'Choisir une couleur',
                'choices' => $colors,
                'choice_value' => 'id',
                'choice_label' => function(?Color $category) {
                    return $category ? $category->getColor() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: block; height: 10em; overflow-y: scroll'
                ],
                'required' => false,
                'label_attr' => [
                    'id' => 'color',
                    'class' => 'col-10',
                    'onclick' => 'showColorFilterVetement()',
                    'style' => 'cursor: pointer;'
                ],
            ])
            ->add('Size', ChoiceType::class, [
                'label' => 'Taille',
                'placeholder' => 'Choisir une taille',
                'choices'  => $sizes,
                'choice_value' => 'id',
                'choice_label' => function(?Size $category) {
                    return $category ? $category->getSize() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: block; height: 10em; overflow-y: scroll'
                ],
                'label_attr' => [
                    'id' => 'size',
                    'class' => 'col-10',
                    'onclick' => 'showSizeFilterVetement()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('material', ChoiceType::class, [
                'label' => 'Matière',
                'placeholder' => 'Choisir une matière',
                'choices'  => $materials,
                'choice_value' => 'id',
                'choice_label' => function(?Material $category) {
                    return $category ? $category->getMaterial() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'material',
                    'class' => 'col-10',
                    'onclick' => 'showMaterialFilterVetement()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('marque', ChoiceType::class, [
                'label' => 'Marques',
                'placeholder' => 'Choisir une marque',
                'choices'  => $marques,
                'choice_value' => 'id',
                'choice_label' => function(?Marques $category) {
                    return $category ? $category->getTitle() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'marque',
                    'class' => 'col-10',
                    'onclick' => 'showMarqueFilterVetement()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('artist', ChoiceType::class, [
                'label' => 'Artistes',
                'placeholder' => 'Choisir un artist',
                'choices'  => $artist,
                'choice_value' => 'id',
                'choice_label' => function(?Artist $category) {
                    return $category ? $category->getArtist() : '';
                },
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'no-border-radius col-12',
                    'style' => 'display: none;'
                ],
                'label_attr' => [
                    'id' => 'marque',
                    'class' => 'col-10',
                    'onclick' => 'showArtistFilterVetement()',
                    'style' => 'cursor: pointer;'
                ],
                'required' => false,
            ])
            ->add('priceMax', MoneyType::class, [
                'label' => 'Prix max',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('priceMini', MoneyType::class, [
                'label' => 'Prix mini',
                'divisor' => 100,
                'required' => false,
                'attr' => [
                    'class' => 'no-border-radius'
                ],
            ])
            ->add('Filtrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-dark btn-rounded waves-effect no-border-radius'
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
