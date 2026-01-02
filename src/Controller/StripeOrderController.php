<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\ApiOperations\Retrieve;
use Stripe\Charge;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class StripeOrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ma-commande/create-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {
        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        //Si pas de commande, redirection
        if(!$order){
            new JsonResponse(['error' => 'order']);
        }

        //Enregistrement produits pour stripe
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000'; //TODO:A remplacer par la futur adresse du site

        //Pour tout les produits contenus dans le panier
        foreach ($order->getOrderDetails()->getValues() as $product)
        {
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            //Injection des produits dans stripe
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/files/".$product_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        //Si transporteur, à rajouter
//        $products_for_stripe[] = [
//            'price_data' => [
//                'currency' => 'eur',
//                'unit_amount' => $order->getCarrierPrice() * 100,
//                'product_data' => [
//                    'name' => $order->getCarrierName(),
//                    'images' => [$YOUR_DOMAIN],
//                ],
//            ],
//            'quantity' => 1,
//        ];

        //Stripe
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/ma-commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/ma-commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);

        return $response;
    }












}
