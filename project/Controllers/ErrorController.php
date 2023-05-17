<?php
namespace Project\Controllers;
use Core\Base\Controller;

class ErrorController extends Controller
{
    public function notFound() {
        return $this->render('Страница не найдена', 'error/notFound');
    }
}