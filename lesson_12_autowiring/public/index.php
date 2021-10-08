<?php

require __DIR__ . '/../vendor/autoload.php';

use App12\Format12\BaseFormat;
use App12\Format12\FromStringInterface;
use App12\Format12\JSON;
use App12\Format12\XML;
use App12\Format12\YAML;
use App12\Format12\NamedFormatInterface;
use App12\Service\Serializer;
use App12\Controller\IndexController;
use App12\Container;
use App12\Format12\FormatInterface;

print_r("Autowired Service Container<br><br>");

$container = new Container();

$container->addService('format.json', function() use ($container) {
    return new JSON();
});

$container->addService('format.xml', function() use ($container) {
    return new XML();
});

$container->addService('format', function() use ($container) {
    return $container->getService('format.json');
}, FormatInterface::class);

$container->loadServices('App12\\Service');
$container->loadServices('App12\\Controller');

echo '<br>';
var_dump($container->getServices());
echo '<br>';
var_dump($container->getService('App12\\Controller\\IndexController')->index());
var_dump($container->getService('App12\\Controller\\PostController')->index());
echo '<br>';



