<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions', __DIR__.'/../vendor/beberlei/DoctrineExtensions');
$classLoader->register();

return $loader;
