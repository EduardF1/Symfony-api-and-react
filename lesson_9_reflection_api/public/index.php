<?php

require __DIR__ . '/../vendor/autoload.php';

<<<<<<< HEAD
use App9\Format9\BaseFormat;
use App9\Format9\FromStringInterface;
use App9\Format9\JSON;
use App9\Format9\XML;
use App9\Format9\YAML;
use App9\Format9\NamedFormatInterface;
=======
use App\Format9\BaseFormat;
use App\Format9\FromStringInterface;
use App\Format9\JSON;
use App\Format9\XML;
use App\Format9\YAML;
use App\Format9\NamedFormatInterface;
>>>>>>> 02e56e2cfc3bd91abf260ecf8facff9ec0fb0d16

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

$class = new ReflectionClass(JSON::class);
var_dump($class);
$method = $class->getConstructor();
var_dump($method);
$parameters = $method->getParameters();
var_dump($parameters);

foreach ($parameters as $parameter){
    $type = $parameter->getType();
    var_dump((string)$type);
    var_dump($type->isBuiltin());
    var_dump($parameter->allowsNull());
    var_dump($parameter->getDefaultValue());
}