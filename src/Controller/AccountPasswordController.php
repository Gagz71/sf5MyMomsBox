<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    //Déclaration d'$entityManager afin de pouvoir créer une __construct() pour éviter de devoir a chaque fois tapé
    // ->getDoctrine()->getManager()
         private $entityManager;
    
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}
    
    
	/**
     * @Route("/mon-compte/modifier-mon-mot-de-passe", name="account_password")
     */
	public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
	{
		$notification = null;
		$user = $this->getUser();
		$form = $this->createForm(ChangePasswordType::class, $user);

		$form->handleRequest($request);
        
		if($form->isSubmitted() && $form->isValid()){
			$oldPassword = $form->get('oldPassword')->getData();
			if($encoder->isPasswordValid($user, $oldPassword)){
				$newPassword = $form->get('newPassword')->getData();
				$password = $encoder->encodePassword($user, $newPassword);
                
				$user->setPassword($password);
    
				//Enregistrement en BDD
				$this->entityManager->persist($user);
				$this->entityManager->flush();
                
				$notification = 'Votre mot de passe a bien été mis à jour';
			} else{
				$notification = 'Votre mot de passe actuel n\'est pas le bon';
			}
		}
        
		return $this->render('account/password.html.twig', [
			'controller_name' => 'AccountPasswordController',
			'form' => $form->createView(),
			'notification' => $notification
		]);
	}
}
