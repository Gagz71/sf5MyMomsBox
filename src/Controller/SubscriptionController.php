<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Entity\SubscriptionPlan;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-abonnements", name="show_subscriptions")
     */
    public function show(): Response
    {
        $subscriptions = $this->entityManager->getRepository(SubscriptionPlan::class)->findAll();
        //Récupération des infos de l'abonnement mensuel
        $monthly_subscribe = $subscriptions[0];
        //Récupération des infos de l'abonnement trimestriel
        $trimester_subscribe = $subscriptions[1];
        //Récupération des infos de l'abonnement semestriel
        $semester_subscribe = $subscriptions[2];
        //Récupération des infos de l'abonnement annuel
        $year_subscribe = $subscriptions[3];

        return $this->render('subscription/show_subscribes.html.twig', [
            'controller_name' => 'SubscriptionController',
            'monthlySubscribe' => $monthly_subscribe,
            'trimesterSubscribe' => $trimester_subscribe,
            'semesterSubscribe' => $semester_subscribe,
            'yearSubscribe' => $year_subscribe,
        ]);
    }

    /**
     * @Route("/mon-compte/je-m-abonne-mensuellement", name="monthly_subscribe")
     */
    public function monthlySubscribe(Request $request)
    {
        $subscriptions = $this->entityManager->getRepository(SubscriptionPlan::class)->findAll();
        //Récupération des infos de l'abonnement mensuel
        $monthly_subscribe = $subscriptions[0];
        $user = $this->getUser();
        //Création et hydratation du nouvel abonnement
        $newSubscription = new Subscription();
        $newSubscription->setName($monthly_subscribe->getName());
        $newSubscription->setPrice($monthly_subscribe->getPrice());
        $newSubscription->setUser($user);
        $newSubscription->setPriceId('price_1Hv3ioLrKb2GsnXLxBdgERHd');
        //Enregistrement du nouvel abonnement
        $this->entityManager->persist($newSubscription);
        //$this->entityManager->flush();



        return $this->render('subscription/monthly_subscribe.html.twig');
    }

    /**
     * @Route("/mon-compte/je-m-abonne-trimestriel", name="trimester_subscribe")
     */
    public function trimesterSubscribe(Request $request)
    {
        $subscriptions = $this->entityManager->getRepository(SubscriptionPlan::class)->findAll();
        //Récupération des infos de l'abonnement mensuel
        $trimester_subscribe = $subscriptions[1];
        $user = $this->getUser();
        //Création et hydratation du nouvel abonnement
        $newSubscription = new Subscription();
        $newSubscription->setName($trimester_subscribe->getName());
        $newSubscription->setPrice($trimester_subscribe->getPrice());
        $newSubscription->setUser($user);
        $newSubscription->setPriceId('price_1Hv3jgLrKb2GsnXLLGjs3UmJ');
        //Enregistrement du nouvel abonnement
        $this->entityManager->persist($newSubscription);
        //$this->entityManager->flush();

        return $this->render('subscription/trimester_subscribe.html.twig');
    }

    /**
     * @Route("/mon-compte/je-m-abonne-semestriel", name="semester_subscribe")
     */
    public function semesterSubscribe(Request $request)
    {
        $subscriptions = $this->entityManager->getRepository(SubscriptionPlan::class)->findAll();
        //Récupération des infos de l'abonnement mensuel
        $semester_subscribe = $subscriptions[2];
        $user = $this->getUser();
        //Création et hydratation du nouvel abonnement
        $newSubscription = new Subscription();
        $newSubscription->setName($semester_subscribe->getName());
        $newSubscription->setPrice($semester_subscribe->getPrice());
        $newSubscription->setUser($user);
        $newSubscription->setPriceId('price_1Hv3kKLrKb2GsnXLcsV4Qi8Z');
        //Enregistrement du nouvel abonnement
        $this->entityManager->persist($newSubscription);
        //$this->entityManager->flush();

        return $this->render('subscription/semester_subscribe.html.twig');
    }

    /**
     * @Route("/mon-compte/je-m-abonne-annuel", name="year_subscribe")
     */
    public function yearSubscribe(Request $request)
    {
        $subscriptions = $this->entityManager->getRepository(SubscriptionPlan::class)->findAll();
        //Récupération des infos de l'abonnement mensuel
        $year_subscribe = $subscriptions[3];
        $user = $this->getUser();
        //Création et hydratation du nouvel abonnement
        $newSubscription = new Subscription();
        $newSubscription->setName($year_subscribe->getName());
        $newSubscription->setPrice($year_subscribe->getPrice());
        $newSubscription->setUser($user);
        $newSubscription->setPriceId('price_1Hv3jgLrKb2GsnXLLGjs3UmJ');
        //Enregistrement du nouvel abonnement
        $this->entityManager->persist($newSubscription);
        //$this->entityManager->flush();

        return $this->render('subscription/year_subscribe.html.twig');
    }

    /**
     * Route("/success", name="stripe_success")
     */
    public function stripeSuccess()
    {
        return $this->render('subscription/success.html.twig');
    }


}
