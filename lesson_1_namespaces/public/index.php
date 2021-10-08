<?php

require __DIR__.'/../vendor/autoload.php';

// use App\Format;
// use App\Format as F;
// use App\Format\{JSON,XML,YAML}
 use App\Format1\JSON;
 use App\Format1\XML;
 use App\Format1\YAML;

// $json = new App\Format\JSON();
// $xml = new App\Format\XML();
// $yml = new App\Format\YAML();

// $json = new F\JSON();
// $xml = new F\XML();
// $yml = new F\YAML();

 $json = new JSON();
 $xml = new XML();
 $yml = new YAML();

print_r("Namespaces");

 print_r($json);
 print_r($xml);
 print_r($yml);