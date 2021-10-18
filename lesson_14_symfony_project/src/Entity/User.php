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
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\UserRepository;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get" = {
 *              "access_control"= "is_granted('IS_AUTHENTICATED_FULLY')",
 *              normalization_context={
 *                      "groups"={"get"}
 *                  }
 *             },
 *          "put"={
 *              "access_control"= "is_granted('IS_AUTHENTICATED_FULLY') and object == user",
 *              denormalization_context={
 *                   "groups"={"put"}
 *              }
 *          }
 *     },
 *     collectionOperations={
 *          "post"={
 *              denormalization_context={
 *                  "groups"={"post"}
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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("get")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=6, max=255)
     * @Groups({"get","post"})
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=6, max=255)
     * @Groups({"get", "post", "put"})
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min=6, max=255)
     * @Groups({"post", "put"})
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"put","post"})
     * @Assert\Regex(
     *     pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *     message="Password must be seven characters long and contain at least one digit, one upper case letter and one lower case letter"
     * )
     */
    private string $password;

    /**
     * @Assert\NotBlank()
     * @Groups({"put","post"})
     * @Assert\Expression(
     *    "this.getPassword() === this.getConfirmationPassword()",
     *     message="Passwords do not match"
     * )
     * @Groups("post")
     */
    private string $confirmationPassword;

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

    // Required constructor (for Doctrine) for 1..* relationships
    // Typical procedure for entities that have a single to multiple cardinality
    #[Pure] public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }
}
