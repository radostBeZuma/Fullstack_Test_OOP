<?php
namespace Core;
use Core\Base\View;
use Core\Router\Router;
use Core\Router\Dispatcher;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/conn.php';

require_once __DIR__ . '/vendor/autoload.php';

function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

$routes = require $_SERVER['DOCUMENT_ROOT'] . '/project/config/routes.php';

$router = new Router();
$track  = $router->getTrack($routes, $_SERVER['REQUEST_URI']);
$page  = ( new Dispatcher )  -> getPage($track);
echo (new View) -> render($page);