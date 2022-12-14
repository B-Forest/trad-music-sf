<?php

namespace App\Controller\Admin;

use App\Entity\Musician;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class MusicianCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Musician::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('firstName'),
            TextField::new('lastName'),
            ImageField::new('image')->setUploadDir('/public/uploads/')->setBasePath('uploads/'),

        ];
    }

}