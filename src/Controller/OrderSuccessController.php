<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/ma-commande/merci/{stripeSessionId}", name="order_success")
     */
    public function index(Cart $cart,$stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //Si le isPaid de la commande n'est pas déjà à 1 -> si isPaid = 0
        if(!$order ->getIsPaid()){
            //Vider la session 'cart' = le panier
            $cart->remove();

            //Modifier statut 'isPaid' de la commande en passant le bool à 1
            $order->setIsPaid(1);
            $this->entityManager->flush();

            //Envoyer email au client pr confirmation de paiement de commande

        }

        //Afficher infos de la commande à utilisateur

        return $this->render('order_success/index.html.twig',[
            'order'=> $order
        ]);
    }
}
