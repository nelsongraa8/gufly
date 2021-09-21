<?php

namespace App\Controller\Admin;

use App\Entity\Movies;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
//use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class MoviesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movies::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Movies')
            ->setEntityLabelInPlural('Movies')
            ->setSearchFields([ 'id' , 'nombre', 'productora', 'anno' , 'fanart' , 'descripcion', 'url' , 'idioma_subtitulo' , 'duracion' , 'director' , 'genero' ])
            ->setDefaultSort(['id' => 'DESC']);
        ;
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //         ->add(EntityFilter::new('nombre'))
    //     ;
    // }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('nombre');
        yield TextField::new('anno');

        yield TextEditorField::new('descripcion')->onlyOnIndex();
        yield TextareaField::new('descripcion')->hideOnIndex();

        yield TextField::new('productora');

        yield ImageField::new('poster')->onlyOnIndex();
        yield TextField::new('poster')->hideOnIndex();

        yield ImageField::new('fanart')->onlyOnIndex();
        yield TextField::new('fanart')->hideOnIndex();

        yield UrlField::new('url')->hideOnIndex();
        yield TextField::new('idioma_subtitulo');
        yield IntegerField::new('duracion');
        yield TextField::new('director');
        yield TextField::new('genero');
    }

}
