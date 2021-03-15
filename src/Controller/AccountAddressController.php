<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/mon-compte/adresses", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }


    /**
     * @Route("/mon-compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            //Si l'utilisateur était dans son tunnel d'achat (panier pr valider commande)
            if($cart->get()){
                //redirection sur la page de commande
                return $this->redirectToRoute('order');
            } else{
                //sinon sur la page de gestion des adresses
                return $this->redirectToRoute('account_address');
            }

        }

        return $this->render('account/address_add.html.twig', [
            'controller_name' => 'AccountAddressController',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/mon-compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if(!$address || $address->getUser() != $this->getUser() ){
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_add.html.twig', [
            'controller_name' => 'AccountAddressController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mon-compte/supprimer-une-adresse/{id}", name="account_address_delete")
     */
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }



        return $this->redirectToRoute('account_address');
    }
}
