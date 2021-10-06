<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

include BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
try {
    $dotenv->load();
    $dotenv->required(['DATA_MYSQL_HOST'])->notEmpty();
    $dotenv->required(['DATA_MYSQL_USER'])->notEmpty();
    $dotenv->required(['DATA_MYSQL_PASS'])->notEmpty();
    $dotenv->required(['DATA_MYSQL_NAME'])->notEmpty();
} catch ( Exception $e )  {
    echo $e->getMessage();
}

return new \Phalcon\Config([
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => $_ENV['DATA_MYSQL_HOST'],
        'username' => $_ENV['DATA_MYSQL_USER'],
        'password' => $_ENV['DATA_MYSQL_PASS'],
        'dbname'   => $_ENV['DATA_MYSQL_NAME']
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'helpersDir'     => APP_PATH . '/helpers/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'formsDir'       => APP_PATH . '/forms/',
        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ],
    'security'    => [
        'key'                => 'gMp0ScgdeH/mPL^.0!=yUvlQ\'YX8j$S5UQB,%|Rg{C,/}6SZn$)*>%(Lm+#<Fve'
    ]
]);