<?php

require __DIR__ . '/../vendor/autoload.php';

use App11\Format11\BaseFormat;
use App11\Format11\FromStringInterface;
use App11\Format11\JSON;
use App11\Format11\XML;
use App11\Format11\YAML;
use App11\Format11\NamedFormatInterface;
use App11\Service\Serializer;
use App11\Controller\IndexController;
use App11\Container;

print_r("Simple Service Container\n\n");

$container = new Container();

$container->addService('format.json', function() use ($container) {
    return new JSON();
});

$container->addService('format.xml', function() use ($container) {
    return new XML();
});

$container->addService('format', function() use ($container) {
    return $container->getService('format.xml');
});

$container->addService('serializer', function() use ($container) {
    return new Serializer($container->getService('format'));
});

$container->addService('controller.index', function() use ($container) {
    return new IndexController($container->getService('serializer'));
});

var_dump($container->getServices());
var_dump($container->getService('controller.index')->index());



