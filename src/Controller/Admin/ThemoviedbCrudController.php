<?php

namespace App\Controller\Admin;

use App\Entity\Themoviedb;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ThemoviedbCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Themoviedb::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('idmovie'),
            TextField::new('title'),
            TextField::new('release_date'),
            TextField::new('backdrop_path'),
            TextField::new('poster_path'),
        ];
    }
}
