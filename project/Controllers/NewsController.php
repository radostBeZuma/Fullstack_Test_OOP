<?php
namespace Project\Controllers;
use Core\Base\Controller;
use Project\Models\NewsModel;

class NewsController extends Controller
{
    public $title = 'Новости';

    public function index($params)
    {
        $model = (new NewsModel())->index();
        echo '<pre>';
        print_r($model);
        echo '</pre>';

        return $this->render('news/index', ['a' => 'e']);
    }
}