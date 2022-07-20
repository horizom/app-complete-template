<?php

if (version_compare(PHP_VERSION, '8.0') === -1) {
    $version = explode('-', PHP_VERSION);
    $message =  'This version of BabiPHP requires at least PHP 8.0 but you are currently running PHP ' . $version[0] . '. Please update your PHP version.';
    throw new \Exception($message, 1);
}

define('HORIZOM_ROOT', dirname(dirname(__FILE__)));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require HORIZOM_ROOT . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new \Horizom\Core\App();

/*
|--------------------------------------------------------------------------
| Setup Environment
|--------------------------------------------------------------------------
|
*/

if (file_exists(HORIZOM_ROOT . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(HORIZOM_ROOT);
    $dotenv->load();
}

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
*/

$app->configure('app');
$app->configure('auth');
$app->configure('database');
$app->configure('mail');

/*
|--------------------------------------------------------------------------
| Register Error Handler
|--------------------------------------------------------------------------
|
| Things go wrong. You can’t predict errors, but you can anticipate them. 
| Each Horizom application has an error handler that receives all 
| uncaught PHP exceptions. This error handler also receives the current HTTP 
| request and response objects, too. The error handler must prepare and return 
| an appropriate Response object to be returned to the HTTP client.
|
*/

$app->setErrorHandler(\App\Middlewares\ErrorHandlerMiddleware::class);

/*
|--------------------------------------------------------------------------
| Register Middleware dependencies
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

require __DIR__ . '/dependencies.php';

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\\Controllers\\Web\\',
    'middleware' => $routeMiddlewares['web'],
], function ($router) {
    require HORIZOM_ROOT . '/routes/web.php';
});

$app->router->group([
    'prefix' => 'admin',
    'namespace' => 'App\\Controllers\\Admin\\',
    'middleware' => $routeMiddlewares['admin'],
], function ($router) {
    require HORIZOM_ROOT . '/routes/admin.php';
});

$app->router->group([
    'prefix' => 'api',
    'namespace' => 'App\\Controllers\\Api\\',
    'middleware' => $routeMiddlewares['api'],
], function ($router) {
    require HORIZOM_ROOT . '/routes/api.php';
});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;