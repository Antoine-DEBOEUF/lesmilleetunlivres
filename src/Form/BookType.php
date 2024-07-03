<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Favorites;
use App\Entity\Categories;
use App\Entity\BookCategories;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotNull;
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
                    ]
                ]
            )

            ->add(
                'author',
                EntityType::class,
                [
                    'label' => 'Auteur(s) :',
                    'class' => Author::class,
                    'choice_label' => function (Author $author): string {
                        return $author->getName();
                    },
                    'multiple' => true,
                    'expanded' => true,
                    'autocomplete' => true,
                    'by_reference' => true,
                    'constraints' => [
                        new NotBlank(['message' => 'Sélectionnez un auteur à associer à ce livre'])
                    ]
                ]
            )

            ->add(
                'isbn',
                TextType::class,
                [
                    'label' => 'ISBN :',
                    'required' => false,
                    'constraints' => [new NotBlank(['message' => 'Renseignez l\'ISBN du livre'])]
                ]
            )

            ->add(
                'publishing_date',
                NumberType::class,
                [
                    'label' => 'Paru en :',
                    'required' => false,
                    'constraints' => [new NotBlank(['message' => 'Renseignez l\'année de parution du livre'])]
                ]
            )

            ->add(
                'synopsis',
                TextareaType::class,
                [
                    'label' => 'Synopsis :',
                    'required' => false,
                    'attr' => ['rows' => 10]

                ]
            )

            ->add('Categories', EntityType::class, [
                'label' => 'Catégorie(s) :',
                'class' => Categories::class,
                'choice_label' =>  function (Categories $Categ): string {
                    return $Categ->getTitle();
                },
                // 'query_builder' => function (EntityRepository $er): QueryBuilder {
                //     return $er->createQueryBuilder('b')
                //         ->orderBy('b.Id', 'ASC');
                // },
                'expanded' => true,
                'multiple' => true,
                'by_reference' => true,
                'autocomplete' => true
            ])

            ->add(
                'File',
                VichImageType::class,
                [
                    'label' => 'Page de couverture :',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'Supprimer la couverture actuelle',
                    'image_uri' => true,
                    'download_uri' => false,
                ]
            )


            ->add(
                'active',
                CheckboxType::class,
                [
                    'label' => 'Publier la fiche',
                    'required' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'sanitize_html' => true
        ]);
    }
}
