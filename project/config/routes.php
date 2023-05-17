<?php

use Core\Router\Route;

return [
    new Route('/', 'news', 'index'),
    new Route('/page/:page/', 'news', 'index'),
    new Route('/:id/', 'news', 'detail'),
];