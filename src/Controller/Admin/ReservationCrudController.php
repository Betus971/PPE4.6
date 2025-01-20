<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
             yield DateTimeField::new('date_creation') ->setFormat('dd.MM.yyyy'),
            yield DateTimeField::new('datefin') ->settimezone('Europe/Paris'),
           // TextEditorField::new('description'),

        yield     AssociationField::new('User')->setLabel('utilisateur'),
         yield   AssociationField::new('Terrain')->setLabel('Type de terrain'),
        ];
    }

}
