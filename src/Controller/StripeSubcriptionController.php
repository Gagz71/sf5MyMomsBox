<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use http\Message\Parser;
use Stripe\Checkout\Session;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeSubcriptionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-mensuellement/create-session/{reference}", name="subscribe_create_session")
     */
    public function subscribeCreateSession(EntityManagerInterface $entityManager, $reference): Response
    {

        $subscription = $entityManager->getRepository(Subscription::class)->findOneByReference($reference);

        //Si pas de commande, redirection
        if(!$subscription){
            new JsonResponse(['error' => 'order']);
        }
        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'success_url' => $myDomain.'/mon-compte/je-m-abonne/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/mon-compte/je-m-abonne/erreur/{CHECKOUT_SESSION_ID}',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3ioLrKb2GsnXLxBdgERHd',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $subscription->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }


    /**
     * @Route("/mon-compte/je-m-abonne-trimestriel/create-session/{reference}", name="subscribe_create_session_trimester")
     */
    public function subscribeTrimesterCreateSession(EntityManagerInterface $entityManager, $reference): Response
    {
        $subscription = $entityManager->getRepository(Subscription::class)->findOneByReference($reference);

        //Si pas de commande, redirection
        if(!$subscription){
            new JsonResponse(['error' => 'order']);
        }

        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'success_url' => $myDomain.'/mon-compte/je-m-abonne/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/mon-compte/je-m-abonne/erreur/{CHECKOUT_SESSION_ID}',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3jgLrKb2GsnXLLGjs3UmJ',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $subscription->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-semestriel/create-session/{reference}", name="subscribe_create_session_semester")
     */
    public function subscribeSemesterCreateSession(EntityManagerInterface $entityManager, $reference): Response
    {
        $subscription = $entityManager->getRepository(Subscription::class)->findOneByReference($reference);

        //Si pas de commande, redirection
        if(!$subscription){
            new JsonResponse(['error' => 'order']);
        }

        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'success_url' => $myDomain.'/mon-compte/je-m-abonne/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/mon-compte/je-m-abonne/erreur/{CHECKOUT_SESSION_ID}',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3kKLrKb2GsnXLcsV4Qi8Z',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $subscription->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-annuel/create-session/{reference}", name="subscribe_create_session_year")
     */
    public function subscribeYearCreateSession(EntityManagerInterface $entityManager, $reference): Response
    {
        $subscription = $entityManager->getRepository(Subscription::class)->findOneByReference($reference);

        //Si pas de commande, redirection
        if(!$subscription){
            new JsonResponse(['error' => 'order']);
        }

        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'success_url' => $myDomain.'/mon-compte/je-m-abonne/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/mon-compte/je-m-abonne/erreur/{CHECKOUT_SESSION_ID}',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1HuNu9LrKb2GsnXLXpa322We',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $subscription->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne/checkout-session/{stripeSessionId}", name="subscribe_checkout-session")
     */
    public function checkoutSession($stripeSessionId)
    {
        $subscription = $this->entityManager->getRepository(Subscription::class)->findOneByStripeSessionId($stripeSessionId);

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::retrieve($subscription);

        $response = new JsonResponse($checkout_session);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne/customer-portal/{stripeSessionId}", name="subscribe_customer_portal")
     */
    public function customerPortal(Request $request, EntityManagerInterface $entityManager, $stripeSessionId)
    {
        $subscription = $entityManager->getRepository(Subscription::class)->findOneByStripeSessionId($stripeSessionId);


        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::retrieve($stripeSessionId);

        $stripe_customer_id = $checkout_session->customer;

        $return_url = 'http://127.0.0.1:8000/mon-compte/mon-abonnement';

        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $stripe_customer_id,
            'return_url' => $return_url,
        ]);



        $response = new JsonResponse(['url' => $session->url]);

        return $response;
    }

    /**
     * @Route("/mon-compte/mon-abonnement/webhook", name="subscribe_webhook")
     */
    public function webhook(Request $request)
    {
        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $session = \Stripe\BillingPortal\Session::create([
            'customer' => $this->getUser()->getStripeCustomerId(),
            'return_url' => 'http://127.0.0.1:8000/mon-compte/mon-abonnement',
        ]);

        $session->values();
        //dd($session);

        // Redirect to the customer portal.
        header("Location: " . $session->url); exit();

        $payload = @file_get_contents('php://input');

        $event = \Stripe\Event::constructFrom(
            json_decode($payload, true)
        );

        $webhookSecret = 'whsec_YZgQ07YeUr0b49f3Cxqnw8L4LzCU1g7n';

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->getData()->getObject(); // contains a \Stripe\PaymentIntent
                // Then define and call a method to handle the successful payment intent.
                // handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                break;
            case 'customer.subscription.updated':
                $customerSubscription = $event->data->values();
                dd($customerSubscription);
            default:
                // Unexpected event type
                echo 'Received unknown event type';

        }

        http_response_code(200);

    }



}
