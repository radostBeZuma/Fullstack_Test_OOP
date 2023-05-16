<?php
namespace Project\Controllers;
use Core\Base\Controller;
use Project\Models\NewsModel;

class NewsController extends Controller
{

    public function index($params)
    {
        $allNews = (new NewsModel())->index();

        return $this->render('Список новостей', 'news/index', ['allNews' => $allNews]);
    }

    public function detail($params)
    {

        $oneNews = (new NewsModel())->detail($params['id']);

        return $this->render('Детальная страница', 'news/detail', ['oneNews' => $oneNews]);
    }
}