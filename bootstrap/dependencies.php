<?php

/**
 * @var \Horizom\Core\App $app
 */


/*
|--------------------------------------------------------------------------
| Database initialization
|--------------------------------------------------------------------------
*/

$connections = config('database.connections');
$default = config('database.default');
$dbManager = new \Illuminate\Database\Capsule\Manager();
$dbManager->addConnection($connections[$default]);
$dbManager->setAsGlobal();
$dbManager->bootEloquent();

$platform = $dbManager->getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');


/*
|--------------------------------------------------------------------------
| Auth Setup
|--------------------------------------------------------------------------
*/

$authDb = \Illuminate\Database\Capsule\Manager::connection()->getPdo();
$auth = new \Horizom\Auth\Auth($authDb, config("auth.tables"));
$auth->setPasswordHashAlgorithm(PASSWORD_DEFAULT);

// register auth service
$app->container()->set(\Horizom\Auth\Auth::class, $auth);

// persistence key
$key = Illuminate\Support\Str::slug(config('app.name')) . '-persistence';
$app->container()->set('persistenceKey', $key);

// Normalize the trailing slash of the uri path
$app->add((new \Middlewares\TrailingSlash())->redirect());


/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
*/

// Production middleware
if (config('app.env') === 'production') {
    // Redirect www
    if (config('app.redirect.www') === true) {
        $app->add(new \Middlewares\Www(true));
    }

    // Redirect https
    if (config('app.redirect.https') === true) {
        $app->add(new \Middlewares\Https());
    }
}

// Implement content negotiation
$app->add(new \Middlewares\ContentType());

// Specific route Middlewares
$routeMiddlewares = [
    'web' => [
        (new \Middlewares\Robots(true))->sitemap('/sitemap.xml'),
    ],
    'api' => [
        new \Middlewares\Robots(false),
        \App\Middlewares\CorsMiddleware::class,
        \Middlewares\JsonPayload::class,
    ],
    'admin' => [
        new \Middlewares\Robots(false),
    ],
];
