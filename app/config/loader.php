<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
    'Phalconvn\Models' => $config->application->modelsDir,
    'Phalconvn\Controllers' => $config->application->controllersDir,
    'Phalconvn\Helpers' => $config->application->helpersDir,
    'Phalconvn' => $config->application->libraryDir,
    'Phalconvn\Forms' => $config->application->formsDir,
));

$loader->register();
