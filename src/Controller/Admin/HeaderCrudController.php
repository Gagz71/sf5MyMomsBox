<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderCrudController extends AbstractCrudController
{
          public static function getEntityFqcn(): string
          {
                    return Header::class;
          }


          public function configureFields(string $pageName): iterable
          {
                    return [
                              TextField::new('title', 'Titre du header'),
                              TextareaField::new('content', 'Contenu du header'),
                              TextField::new('btnTitle', 'Titre du bouton'),
                              TextField::new('btnUrl', 'Url de destination'),
                               ImageField::new('illustration')->setBasePath('uploads/files') ->setUploadDir('public/uploads/files')->setUploadedFileNamePattern('[randomhash].[extension]')->setLabel('Illustration'),



                    ];
          }

}
