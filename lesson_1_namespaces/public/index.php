<?php

require __DIR__.'/../vendor/autoload.php';

// use App1\Format;
// use App1\Format as F;
// use App1\Format\{JSON,XML,YAML}
 use App1\Format1\JSON;
 use App1\Format1\XML;
 use App1\Format1\YAML;

// $json = new App1\Format\JSON();
// $xml = new App1\Format\XML();
// $yml = new App1\Format\YAML();

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