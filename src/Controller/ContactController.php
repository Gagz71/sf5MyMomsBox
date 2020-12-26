<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
	/**
	* @Route("/contactez-nous", name="contact")
	*/
	public function index(Request $request): Response
	{
		$form = $this->createForm(ContactType::class);
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){


			$content = $form->getData();
			$mail = new Mail();
			$mail->send('dmanhouli@gmail.com', 'My Mom\'s Box', 'Vous avez reçu une nouvelle demande de contacte', $content);

			$this->addFlash('notice', 'Votre message a bien été enregistré. My Mom\'s Box fais le nécessaire pour vous répondre dans les meilleurs délais. Merci. ');

		}

		return $this->render('contact/contact.html.twig', [
			'form' => $form->createView()
		]);
	}
}
