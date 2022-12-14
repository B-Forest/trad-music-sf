<?php

namespace App\Controller\Admin;

use App\Entity\Gig;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gig::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            DateField::new('dateStart'),
            DateField::new('dateEnd'),
            TextField::new('pubGig')

        ];
    }
    */
}