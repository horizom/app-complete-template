<?php

use Horizom\Routing\RouteCollector;

/** 
 * @var RouteCollector $router
 */

$router->any('/', 'MainController@index');
$router->any('/status', 'MainController@status');
$router->any('/version', 'MainController@version');
