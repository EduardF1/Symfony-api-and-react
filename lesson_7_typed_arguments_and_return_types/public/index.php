<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Format7\BaseFormat;
use App\Format7\FromStringInterface;
use App\Format7\JSON;
use App\Format7\XML;
use App\Format7\YAML;
use App\Format7\NamedFormatInterface;

print_r("Typed argument & return types\n\n");

function convertData(BaseFormat $format): string
{
    return $format->convert();
}

function getFormatName(NamedFormatInterface $format): string
{
    return $format->getName();
}

function getFormatByName(array $formats, string $name): ?BaseFormat
{
    foreach ($formats as $format) {
        if ($format instanceof NamedFormatInterface && $format->getName() === $name) {
            return $format;
        }
    }
    return null;
}

function justDumpData(BaseFormat $format): void {
    var_dump($format->convert());
}

$data = [
    "name" => "John",
    "surname" => "Doe"
];
$formats = [
    new JSON($data),
    new XML($data),
    new YAML($data)
];

var_dump(getFormatByName($formats, 'XML'));
justDumpData($formats[0]);

