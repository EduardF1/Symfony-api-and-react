<?php

require __DIR__ . '/../vendor/autoload.php';


use App4\Format4\JSON;
use App4\Format4\XML;
use App4\Format4\YAML;

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