<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Load data fixtures with the given object manager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager){
        /** @var User $user */
        $user = $this->getReference('user_admin');

        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post!');
        $blogPost->setPublished(new \DateTime('2021-10-09 12:50:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor($user);
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost2 = new BlogPost();
        $blogPost2->setTitle('A second post!');
        $blogPost2->setPublished(new \DateTime('2021-10-09 12:50:00'));
        $blogPost2->setContent('Post text 2!');
        $blogPost2->setAuthor($user);
        $blogPost2->setSlug('a-second-post');

        $manager->persist($blogPost2);

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager){

    }

    public function loadUsers(ObjectManager $manager){
        $user = new User();

        $user->setUsername('admin');
        $user->setEmail('admin@blog.com');
        $user->setName('Adam Henrik');
        $user->setPassword('secret123#');

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
