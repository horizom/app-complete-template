<?php

/**
 * @var \Horizom\Core\App $app
 */

/*
|--------------------------------------------------------------------------
| Storage initialization
|--------------------------------------------------------------------------
*/

$fsDefault = (string) config('filesystems.default');
$fsDisks = (array) config('filesystems.disks');
$fsLinks = (array) config('filesystems.links');
$storage = new \App\Providers\Storage\Storage($fsDefault, $fsDisks);

// Register auth storage
$app->container()->set(\App\Providers\Storage\Storage::class, $storage);

// Initialize symlinks
foreach ($fsLinks as $link => $target) {
    if (file_exists($target) && !file_exists($link)) {
        symlink($target, $link);
    }
}


/*
|--------------------------------------------------------------------------
| Database initialization
|--------------------------------------------------------------------------
*/

$connections = config('database.connections');
$default = config('database.default');
$manager = new \Illuminate\Database\Capsule\Manager();
$manager->addConnection($connections[$default]);
$manager->setAsGlobal();
$manager->bootEloquent();

$platform = $manager->getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
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
