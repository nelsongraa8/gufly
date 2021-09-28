<?php

namespace App\Controller\Admin;

use App\Entity\Destacadas;
use App\Entity\Movies;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class DestacadasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Destacadas::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('movies'),
            TextField::new('title'),
            TextEditorField::new('text'),
        ];
    }

}
