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
        yield TextField::new('nombre');
        yield TextField::new('anno', 'Año');
        yield TextField::new('productora');

        yield TextEditorField::new('descripcion')->onlyOnIndex();
        yield TextareaField::new('descripcion')->hideOnIndex();

        yield ImageField::new('poster')->onlyOnIndex();
        yield TextField::new('poster')->hideOnIndex();

        yield ImageField::new('fanart')->onlyOnIndex();
        yield TextField::new('fanart')->hideOnIndex();

        yield UrlField::new('url')->hideOnIndex();
        yield TextField::new('idioma_subtitulo' , 'Idioma Sub');

        yield IntegerField::new('duracion')->formatValue(function($value, $entity) {
            $horas = (int) ($value / 3600);
            $minutos = ($value / 60) % 60;

            return $horas.'h '.$minutos.'m';
        });

        yield TextField::new('director')->setSortable(false);
        yield TextField::new('genero')->setHelp('');
        yield BooleanField::new('relevante')->setHelp('Sleccione para que se muestre en el carrucel de inicio');
    }

}
