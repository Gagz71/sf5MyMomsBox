<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    /**
     * @Route("/mon-compte/mes-commandes", name="account_order")
     */
    public function index(): Response
    {
        return $this->render('account/order.html.twig');
    }
}
