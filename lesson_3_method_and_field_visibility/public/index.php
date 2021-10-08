<?php

require __DIR__ . '/../vendor/autoload.php';

// use App\Format;
// use App\Format as F;
// use App\Format\{JSON,XML,YAML}
use App\Format3\JSON;
use App\Format3\XML;
use App\Format3\YAML;

// $json = new App\Format\JSON();
// $xml = new App\Format\XML();
// $yml = new App\Format\YAML();

// $json = new F\JSON();
// $xml = new F\XML();
// $yml = new F\YAML();

print_r("Class fields & methods\n\n");

$json = new JSON([
    "key" => "value",
    "second_key" => "second_value"
]);

$xml = new XML();
$yml = new YAML();


var_dump($json->getData());
$json->setData(['a', 'b', 'c']);
var_dump($json->getData());
var_dump((string)$json);