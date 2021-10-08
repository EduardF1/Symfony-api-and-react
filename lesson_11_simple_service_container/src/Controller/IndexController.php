<?php

namespace App11\Controller;

use App11\Service\Serializer;

class IndexController
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function index()
    {
        return $this->serializer->serialize([
            'Action' => 'Index',
            'Time' => time()
        ]);
    }
}