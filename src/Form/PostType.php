<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Titre de l\'article',
                    'required' => false,
                    'attr' => ['class' => 'formItem']
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => 'Corps de l\'article',
                    'required' => false,
                    'attr' => [
                        'class' => 'formItem',
                        'rows' => 10
                    ]
                ]
            )

            ->add(
                'enable',
                CheckboxType::class,
                [
                    'label' => 'Publier l\'article',
                    'required' => false,
                    'attr' => ['class' => 'formItem']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'sanitize_html' => true,
            'isAdmin' => false
        ]);
    }
}
