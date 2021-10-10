<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\CommentRepository;
/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
#[ApiResource]
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn()
     */
    private User $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private BlogPost $blogPost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublished(): ?DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Comment
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return BlogPost
     */
    public function getBlogPost(): BlogPost
    {
        return $this->blogPost;
    }

    /**
     * @param BlogPost $blogPost
     */
    public function setBlogPost(BlogPost $blogPost): void
    {
        $this->blogPost = $blogPost;
    }

}
