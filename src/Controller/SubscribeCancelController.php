<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte/je-m-abonne/erreur/{stripeSessionId}", name="subscribe_cancel")
     */
    public function index($stripeSessionId): Response
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$subscription || $subscription->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //Envoi d'un email à l'user notifiant l'echec de paiement

        return $this->render('subscribe_cancel/reset_password.html.twig', [
            'subscription' => $subscription
        ]);
    }
}
