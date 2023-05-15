<?php
namespace Core\Base;
use Core\Router\Page;

class Controller
{
    protected $layout = 'default';

    protected function render($view, $data = []) {
        return new Page($this->layout, $this->title, $view, $data);
    }
}