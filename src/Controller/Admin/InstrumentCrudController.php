<?php

namespace App\Controller\Admin;

use App\Entity\Instrument;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class InstrumentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Instrument::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('icon'),

        ];
    }
    */
}