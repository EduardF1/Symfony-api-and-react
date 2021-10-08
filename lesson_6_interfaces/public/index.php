<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Format6\FromStringInterface;
use App\Format6\JSON;
use App\Format6\XML;
use App\Format6\YAML;
use App\Format6\NamedFormatInterface;

print_r("Interfaces\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];

$json = new JSON($data);
$xml = new XML($data);
$yml = new YAML($data);

print_r("\n\nResult of conversion\n\n");

$formats = [$json, $xml, $yml];

foreach ($formats as $format){

    if($format instanceof NamedFormatInterface){
        var_dump($format->getName());
    }

    var_dump($format->convert());
    var_dump($format instanceof FromStringInterface);

    if($format instanceof FromStringInterface){
        var_dump($format->convertFromString('{"name":"John", "surname":"Doe"}'));
    }
}

var_dump($json->convertFromString('{"name":"John", "surname":"Doe"}'));
