<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Format8\BaseFormat;
use App\Format8\FromStringInterface;
use App\Format8\JSON;
use App\Format8\XML;
use App\Format8\YAML;
use App\Format8\NamedFormatInterface;

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