<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'Name',
                TextType::class,
                [
                    'label' => 'Nom :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Renseignez le nom de l\'auteur'])
                    ],
                    'attr' => ['class' => 'formItem'],
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Prénom(s) :',
                    'required' => false,
                    'attr' => ['class' => 'formItem'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'sanitize_html' => true
        ]);
    }
}
