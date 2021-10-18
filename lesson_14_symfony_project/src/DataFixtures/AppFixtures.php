<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Faker\Generator;
use Faker\Factory;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\BlogPost;

/**
 * Class for loading test data into the database
 */
class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $passwordHasher;
    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'name' => 'Daniel Squid',
            'password' => 'secret123#'
        ],
        [
            'username' => 'john_doe',
            'email' => 'john@blog.com',
            'name' => 'John Doe',
            'password' => 'secret123#'
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob@blog.com',
            'name' => 'Rob Smith',
            'password' => 'secret123#'
        ],
        [
            'username' => 'jenny_rowling',
            'email' => 'jenny@blog.com',
            'name' => 'Jenny Rowling',
            'password' => 'secret123#'
        ]
    ];

    /**
     * AppFixtures Class constructor
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create();
    }

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

    public function loadBlogPosts(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference('user_admin');

        // generate 100 blog posts
        for ($i = 0; $i < 100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setContent($this->faker->realText());

            $authorReference = $this->getRandomUserReference();

            $blogPost->setAuthor($authorReference);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i", $blogPost);
            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            for ($j = 0; $j < rand(1, 10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);

                $authorReference = $this->getRandomUserReference();

                $comment->setAuthor($authorReference);
                $comment->setBlogPost($this->getReference("blog_post_$i"));

                $manager->persist($comment);
            }
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setName($userFixture['name']);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userFixture['password']
            ));
            $this->addReference('user_'.$userFixture['username'], $user);

            $manager->persist($user);
        }
        $manager->flush();
    }

    protected function getRandomUserReference(): User
    {
        return $this->getReference('user_' . self::USERS[rand(0, 3)]['username']);
    }
}
