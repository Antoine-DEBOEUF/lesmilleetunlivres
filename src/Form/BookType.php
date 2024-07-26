<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Categories;
use App\Entity\Publisher;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Renseignez le titre du livre'])
                    ],
                    'attr' => ['class' => 'formItem'],
                ]
            )

            ->add(
                'author',
                EntityType::class,
                [
                    'label' => 'Auteur(s) :',
                    'class' => Author::class,
                    'choice_label' => 'FullName',
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.Name', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                    'autocomplete' => true,
                    'by_reference' => true,
                    'constraints' => [
                        new NotBlank(['message' => 'Sélectionnez un auteur à associer à ce livre'])
                    ],
                    'attr' => ['class' => 'formItem'],
                ]
            )

            ->add(
                'publisher',
                EntityType::class,
                [
                    'label' => 'Editeur :',
                    'class' => Publisher::class,
                    'choice_label' => 'Name',
                    'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.Name', 'ASC');
                    },
                    'multiple' => false,
                    'expanded' => false,
                    'autocomplete' => true,
                    'by_reference' => true,
                    'constraints' => [
                        new NotBlank(['message' => 'Sélectionnez l\'éditeur de ce livre'])
                    ],
                    'attr' => ['class' => 'formItem'],
                ]
            )

            ->add(
                'isbn',
                TextType::class,
                [
                    'label' => 'ISBN :',
                    'required' => false,
                    'constraints' => [new NotBlank(['message' => 'Renseignez l\'ISBN du livre'])],
                    'attr' => ['class' => 'formItem'],
                ]
            )

            ->add(
                'publishing_date',
                NumberType::class,
                [
                    'label' => 'Paru en :',
                    'required' => false,
                    'constraints' => [new NotBlank(['message' => 'Renseignez l\'année de parution du livre'])],
                    'attr' => ['class' => 'formItem'],
                ]
            )

            ->add(
                'synopsis',
                TextareaType::class,
                [
                    'label' => 'Synopsis :',
                    'required' => false,
                    'attr' => ['rows' => 10],
                    'attr' => ['class' => 'formItem'],

                ]
            )

            ->add('Categories', EntityType::class, [
                'label' => 'Catégorie(s) :',
                'class' => Categories::class,
                'choice_label' =>  'title',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'expanded' => true,
                'multiple' => true,
                'by_reference' => true,
                'autocomplete' => true,
                'attr' => ['class' => 'formItem'],
            ])

            ->add(
                'bookCover',
                VichImageType::class,
                [
                    'label' => 'Page de couverture :',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'Supprimer la couverture actuelle',
                    'image_uri' => true,
                    'attr' => ['class' => 'formItem'],
                    'download_uri' => false,

                ]
            )


            ->add(
                'enable',
                CheckboxType::class,
                [
                    'label' => 'Publier la fiche',
                    'required' => false,
                    'attr' => ['class' => 'formItem'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'sanitize_html' => true,
            'isAdmin' => false
        ]);
    }
}
