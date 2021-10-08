<?php

use App13\Kernel;

require __DIR__ . '/../vendor/autoload.php';



print_r("Annotations<br><br>");

$kernel = new Kernel();
$kernel->boot();
$kernel->handleRequest();





