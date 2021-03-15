<?php

namespace App\Form;

use App\Entity\Subscription;
use App\Entity\SubscriptionPlan;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('subscription', EntityType::class, [
                'label' => 'Sélectionnez votre abonnement',
                'required' => false,
                'class' => SubscriptionPlan::class,
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Je sélectionne cet abonnement',
                'attr' => [
                    'class' => 'btn btn-outline-success',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubscriptionPlan::class,
        ]);
    }
}
