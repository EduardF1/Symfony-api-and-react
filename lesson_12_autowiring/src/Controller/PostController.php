<?php

namespace App12\Controller;

use App12\Service\Serializer;

class PostController
{
    public function __construct(Serializer $serializer){
        $this->serializer = $serializer;
    }

    public function index() {
        return $this->serializer->serialize([
           'Action' => 'Post',
           'Time' => time()
        ]);
    }
}