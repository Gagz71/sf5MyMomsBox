<?php

namespace App\Controller;

use App\Classe\Mail;
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
        //Initialisation d'une variable qui permettra l'envoi de mail si le formulaire est soumis
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $search_mail = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_mail){
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

                $email = new Mail();
                $content = 'Bonjour '. $user->getFirstname().', <br>Nous sommes ravies de vous compter parmis nos inscrits. Vous pouvez dès à présent vous rendre sur votre compte pour choisir un abonnement. <br>A très vite sur mymomsbox.fr';
                $email->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur My Mom\'s Box', $content);

                //Création d'une notification d'inscription
                $notification = 'Votre inscription a bien été enregistré. Vous pouvez dès maintenant vous connecter à votre compte.';

            } else{

                $notification = 'L\'email que vous avez renseigné existe déjà.';
            }






            //redirection sur page de connexion
            return $this->redirectToRoute('app_login');
        }
        
        
        return $this->render('register/register.html.twig', [
            'form' =>$form->createView(),
            'notification' => $notification
        ]);
    }
}
