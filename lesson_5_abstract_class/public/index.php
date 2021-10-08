<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Format5\JSON;
use App\Format5\XML;
use App\Format5\YAML;

print_r("Inheritance\n\n");

$data = [
    "name" => "John",
    "surname" => "Doe"
];

$json = new JSON($data);
$xml = new XML($data);
$yml = new YAML($data);

var_dump($json);
var_dump($xml);
var_dump($yml);

print_r("\n\nResult of conversion\n\n");
var_dump($json->convert());
var_dump($xml->convert());
var_dump($yml->convert());
