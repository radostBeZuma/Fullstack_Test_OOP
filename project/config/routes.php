<?php

use Core\Router\Route;

return [
    new Route('/news/:id/:course/', 'news', 'index'),

];