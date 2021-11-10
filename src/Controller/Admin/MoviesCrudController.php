<?php

namespace App\Controller\Admin;

use App\Entity\Movies;
use App\Entity\Destacadas;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

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

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->onlyOnIndex();
        yield IdField::new('tmdbid', 'tmdbID');
        yield BooleanField::new('activate', 'Activado')->onlyOnIndex();
        yield BooleanField::new('relevante')->onlyOnIndex()->setHelp('Seleccione para que se muestre en el carrucel de inicio');
        yield TextField::new('nombre');
        yield TextField::new('anno', 'Año');
        yield UrlField::new('url', "URL_video");
        yield UrlField::new('url_subtitulo', 'URL Subtitulo');

    }

}
