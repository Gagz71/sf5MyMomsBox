<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('birthdate', BirthdayType::class, [
                'disabled' => true,
                'label' => 'Ma date de naissance'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon e-mail'
            ])
            
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vous devez saisir le même mot de passe' ,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation de mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Saisissez votre nouveau mot de passe'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe de connexion',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                        'maxMessage' => 'Votre mot de passe est trop grand',
                    ]),
                    new Regex([
                        'pattern'=> '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ !"\#$%&\'\(\)*+,\-.\/:;<=>?@[\\^\]_`\{|\}~])^.{8,4096}$/',
                        'message' => 'Votre mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial'
                    ]),
                ]
            ])
            
            ->add('picture')
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour'
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
