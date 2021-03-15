<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
          private $entityManager;

          public function __construct(EntityManagerInterface $entityManager)
          {
                    $this->entityManager = $entityManager;
          }
	/**
	* @Route("/mot-de-passe-oublie", name="reset_password")
	*/
	public function index(Request $request): Response
	{
		if($this->getUser()){
		        return $this->redirectToRoute('home');
		}

              //Permet de récupérer la saisie de l'input de l'user, gràce à <input name='email'>
              //si l'input à été saisie
		if($request->get('email')){
			//on récupère l'émail dans la table user
			$user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));

			//Si l'email existe bien
			if($user){
				 //Etape 1
				 //Création d'une nouvelle demande de resetPassword
				 $reset_password = new ResetPassword();
				 //Hydratation de la nouvelle demande de  ResetPassword
				 $reset_password->setUser($user);
				 $reset_password->setToken(uniqid());
				 $reset_password->setCreatedAt(new \DateTime());
				 //Enregistrement de la demande en BDD
				 $this->entityManager->persist($reset_password);
				 $this->entityManager->flush();

			         //Etape 2
			         //Envoi d'un email à l'user avec un lien lui permettant de mettre à jour son mot de passe
			         $url = $this->generateUrl('update_password', [
			              'token' => $reset_password->getToken()
			         ]);
			         $content = 'Bonjour '.$user->getFirstname().'<br>Vous avez demandé une réinitialisation de votre mot de passe sur MyMom\'sBox.fr.<br><br>';
			         $content .= 'Merci de bien vouloir cliquer sur le lien suivant afin de <a href="'.$url.'">mettre à jour</a> votre mot de passe.';
			         $mail = new Mail();
			         $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinitialiser votre mot de passe', $content);
			         $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec le lien vous permettant de modifier votre mot de passe. Merci de vérifier votre boite mail ! ');
			}else{
			         //Msg de notif
			         $this->addFlash('notice', 'Cette adresse email est inconnu auprès de My Mom\'s Box');
			}

		}

		return $this->render('reset_password/reset_password.html.twig');
	}

	/**
	* @Route("/modifier-mon-mot-de-passe/{token}", name="update_password")
	*/
	public function updatePassword($token, Request $request, UserPasswordEncoderInterface $encoder) //On passe token en param car il est en param de l'url
	{

		$reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

		if(!$reset_password){
		        return $this->redirectToRoute('reset_password');
		}

              //Vérifier si createdAt = mtn - 3h =>permet d'imposer un délai de validité de la demande
		$now = new \DateTime();
              //Si le moment présent est supérieur à 3h après la demande -> Expiration du token
		if($now > $reset_password->getCreatedAt()->modify('+ 3 hour')){
                        //Msg de notif
                        $this->addFlash('notif', 'Votre demande de passe a expiré. Merci de la renouveller');
                        return $this->redirectToRoute('reset_password');
		}
              //Rendre vue avec formulaire de mot de passe
		$form = $this->createForm(ResetPasswordType::class);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			//récupération du nouveau mdp saisi par l'user
			$new_password = $form->get('newPassword')->getData();
			//encodage du mot de passe
			$password = $encoder->encodePassword($reset_password->getUser(), $new_password);
			//Hydratation de l'user avec le nouveau mot de passe
			$reset_password->getUser()->setPassword($password);
			//Enregistrement en bdd du nvo mot de passe à l'user associé
			$this->entityManager->flush();
			//redirection de l'user vers la page de login avec msg de succes
			$this->addFlash('notice', 'Votre mot de passe a bien été mis à jour');
			return $this->redirectToRoute('app_login');
		}


		return $this->render('reset_password/update_password.html.twig', [
			'form' => $form->createView()
		]);
	}
}
