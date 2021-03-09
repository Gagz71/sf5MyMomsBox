<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('authorFirstname', TextType::class, [
				'label' => 'Votre prénom',
			])
			->add('authorLastname', TextType::class, [
				'label' => 'Votre nom'
			])
			->add('authorEmail', EmailType::class, [
				'label' => 'Votre email'
			])
			->add('subject', TextType::class, [
				'label' => 'Sujet de votre message'
			])
			->add('content', TextareaType::class, [
				'label' => 'Votre message'
			])
			->add('submit', SubmitType::class,[
				'label' => 'J\'envoie mon message',
				'attr' => [
					'class' => 'btn-outline-info float-right'
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
		    // Configure your form options here
		]);
	}
}
