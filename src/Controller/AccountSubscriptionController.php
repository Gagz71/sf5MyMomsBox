<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\SubscriptionPlan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountSubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte/mon-abonnement", name="account_subscription")
     */
    public function index(Request $request): Response
    {
        //récupération de l'abonnement
        $subscriptions = $this->entityManager->getRepository(Subscription::class)->findByUser($this->getUser());

        foreach ($subscriptions as $subscription)
        {
            $stripeSessionId = $subscription->getStripeSessionId();
        }

        return $this->render('account/subscription.html.twig', [
            'subscriptions' => $subscriptions,
            'stripeSessionId' => $stripeSessionId
        ]);
    }
}
