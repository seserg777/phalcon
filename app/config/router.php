<?php use Phalcon\Mvc\Router;

$router = new Router(false);

$router->addGet(
    '/admin',
    [
        'controller' => 'admin',
        'action'     => 'index',
    ]
);

$router->add(
    '/admin/user/create',
    'User::edit'
)->via(
    [
        'POST',
        'GET',
    ]
);

$router->addGet(
    '/registration',
    [
        'controller' => 'user',
        'action'     => 'index',
    ]
);

$router->addPost(
    '/registration',
    [
        'controller' => 'user',
        'action'     => 'register',
    ]
);

$router->addGet(
    '/logout',
    [
        'controller' => 'user',
        'action'     => 'logout',
    ]
);

$router->addGet(
    '/login',
    [
        'controller' => 'user',
        'action'     => 'login',
    ]
);

$router->addPost(
    '/login',
    [
        'controller' => 'user',
        'action'     => 'login',
    ]
);

$router->addGet(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);

$router->notFound([
    "controller" => "index",
    "action" => "route404"
]);

return $router;