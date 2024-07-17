<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Nom d\'utilisateur :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Choisissez un nom d\'utilisateur'])
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Votre email :',
                    'required' => false,
                    'constraints' => [
                        new NotBlank(['message' => 'Renseignez un email'])
                    ]
                ]
            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'Mot de passe :',
                'required' => false,
                'mapped' => false,
                'invalid_message' => "les mots de passe ne correspondent pas",
                'first_options' => [
                    'label' => "Mot de passe :",
                    'constraints' => [
                        new Assert\NotBlank(['message' => 'Indiquez un mot de passe']),
                        new Assert\Length([
                            'max' => 4096
                        ]),
                        new Assert\Regex(
                            pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                        )
                    ]
                ],
                'second_options' => ['label' => "Confirmation du mot de passe :"]

            ])
            ->add(
                'avatarImg',
                VichImageType::class,
                [
                    'label' => 'Votre avatar',
                    'required' => false,
                    'allow_delete' => true,
                    'delete_label' => 'Supprimer l\'avatar actuel',
                    'image_uri' => true,
                    'download_uri' => false,
                ]
            );

        if ($options['isAdmin']) {
            $builder
                ->remove('password')
                ->remove('username')
                ->remove('avatarImg')
                ->remove('email')
                ->add(
                    'roles',
                    ChoiceType::class,
                    [
                        'label' => 'Roles :',
                        'choices' => [
                            'Utilisateur' => 'ROLE_USER',
                            'Administrateur' => 'ROLE_ADMIN',
                        ],
                        'expanded' => true,
                        'multiple' => true,
                    ]
                )
                ->add(
                    'enable',
                    CheckboxType::class,
                    [
                        'label' => 'Actif (décochez la case pour suspendre le compte) :',
                        'required' => false

                    ]
                );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'isAdmin' => false,
            'sanitize_html' => true
        ]);
    }
}
