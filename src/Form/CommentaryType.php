<?php

namespace App\Form;

use App\Entity\Commentaries;
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
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Cliquez ici pour rédiger votre texte',
                        'rows' => 10,
                        'class' => 'formItem'
                    ]
                ]
            );

        if ($options['isAdmin']) {
            $builder
                ->add(
                    'enable',
                    CheckboxType::class,
                    [
                        'label' => 'Visibilité publique ?',
                        'required' => false,
                        'attr' => ['class' => 'formItem'],
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
