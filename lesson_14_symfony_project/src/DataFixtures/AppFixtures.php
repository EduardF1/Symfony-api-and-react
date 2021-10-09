<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post!');
        $blogPost->setPublished(new \DateTime('2021-10-09 12:50:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor('Eduard F.');
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost2 = new BlogPost();
        $blogPost2->setTitle('A second post!');
        $blogPost2->setPublished(new \DateTime('2021-10-09 12:50:00'));
        $blogPost2->setContent('Post text 2!');
        $blogPost2->setAuthor('Eduard F.');
        $blogPost2->setSlug('a-second-post');

        $manager->persist($blogPost2);

        $manager->flush();
    }
}
