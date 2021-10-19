<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * Controller class for blog posts
 */
class BlogPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
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
