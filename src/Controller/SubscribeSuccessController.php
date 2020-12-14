<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte/je-m-abonne/merci/{stripeSessionId}", name="subscribe_success")
     */
    public function index($stripeSessionId): Response
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$subscription || $subscription->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        return $this->render('subscribe_success/index.html.twig', [
            'subscription' => $subscription,
        ]);
    }
}
