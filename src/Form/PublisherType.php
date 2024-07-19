<?php

namespace App\Form;

use App\Entity\Publisher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PublisherType extends AbstractType
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
                        new NotBlank(['message' => 'Renseignez le nom de l\'éditeur'])
                    ],
                    'attr' => ['class' => 'formItem'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publisher::class,
            'sanitize_html' => true
        ]);
    }
}
