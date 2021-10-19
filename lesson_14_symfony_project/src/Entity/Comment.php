<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

use DateTimeInterface;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\CommentRepository;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "put"={
 *              "access_control"= "is_granted('ROLE_COMMENTATOR') or (is_granted('ROLE_COMMENTATOR') and object.getAuthor() == user)"
 *          }
 *      },
 *     collectionOperations={
 *          "get",
 *          "post"  = {
 *              "access_control"= "is_granted('ROLE_COMMENTATOR')"
 *             },
 *          "api_blog_posts_comments_get_subresource"={
 *              "normalization_context"={
 *                      "groups"={"get-comment-with-author"}
 *              }
 *          }
 *      },
 *     denormalizationContext={
 *          "groups"={"post"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment implements IAuthoredEntity, IPublishedDateEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"get-comment-with-author"})
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"post", "get-comment-with-author"})
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=3000)
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\Type("\DateTimeInterface")
     * @Groups({"get-comment-with-author"})
     */
    private DateTimeInterface $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"get-comment-with-author"})
     */
    private UserInterface $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlogPost", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"post"})
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

    public function setPublished(DateTimeInterface $published): IPublishedDateEntity
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     * @return IAuthoredEntity
     */
    public function setAuthor(UserInterface $author): IAuthoredEntity
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
