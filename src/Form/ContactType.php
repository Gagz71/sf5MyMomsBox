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
			->add('firstname', TextType::class, [
				'label' => 'Votre prénom',
			])
			->add('lastname', TextType::class, [
				'label' => 'Votre nom'
			])
			->add('email', EmailType::class, [
				'label' => 'Votre email'
			])
			->add('content', TextareaType::class, [
				'label' => 'Votre message'
			])
			->add('submit', SubmitType::class,[
				'label' => 'J\'envoie mon message'
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
