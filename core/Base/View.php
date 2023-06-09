<?php
namespace Core\Base;
use Core\Router\Page;

class View
{
    public function render(Page $page) {
        return $this->renderLayout($page, $this->renderView($page));
    }

    private function renderLayout(Page $page, $content) {
        $layoutPath = $_SERVER['DOCUMENT_ROOT'] . "/project/Layouts/{$page->layout}.php";

        if (file_exists($layoutPath)) {
            ob_start();
            $title = $page->title;
            require $layoutPath;
            return ob_get_clean();
        } else {
            echo "Не найден файл с лейаутом по пути $layoutPath"; die();
        }
    }

    private function renderView(Page $page) {
        if ($page->view) {
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . "/project/Views/{$page->view}.php";

            if (file_exists($viewPath)) {
                ob_start();
                $data = $page->data;
                extract($data);
                require $viewPath;
                return ob_get_clean();
            } else {
                echo "Не найден файл с представлением по пути $viewPath"; die();
            }
        }
    }
}