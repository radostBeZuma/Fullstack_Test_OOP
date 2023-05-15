<?php
namespace Core;
use Core\Core;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once __DIR__ . '/vendor/autoload.php';

function debug($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

$core = new Core();
$core->index();
