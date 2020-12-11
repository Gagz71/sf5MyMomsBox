<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    //Déclaration d'$entityManager afin de pouvoir créer une __construct() pour éviter de devoir a chaque fois tapé
    // ->getDoctrine()->getManager()
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
    $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            // Hydratation du nouveau compte user
            $user
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                )
                //Hydratation de la date d'inscription
                ->setRegisterDate(new \DateTime());
            
            
            //Enregistrement en BDD
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        
        
        return $this->render('register/register.html.twig', [
            'controller_name' => 'RegisterController',
            'form' =>$form->createView()
        ]);
    }
}
