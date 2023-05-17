<?php
namespace Project\Controllers;
use Core\Base\Controller;
use Project\Models\NewsModel;

class NewsController extends Controller
{

    public function index($params)
    {
        $numberNewsOnePage = 6;

        if (empty($params['page'])) {
            $currentPage = 1;
        }
        else {
            $currentPage = $params['page'];
        }

        $offset = ($currentPage * $numberNewsOnePage)- $numberNewsOnePage;

        $getNewsLimit = (new NewsModel())->getRows($offset, $numberNewsOnePage);

        if (!empty($getNewsLimit)) {

            // пагинация
            $numberNewsTable = (new NewsModel())->getCountFields();
            $numPage = intdiv($numberNewsTable, $numberNewsOnePage);

            if (fmod($numberNewsTable, $numberNewsOnePage) != 0) {
                $numPage++;
            }

            $arr = [];

            for ($i = 1; $i <= $numPage; $i++) {
                $arr['count_page'][$i] = $i;
            }

            $arr['current_page'] = $currentPage;

            return $this->render('Список новостей', 'news/index', ['allNews' => $getNewsLimit, 'pag' => $arr]);
        }
        else {
            return $this->render('Страница не найдена', 'error/notFound');
        }
    }

    public function detail($params)
    {

        $oneNews = (new NewsModel())->detail($params['id']);

        return $this->render('Детальная страница', 'news/detail', ['oneNews' => $oneNews]);
    }
}