<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$loader = require __DIR__.'/../vendor/autoload.php';

// intl
if (!function_exists('intl_get_error_code')) {
    require_once __DIR__.'/../vendor/symfony/symfony/src/Symfony/Component/Locale/Resources/stubs/functions.php';
}

$loader->add('Application', __DIR__);
$loader->add('Pagerfanta', __DIR__.'/../vendor/pagerfanta/src');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
