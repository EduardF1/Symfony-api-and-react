<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

use JetBrains\PhpStorm\Pure;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\UserRepository;
use App\Controller\ResetPasswordAction;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {
 *              "access_control"= "is_granted('IS_AUTHENTICATED_FULLY')",
 *              "normalization_context"={
 *                      "groups"={"get"}
 *                  }
 *             },
 *          "put"={
 *              "access_control"= "is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              "denormalization_context"={
 *                   "groups"={"put"}
 *              },
 *              "normalization_context"={
 *                      "groups"={"get"}
 *              }
 *          },
 *          "put-reset-password"={
 *                  "access_control"="is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *                  "method"="PUT",
 *                  "path"="/users/{id}/reset-password",
 *                  "controller"=ResetPasswordAction::class,
 *                  "denormalization_context"={
 *                       "groups"={"put-reset-password"}
 *                  }
 *              }
 *     },
 *     collectionOperations={
 *          "post"={
 *              "denormalization_context"={
 *                  "groups"={"post"}
 *              },
 *              "normalization_context"={
 *                      "groups"={"get"}
 *              }
 *          }
 *      }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    const ROLE_COMMENTATOR = 'ROLE_COMMENTATOR';
    const ROLE_WRITER = 'ROLE_WRITER';
    const ROLE_EDITOR = 'ROLE_EDITOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';

    const DEFAULT_ROLES = [self::ROLE_COMMENTATOR];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("get")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups="post")
     * @Assert\Length(min=6, max=255,groups="post")
     * @Groups({"get","post", "get-comment-with-author", "get-blog-post-with-author"})
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Length(min=6, max=255, groups={"post", "put"})
     * @Groups({"get", "post", "put", "get-comment-with-author", "get-blog-post-with-author"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"post"})
     * @Assert\Email(groups={"post", "put"})
     * @Assert\Length(min=6, max=255, groups={"post", "put"})
     * @Groups({"post", "put", "get-admin", "get-owner"})
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post"})
     * @Assert\NotBlank(groups="post")
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case letter and one lower case letter",
     *     groups="post"
     * )
     */
    private string $password;

    /**
     * @Assert\NotBlank(groups="post")
     * @Groups({"post"})
     * @Assert\Expression(
     *    "this.getPassword() === this.getConfirmationPassword()",
     *     message="Passwords do not match",
     *     groups="post"
     * )
     */
    private ?string $confirmationPassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups="put-reset-password")
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case letter and one lower case letter",
     *     groups="put-reset-password"
     * )
     */
    private ?string $newPassword;

    /**
     * @Assert\NotBlank(groups="put-reset-password")
     * @Groups({"put-reset-password"})
     * @Assert\Expression(
     *    "this.getNewPassword() === this.getNewConfirmationPassword()",
     *     message="Passwords do not match",
     *     groups="put-reset-password"
     * )
     */
    private ?string $newConfirmationPassword;

    /**
     * @Groups({"put-reset-password"})
     * @Assert\NotBlank(groups="put-reset-password")
     * @UserPassword(groups="put-reset-password")
     */
    private ?string $oldPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="author")
     * @Groups("get")
     */
    private ArrayCollection|PersistentCollection $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     * @Groups("get")
     */
    private ArrayCollection|PersistentCollection $comments;

    /**
     * @ORM\Column(type="simple_array", length=200)
     * @Groups({"get-admin", "get-owner"})
     */
    private array $roles;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passwordChangeDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $enabled;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $confirmationToken;

    // Required constructor (for Doctrine) for 1..* relationships
    // Typical procedure for entities that have a single to multiple cardinality
    #[Pure] public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles = self::DEFAULT_ROLES;
        $this->confirmationToken = null;
        $this->enabled = false;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this the current User object for which the username is being set
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this the current User object for which the name is being set
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this the current User object for which the email is being set
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getConfirmationPassword(): ?string
    {
        return $this->confirmationPassword;
    }

    /**
     * @param string $repeatPassword
     */
    public function setConfirmationPassword(string $repeatPassword): void
    {
        $this->confirmationPassword = $repeatPassword;
    }

    /**
     * @return string[] the array of defined user roles
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles the roles to set for a user
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        //  Required empty method body
    }

    public function getNewPassword() : ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    public function getNewConfirmationPassword(): ?string
    {
        return $this->newConfirmationPassword;
    }

    public function setNewConfirmationPassword($newConfirmationPassword): void
    {
        $this->newConfirmationPassword = $newConfirmationPassword;
    }

    public function getOldPassword() : ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    public function getPasswordChangeDate(): ?int
    {
        return $this->passwordChangeDate;
    }

    public function setPasswordChangeDate(int $passwordChangeDate): void
    {
        $this->passwordChangeDate = $passwordChangeDate;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getEnabled(): bool{
        return $this->enabled;
    }

    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken($confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }
}
