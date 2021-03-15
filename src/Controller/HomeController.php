<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ContactRequest;
use App\Entity\Header;
use App\Entity\Product;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
	public function index(Request $request): Response
	{
		$products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
		$headers = $this->entityManager->getRepository(Header::class)->findAll();

		//formulaire de contacte
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

			//Envoi d'un email à l'équipe my moms box
			$contentEmail = 'Bonjour Bosse !<br> Vous avez reçu une nouvelle demande de contacte sur votre site de la part de '.$contactRequestAuthorFirstname.' '.$contactRequestAuthorLastname.' ('.$contactRequestAuthorEmail.') <br><br>';
			$contentEmail .= 'Voici le message: <br><strong>'. $contactRequestContent.'</strong>';

			//TODO: changer l'email
			$email = new Mail();
			$email->send('mymomsbox7@gmail.com', 'La bosse', 'Nouvelle demande de contacte', $contentEmail);

			$this->addFlash('notice', 'Votre message a bien été enregistré. My Mom\'s Box fais le nécessaire pour vous répondre dans les meilleurs délais. Merci. ');

		}

		return $this->render('home/home.html.twig', [
			'products' => $products,
			'headers' => $headers,
			'form' => $form->createView()
		]);
	}
}
