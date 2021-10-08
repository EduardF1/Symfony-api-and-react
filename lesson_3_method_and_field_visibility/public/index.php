<?php

require __DIR__ . '/../vendor/autoload.php';

// use App3\Format;
// use App3\Format as F;
// use App3\Format\{JSON,XML,YAML}
use App3\Format3\JSON;
use App3\Format3\XML;
use App3\Format3\YAML;

// $json = new App3\Format\JSON();
// $xml = new App3\Format\XML();
// $yml = new App3\Format\YAML();

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