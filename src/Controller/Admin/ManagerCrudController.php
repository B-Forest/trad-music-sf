<?php

namespace App\Controller\Admin;

use App\Entity\Manager;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ManagerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Manager::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
