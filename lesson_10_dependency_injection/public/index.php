<?php

require __DIR__ . '/../vendor/autoload.php';

<<<<<<< HEAD
use App10\Format10\BaseFormat;
use App10\Format10\FromStringInterface;
use App10\Format10\JSON;
use App10\Format10\XML;
use App10\Format10\YAML;
use App10\Format10\NamedFormatInterface;
use App10\Serializer;
=======
use App\Format10\BaseFormat;
use App\Format10\FromStringInterface;
use App\Format10\JSON;
use App\Format10\XML;
use App\Format10\YAML;
use App\Format10\NamedFormatInterface;
use App\Serializer;
>>>>>>> 02e56e2cfc3bd91abf260ecf8facff9ec0fb0d16

print_r("Dependency injection\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];

$serializer = new Serializer(new JSON());
var_dump($serializer->serialize($data));


