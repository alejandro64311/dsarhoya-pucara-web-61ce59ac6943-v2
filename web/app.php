<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';
if (PHP_VERSION_ID < 70000) {
    include_once __DIR__.'/../var/bootstrap.php.cache';
}

$env = 'prod';
if (isset($_ENV['SYMFONY_ENV'])) {
    $env = $_ENV['SYMFONY_ENV'];
}

$debug = false;
if (isset($_ENV['SYMFONY_DEBUG'])) {
    $debug = (bool) $_ENV['SYMFONY_DEBUG'];
}

$kernel = new AppKernel($env, $debug);
if (PHP_VERSION_ID < 70000) {
    $kernel->loadClassCache();
}
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
