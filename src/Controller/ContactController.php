<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ContactRequest;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	/**
	* @Route("/contactez-nous", name="contact")
	*/
	public function index(Request $request): Response
	{
		$contactRequest = new ContactRequest();

		$form = $this->createForm(ContactType::class, $contactRequest);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			//récupération des données saisies par l'user
			$contactRequest = $form->getData();
			$contactRequestAuthorLastname = $form->get('authorLastname')->getData();
			$contactRequestAuthorFirstname = $form->get('authorFirstname')->getData();
			$contactRequestAuthorEmail = $form->get('authorEmail')->getData();
			$contactRequestContent = $form->get('content')->getData();
			//Hydratation de la date de demande
			$contactRequest->setCreatedAt(new \DateTime());
			//Enregistrement du message  en BDD
			$this->entityManager->persist($contactRequest);
			$this->entityManager->flush();

			$contentEmail = 'Bonjour Bosse !<br> Vous avez reçu une nouvelle demande de contacte sur votre site de la part de '.$contactRequestAuthorFirstname.' '.$contactRequestAuthorLastname.' ('.$contactRequestAuthorEmail.') <br><br>';
			$contentEmail .= 'Voici le message: <br><strong>'. $contactRequestContent.'</strong>';
			//Envoi d'un email à l'équipe my moms box
			//TODO: changer l'email
			$email = new Mail();
			$email->send('mymomsbox7@gmail.com', 'La bosse', 'Nouvelle demande de contacte', $contentEmail);

			$this->addFlash('notice', 'Votre message a bien été enregistré. My Mom\'s Box fais le nécessaire pour vous répondre dans les meilleurs délais. Merci. ');



		} else{
			$this->addFlash('notice', 'L\'enregistrement de votre message a échoue. My Mom\'s Box vous invite à réessayer ultérieurement.');
		}

		return $this->render('contact/contact.html.twig', [
			'form' => $form->createView()
		]);
	}
}
