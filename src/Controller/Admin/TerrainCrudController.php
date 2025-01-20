<?php

namespace App\Controller\Admin;

use App\Entity\Terrain;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TerrainCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Terrain::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
              IdField::new('id')->setFormTypeOption('disabled', true),
         yield    TextField::new('nom_terrain'),
        yield   BooleanField::new('disponible'),
        yield   AssociationField::new('Categorie')->setLabel('Categorie'),
           yield    integerField::new('Capacite'),

           yield TextEditorField::new('description'),
        ];
    }

}
