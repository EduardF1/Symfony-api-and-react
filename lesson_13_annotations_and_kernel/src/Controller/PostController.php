<?php

namespace App13\Controller;

use App13\Annotations\Route;
use App13\Service\Serializer;

/**
 * @Route(route="/posts")
 */
class PostController
{
    public function __construct(Serializer $serializer){
        $this->serializer = $serializer;
    }

    /**
     * @Route(route="/")
     */
    public function index(): string
    {
        return $this->serializer->serialize([
           'Action' => 'Post',
           'Time' => time()
        ]);
    }

    /**
     * @Route(route="/one")
     */
    public function one(): string
    {
        return $this->serializer->serialize([
           'Action' => 'PostOne',
            'Time' => time()
        ]);
    }
}