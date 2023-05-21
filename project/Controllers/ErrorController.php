<?php
namespace Project\Controllers;
use Core\Base\Controller;

class ErrorController extends Controller
{
    public function notFound() {
        $this->setLayout('error');
        return $this->render('Страница не найдена', 'error/notFound');
    }

    private function setLayout($name) {
        return $this->layout = $name;
    }
}