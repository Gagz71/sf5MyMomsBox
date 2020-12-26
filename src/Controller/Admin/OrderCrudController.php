<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $crudUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, CrudUrlGenerator $crudUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;

    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        //Custom actions = nouveau bouton d'utilisation qui permet de mettre de changer le statut de la commande
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-parachute-box')->linkToCrudAction('updateDelivery');

        //Actions connus easy admin = ajouter, editer, supprimer, voir
        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context) //Permet de récup une entité pour la modifier
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        $this->addFlash('notice', '<span style="color:green";><strong>La commande ' . $order->getReference() . ' est bien <u>en cours de préparation</u>.</strong>');
        //redirection de l'utilisateur vers la vue détail
        $url = $this->crudUrlGenerator->build()
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        //Envoi d'un mail pour prévenir l'utilisateur que sa commande a changé de statut
        $mail = new Mail();
        $content = 'Bonjour '. $order->getUser()->getFirstname().', <br>Votre commande est en cours de préparation.<br> Vous pouvez dès à présent vous rendre sur votre compte pour gérer vos informations. <br>A très vite sur mymomsbox.fr';
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande sur mymomsbox.fr est en cours de préparation.', $content);


        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context) //Permet de récup une entité pour la modifier
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', '<span style="color:darkorange";><strong>La commande ' . $order->getReference() . ' est bien <u>en cours de livraison</u>.</strong>');
        //redirection de l'utilisateur vers la vue détail
        $url = $this->crudUrlGenerator->build()
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        //Envoi d'un mail pour prévenir l'utilisateur que sa commande a changé de statut
        $mail = new Mail();
        $content = 'Bonjour '. $order->getUser()->getFirstname().', <br>Votre commande est en cours de livraison.<br> Vous pouvez dès à présent vous rendre sur votre compte pour gérer vos informations. <br>A très vite sur mymomsbox.fr';
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre Mom\'s Box arrive !', $content);


        return $this->redirect($url);
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt', 'Passée le'),
            TextField::new('user.getFullName', 'Par'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3,
                'Livré' => 4
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }

}
