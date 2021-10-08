<?php

namespace App13\Controller;

use App13\Annotations\Route;
use App13\Service\Serializer;

/**
 * @Route(route="/")
 */
class IndexController
{
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route(route="/")
     */
    public function index(): string
    {
        return $this->serializer->serialize([
            'Action' => 'Index',
            'Time' => time()
        ]);
    }
}