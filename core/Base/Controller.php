<?php
namespace Core\Base;
use Core\Router\Page;

class Controller
{
    protected $layout = 'default';

    protected function render($title, $view, $data = []) {
        return new Page($this->layout, $title, $view, $data);
    }
}