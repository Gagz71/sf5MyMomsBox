<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class StripeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ma-commande/create-session", name="stripe_create_session")
     */
    public function index(Cart $cart): Response
    {
        //Enregistrement produits pour stripe
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000'; //TODO:A remplacer par la futur adresse du site

        //Pour tout les produits contenus dans le panier
        foreach ($cart->getFull() as $product)
        {
            //Injection des produits dans stripe
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$YOUR_DOMAIN."/uploads/files/".$product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];

        }

        //Stripe
        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html.twig',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html.twig',
        ]);

        $response = new JsonResponse(['id' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-mensuellement/create-session", name="subscribe_create_session")
     */
    public function subscribeCreateSession(): Response
    {
        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'success_url' => $myDomain.'/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/canceled.html.twig',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3ioLrKb2GsnXLxBdgERHd',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     *  @Route("/mon-compte/je-m-abonne-mensuellement/checkout-session", name="subscribe_checkout_session")
     */
    public function subscribeCheckoutSession(Request $request): Response
    {

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');


        $id = $request->query->get('sessionId');
        dd($id);
    }

    /**
     * @Route("/mon-compte/je-m-abonne-trimestriel/create-session", name="subscribe_create_session_trimester")
     */
    public function subscribeTrimesterCreateSession(): Response
    {
        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'success_url' => $myDomain.'/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/canceled.html.twig',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3jgLrKb2GsnXLLGjs3UmJ',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-semestriel/create-session", name="subscribe_create_session_semester")
     */
    public function subscribeSemesterCreateSession(): Response
    {
        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'success_url' => $myDomain.'/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/canceled.html.twig',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1Hv3kKLrKb2GsnXLcsV4Qi8Z',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }

    /**
     * @Route("/mon-compte/je-m-abonne-annuel/create-session", name="subscribe_create_session_year")
     */
    public function subscribeYearCreateSession(): Response
    {
        //Stripe
        $myDomain = 'http://127.0.0.1:8000';

        Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

        $checkout_session = Session::create([
            'success_url' => $myDomain.'/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $myDomain.'/canceled.html.twig',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1HuNu9LrKb2GsnXLXpa322We',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]],
        ]);

        $response = new JsonResponse(['sessionId' => $checkout_session->id]);

        return $response;
    }



}
