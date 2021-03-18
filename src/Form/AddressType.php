<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'adresse à ajouter',
                'attr' => [
                    'placeholder' => 'Ex: Domicile, Travail, Boite Postal, etc ...'
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,  // Maximum conseillé par Symfony pour ne pas buguer
                        'minMessage' => 'Veuillez saisir un prénom qui contient au minimum {{ limit }} caractères',
                        'maxMessage' => 'Veuillez saisir un prénom qui contient au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,  // Maximum conseillé par Symfony pour ne pas buguer
                        'minMessage' => 'Veuillez saisir un nom qui contient au minimum {{ limit }} caractères',
                        'maxMessage' => 'Veuillez saisir un nom qui contient au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('company', TextType::class, [
                'label'=>'Nom de votre société',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir le nom de votre société (facultatif)'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr'=> [
                    'placeholder'=> 'Veuillez saisir votre adresse'
                ]
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code Postal',
                'attr'=> [
                    'placeholder'=> 'Veuillez saisir votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr'=> [
                    'placeholder'=> 'Veuillez saisir votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr'=> [
                    'placeholder'=> 'Veuillez saisir votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'Valider mon adresse',
                'attr' => [
                    'class' => 'button foat-right delivery-btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
