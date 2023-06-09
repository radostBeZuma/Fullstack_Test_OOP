<?php

use Core\Router\Route;

return [
    new Route('/', 'news', 'index'),
    new Route('/page/:page/', 'news', 'index'),

    new Route('/create/', 'news', 'create'),
    new Route('/delete/:id/', 'news', 'delete'),
    new Route('/update/:id/', 'news', 'update'),
    
    new Route('/:id/', 'news', 'detail'),
];