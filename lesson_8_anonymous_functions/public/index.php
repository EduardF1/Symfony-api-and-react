<?php

require __DIR__ . '/../vendor/autoload.php';

<<<<<<< HEAD
use App8\Format8\BaseFormat;
use App8\Format8\FromStringInterface;
use App8\Format8\JSON;
use App8\Format8\XML;
use App8\Format8\YAML;
use App8\Format8\NamedFormatInterface;
=======
use App\Format8\BaseFormat;
use App\Format8\FromStringInterface;
use App\Format8\JSON;
use App\Format8\XML;
use App\Format8\YAML;
use App\Format8\NamedFormatInterface;
>>>>>>> 02e56e2cfc3bd91abf260ecf8facff9ec0fb0d16

print_r("Anonymous functions\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];
$formats = [
    new JSON($data),
    new XML($data),
    new YAML($data)
];

function findByName(string $name, array $formats): ?BaseFormat {
    $found = array_filter($formats, function ($format) use ($name) {
        return $format->getName() === $name;
    });

    if(count($found)){
        return reset($found);
    }
    return null;
}

var_dump(findByName('XML', $formats));