<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\Router;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

use Phalconvn\Auth\Auth,
    Phalconvn\Acl\Acl,
    Phalconvn\Mail\Mail,
    Phalconvn\Elements;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

/* Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
        APP_PATH . '/helpers/',
        APP_PATH . '/forms/',
        APP_PATH . '/library/'
    ]
);

$loader->registerNamespaces(array(
    'Phalconvn\Models' => APP_PATH . '/models/',
    'Phalconvn\Controllers' => APP_PATH . '/controllers/',
    'Phalconvn\Forms' => APP_PATH . '/forms/',
    'Phalconvn' => APP_PATH . '/library/'
));

$loader->register();

$container = new FactoryDefault();

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream();

        $session
            ->setAdapter($files)
            ->start();

        return $session;
    }
);

$container->set('auth', function () {
    return new Auth();
});

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'root',
                'password' => 'root',
                'dbname'   => 'phalcon',
            ]
        );
    }
);

$container->set(
    'router',
    function () {
        require APP_PATH . '/config/router.php';

        return $router;
    }
);

//$router = $container->getRouter(false);

$router->handle($_GET['_url'] ?? '/');

$application = new Application($container);

try {
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
*/
try {
    $config = include APP_PATH . "/config/config.php";
    include APP_PATH . "/config/loader.php";
    include APP_PATH . "/config/services.php";
    $application = new Phalcon\Mvc\Application($di);
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
    //phpinfo();
    /*$response = new Phalcon\Http\Response();

	//Set status code
	$response->setStatusCode(404, "Not Found");

	//Set the content of the response
	$response->setContent("Sorry,My Website  in maintenance.");

	//Send response to the client
	$response->send();*/
}
