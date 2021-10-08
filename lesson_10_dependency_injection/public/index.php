<?php

require __DIR__ . '/../vendor/autoload.php';

use App10\Format10\BaseFormat;
use App10\Format10\FromStringInterface;
use App10\Format10\JSON;
use App10\Format10\XML;
use App10\Format10\YAML;
use App10\Format10\NamedFormatInterface;
use App10\Serializer;

print_r("Dependency injection\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];

$serializer = new Serializer(new JSON());
var_dump($serializer->serialize($data));


