<?php

namespace App\Form;

use App\Entity\Commentaries;
use App\Entity\book;
use App\Entity\users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'content',
                TextareaType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => ['placeholder' => 'Votre commentaire', 'rows' => 10]
                ]
            );

        if ($options['isAdmin']) {
            $builder
                ->add(
                    'enable',
                    CheckboxType::class,
                    [
                        'label' => 'Actif',
                        'required' => false
                    ]
                );
        };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaries::class,
            'sanitize_html' => true,
            'isAdmin' => false
        ]);
    }
}
