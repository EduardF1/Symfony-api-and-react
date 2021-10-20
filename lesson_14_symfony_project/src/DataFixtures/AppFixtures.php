<?php

namespace App\DataFixtures;

use App\Security\TokenGenerator;
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
    private TokenGenerator $tokenGenerator;
    private UserPasswordHasherInterface $passwordHasher;
    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'name' => 'Daniel Squid',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_SUPERADMIN],
            'enabled' => true
        ],
        [
            'username' => 'john_doe',
            'email' => 'john@blog.com',
            'name' => 'John Doe',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
            'enabled' => true
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob@blog.com',
            'name' => 'Rob Smith',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_WRITER],
            'enabled' => true
        ],
        [
            'username' => 'jenny_rowling',
            'email' => 'jenny@blog.com',
            'name' => 'Jenny Rowling',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_WRITER],
            'enabled' => true
        ],
        [
            'username' => 'han_solo',
            'email' => 'han@blog.com',
            'name' => 'Han Solo',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_EDITOR],
            'enabled' => false
        ],
        [
            'username' => 'jar_jar_binks',
            'email' => 'jarjarbinks@therepublic.com',
            'name' => 'Jar-Jar Binks',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_COMMENTATOR],
            'enabled' => true
        ]
    ];

    /**
     * AppFixtures Class constructor
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        TokenGenerator $tokenGenerator
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create();
        $this->tokenGenerator =$tokenGenerator;
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

            $authorReference = $this->getRandomUserReference($blogPost);

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

                $authorReference = $this->getRandomUserReference($comment);

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
            $user->setRoles($userFixture['roles']);
            $user->setEnabled($userFixture['enabled']);

            if(!$userFixture['enabled']){
                $user->setConfirmationToken(
                    $this->tokenGenerator->getRandomSecureToken()
                );
            }

            $this->addReference('user_' . $userFixture['username'], $user);

            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * @param $entity
     * @return User random user reference to be returned from the list of users defined at the top of
     *              the class.
     * If a valid (determined by what operations the user can conduct), user role is not initially found,
     * the function uses recursion to determine a user role.
     */
    protected function getRandomUserReference($entity): User
    {
        $randomUser = self::USERS[rand(0, 5)];

        if ($entity instanceof BlogPost && !count(
                array_intersect(
                    $randomUser['roles'],
                    [
                        User::ROLE_SUPERADMIN,
                        User::ROLE_ADMIN,
                        User::ROLE_WRITER
                    ]
                )
            )
        ) {
            return $this->getRandomUserReference($entity);
        }

        if ($entity instanceof Comment && !count(
                array_intersect(
                    $randomUser['roles'],
                    [
                        User::ROLE_SUPERADMIN,
                        User::ROLE_ADMIN,
                        User::ROLE_WRITER,
                        User::ROLE_COMMENTATOR,
                    ]
                )
            )
        ) {
            return $this->getRandomUserReference($entity);
        }


        return $this->getReference(
            'user_' . $randomUser['username']
        );
    }
}
