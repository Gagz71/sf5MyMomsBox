<?php

namespace App\Controller\Admin;

use App\Entity\SubscriptionPlan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class SubscriptionPlanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubscriptionPlan::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextareaField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            IdField::new('priceId'),

        ];
    }

}
