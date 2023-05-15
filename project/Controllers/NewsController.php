<?php
namespace Project\Controllers;
use Core\Base\Controller;
use Project\Models\NewsModel;

class NewsController extends Controller
{
    public $title = 'Список новостей';

    public function index($params)
    {
        $allNews = (new NewsModel())->index();

        return $this->render('news/index', ['allNews' => $allNews]);
    }
}