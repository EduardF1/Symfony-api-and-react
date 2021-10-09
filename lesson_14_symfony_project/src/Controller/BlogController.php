<?php

namespace App\Controller;

use App\Entity\BlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;


/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello world!',
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post!',
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'This is the last example'
        ]
    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5}, requirements={"page"="\d+"})
     */
    public function list(Request $request, $page = 1): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $repository = $this->getDoctrine()->getRepository(BlogPost::class);
        $items = $repository->findAll();

        return $this->json(
            [
                'page' => $page,
                'limit' => $limit,
                'data' => array_map(function (BlogPost $item) {
                    return $this->generateUrl('blog_by_slug', ['slug' => $item->getSlug()]);
                }, $items)
            ]
        );
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"}, methods={"GET"})
     * @ParamConverter("post", class="App:BlogPost")
     */
    public function post($post): JsonResponse
    {
        // It's the same as doing find($id) on repository
        return $this->json($post);
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug", methods={"GET"})
     * The below annotation is not required when $post is type-hinted with BlogPost
     * and route parameter name matches any field on the BlogPost entity
     * @ParamConverter("post", class="App:BlogPost", options={"mapping": {"slug": "slug"}})
     */
    public function postBySlug(BlogPost $post): JsonResponse
    {
        // Same as doing findOneBy(['slug' => contents of {slug}])
        return $this->json($post);
    }

    /**
     * @Route("/add", name="blog_add", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        /** @var Serializer $serializer */
        $serializer = $this->get('serializer');

        $blogPost = $serializer->deserialize(
            $request->getContent(),
            BlogPost::class,
            'json'
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($blogPost);
        $entityManager->flush();

        return $this->json($blogPost);
    }

    /**
     * @Route("/post/{id}", name="blog_delete", methods={"DELETE"})
     */
    public function delete(BlogPost $post): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}