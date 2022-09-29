<?php

namespace App\Controller\Admin;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct( UserPasswordHasherInterface $passwordEncoder ) {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield FormField::addPanel('Détail de l\'utilisateur');
        yield TextField::new('lastname', 'Nom');
        yield TextField::new('firstname', 'Prénom');
        yield EmailField::new('email', 'E-mail');
        yield ChoiceField::new('gender', 'Sexe')->renderExpanded()->setChoices([
            'Homme' => 'homme',
            'Femme' => 'femme',
        ]);
        yield FormField::addPanel('Roles');
        // yield ChoiceField::new('roles')->allowMultipleChoices()->setChoices([
        //     'User' => 'ROLE_USER',
        //     'Admin' => 'ROLE_ADMIN',
        // ]);
        $roles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN', ];
        yield ChoiceField::new('roles')
            ->setChoices(array_combine($roles, $roles))
            ->allowMultipleChoices()
            ->renderExpanded()
            ->renderAsBadges();
        yield FormField::addPanel('Mot de passe');
        yield Field::new('password')->onlyOnForms()->hideWhenUpdating()->setFormType( RepeatedType::class )->setFormTypeOptions( [
            'type'            => PasswordType::class,
            'first_options'   => [ 'label' => 'Le mot de passe' ],
            'second_options'  => [ 'label' => 'Répétez le mot de passe' ],
            'error_bubbling'  => true,
            'invalid_message' => 'Le mot de passe n\'est pas identique',
        ] );
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->hideOnForm();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
        ->add(TextFilter::new('lastname'))
        ->add(TextFilter::new('firstname'))
        ->add(TextFilter::new('email'))
        ->add(TextFilter::new('gender'))
        ->add(TextFilter::new('roles'))
        ->add(DateTimeFilter::new('createdAt'))
        ->add(DateTimeFilter::new('updatedAt'));
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof User) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }
    
    public function createNewFormBuilder( EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context ): FormBuilderInterface 
    {
        $formBuilder = parent::createNewFormBuilder( $entityDto, $formOptions, $context );
        $this->addEncodePasswordEventListener( $formBuilder );

        return $formBuilder;
    }
    
    // fonction pour encoder le mot de passe
    protected function addEncodePasswordEventListener( FormBuilderInterface $formBuilder, $plainPassword = null ): void 
    {
        $formBuilder->addEventListener( FormEvents::SUBMIT, function ( FormEvent $event ) use ( $plainPassword ) {

            /** @var User $user */
            $user = $event->getData();
            if ( $user->getPassword() !== $plainPassword ) {
                $user->setPassword( $this->passwordEncoder->hashPassword( $user, $user->getPassword() ) );
            }
            
        } );
    }
}
