<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountSubscriptionController extends AbstractController
{
    /**
     * @Route("/account/subscription", name="account_subscription")
     */
    public function index(): Response
    {
        return $this->render('account/subscription.html.twig');
    }
}
