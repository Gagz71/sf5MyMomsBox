<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ma-commande", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/order.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/ma-commande/recapitulatif", name="order_recap")
     */
    public function add(Cart $cart, Request $request): Response
    {

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //Création du client pour Stripe
            $token = new Token();

            Stripe::setApiKey('sk_test_51HuFssLrKb2GsnXLICx8LTZNijsAEeXk5drqXo0V62Lan0JLqussrQqM28EcxARTPzGVYkWOJPTZfMYSOb9AmWyc00IvThoFjC');

            $user = $this->getUser();
            if(!$user->getStripeCustomerId())
            {
                $customer = Customer::create([
                    'email' => $user->getEmail(),
                    'source' => $token,
                ]);
                $user->setStripeCustomerId($customer->id);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            } else{
                $customer = Customer::retrieve($user->getStripeCustomerId());
                $token = $customer['source'];
                $customer->save();
            }

            //Récupération de la date du jour
            $date = new \DateTime();

            //récupération de l'adresse de livraison
            $delivery = $form->get('addresses')->getData();
            $deliveryContent = $delivery->getFirstname().' '.$delivery->getLastname();
            $deliveryContent .= '<br/>'.$delivery->getPhone();



            if($delivery->getCompany())
            {
                $deliveryContent .= '<br/>'.$delivery->getCompany();
            }

            $deliveryContent .= '<br/>'.$delivery->getAddress();
            $deliveryContent .= '<br/>'.$delivery->getZipCode().'  '.$delivery->getCity();
            $deliveryContent .= '<br/>'.$delivery->getCountry();

            //Enregistrement de la commande => Order()
            $order = new Order();

            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setDelivery($deliveryContent);
            $order->setState(0);

            $this->entityManager->persist($order);


            //Enregistrement des produits => OrderDetails()
            foreach ($cart->getFull() as $product){
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
            }
            $this->entityManager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'delivery' => $deliveryContent,
                'reference' => $order->getReference()
            ]);
        }
        return  $this->redirectToRoute('cart');
    }


}
