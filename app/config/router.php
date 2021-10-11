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
    '/admin/user/{id:[0-9]+}/edit',
    'User::edit'
)->via(
    [
        'POST',
        'GET',
    ]
);

$router->add(
    '/admin/user/{id:[0-9]+}/edit/permissions',
    'User::editPermissions'
)->via(
    [
        'POST',
        'GET',
    ]
);

$router->add(
    '/admin/users/permissions',
    'Permissions::index'
)->via(
    [
        'GET'
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

$router->add(
    '/login',
    'User::login'
)->via(
    [
        'POST',
        'GET',
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