<?php

require __DIR__ . '/../vendor/autoload.php';

// use App2\Format2;
// use App2\Format2 as F;
// use App2\Format2\{JSON,XML,YAML}
use App2\Format2\JSON;
use App2\Format2\XML;
use App2\Format2\YAML;

// $json = new App2\Format2\JSON();
// $xml = new App2\Format2\XML();
// $yml = new App2\Format2\YAML();

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

//$json->data = "Some field/property data";

print_r($json);
print_r($xml);
print_r($yml);

// accessing a public class member method
var_dump($json->convert());
// accessing a constant class member
var_dump(JSON::DATA);
// accessing a static method of a class
var_dump(JSON::convertData());