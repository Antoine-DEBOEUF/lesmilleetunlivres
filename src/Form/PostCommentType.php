<?php

namespace App\Form;

use App\Entity\PostComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['isOwner']) {
            $builder
                ->add(
                    'title',
                    TextType::class,
                    [
                        'label' => 'Titre (facultatif) :',
                        'required' => false,
                        'attr' => ['class' => 'formItem']
                    ]
                )

                ->add(
                    'content',
                    TextareaType::class,
                    [
                        'label' => 'Votre commentaire :',
                        'required' => false,
                        'attr' => ['class' => 'formItem']
                    ]
                );
        }

        if ($options['isAdmin']) {
            $builder
                ->add(
                    'enable',
                    CheckboxType::class,
                    [
                        'label' => 'Visibilité publique ?',
                        'required' => false,
                        'attr' => ['class' => 'formItem']

                    ]
                );
        };;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostComment::class,
            'isAdmin' => false,
            'isOwner' => false,
            'sanitize_html' => true
        ]);
    }
}
