<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Format10\BaseFormat;
use App\Format10\FromStringInterface;
use App\Format10\JSON;
use App\Format10\XML;
use App\Format10\YAML;
use App\Format10\NamedFormatInterface;
use App\Serializer;

print_r("Dependency injection\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];

$serializer = new Serializer(new JSON());
var_dump($serializer->serialize($data));


