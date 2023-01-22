<?php

namespace App\Controller\Admin;

use App\Entity\Medias;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class MediasCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Medias::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield TextEditorField::new('description');
        yield AssociationField::new('user');
        yield AssociationField::new('category');
        yield AssociationField::new('status');
        yield ImageField::new('path')
            ->setBasePath('/medias/images/')
            ->setUploadDir('public/medias/images/');
    }
}
