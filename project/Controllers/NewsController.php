<?php
namespace Project\Controllers;
use Core\Base\Controller;
use Project\Models\NewsModel;

class NewsController extends Controller
{
    private $errorArr = [
        'ok' => false,
    ];

    private $output = '';

    private $newFileName = [];

    private $valid = [];

    public function index($params)
    {
        $numberNewsOnePage = 20;

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

    public function create() {
        $data = [
            'title' => [
                'type' => 'input',
                'data' => $_POST['title'] ?? null,
            ],
            'anounce' => [
                'type' => 'input',
                'data' => $_POST['anounce'] ?? null,
            ],
            'fileAnounce' => [
                'type' => 'file',
                'data' => $_FILES['fileAnounce'] ?? null,
            ],
            'detail' => [
                'type' => 'input',
                'data' => $_POST['detail'] ?? null,
            ],
            'fileDetail' => [
                'type' => 'file',
                'data' => $_FILES['fileDetail'] ?? null,
            ],
        ];

        if($this->validFields($data)){

            $this->uploadFile('fileAnounce', $this->valid['fileAnounce']);
            $this->valid['fileAnounce'] = $this->newFileName['fileAnounce'];

            $this->uploadFile('fileDetail', $this->valid['fileDetail']);
            $this->valid['fileDetail'] = $this->newFileName['fileDetail'];

            $allField = $this->valid;

            $save = (new NewsModel())->saveNewNews($allField['title'], $allField['anounce'], $allField['fileAnounce'], $allField['detail'], $allField['fileDetail']);
            if($save) {
                $id = (new NewsModel())->getLastIdNews();
                $this->errorArr['id'] = $id;
                $this->errorArr['ok'] = true;
                $this->output =  $this->errorArr;
            }
            else {
                $this->errorArr['fields']['all'] = ($this->errorMsg())['5'];
                $this->output = $this->errorArr;
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        die(json_encode($this->output));
    }

    private function validFields($fields) {
        foreach ($fields as $nameField => $data) {
            switch ($data['type']) {
                case 'input':
                    if (empty($data['data'])) {
                        $this->errorArr['fields'][$nameField] = ($this->errorMsg())['1'];
                    }
                    else {
                        $fields[$nameField]['data'] = $this->validateSimpleText($data['data']);
                    }
                    break;
                case 'file':
                    if (empty($data['data'])) {
                        $this->errorArr['fields'][$nameField] = ($this->errorMsg())['1'];
                    }
                    else {
                        $this->validFile($nameField, $data['data']);
                    }
                    break;
            }
        }

        if (!empty($this->errorArr['fields'])) {
            $this->output = $this->errorArr;
            return false;
        } else {
            foreach ($fields as $key => $field) {
                $this->valid[$key] = $field['data'];
            }

            return true;
        }

    }

    private function validateSimpleText($field) {
        $field = trim($field);
        $field = stripslashes($field);
        // $field = htmlspecialchars($field);
        return $field;
    }

    private function validFile($name, $file) {
        $fileSizeLimit = 5 * 1024 * 1024;
        $allowedTypes  = [
            IMAGETYPE_GIF,
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_BMP,
            IMAGETYPE_TIFF_II,
            IMAGETYPE_TIFF_MM
        ];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errorArr['fields'][$name] = ($this->errorMsg())['2'];
            $this->output = $this->errorArr;
        }

        if (!$this->validateFileSize($file['tmp_name'], $fileSizeLimit)) {
            $this->errorArr['fields'][$name] = ($this->errorMsg())['3'];
            $this->output = $this->errorArr;
        }

        if(!$this->validateFileType($file['tmp_name'], $allowedTypes)) {
            $this->errorArr['fields'][$name] = ($this->errorMsg())['4'];
            $this->output = $this->errorArr;
        }
    }

    private function validateFileSize($name, $maxSizeLimit)
    {
        return filesize($name) <= $maxSizeLimit;
    }

    private function validateFileType($name, $types)
    {
        return in_array(
            exif_imagetype($name),
            $types,
            true
        );
    }

    private function uploadFile($name, $file) {
        $uploadDir =  '/project/webroot/upload/';
        $getFullDir = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

        $filename   = uniqid() . "-" . time();
        $extension  = pathinfo( $file["name"], PATHINFO_EXTENSION );
        $allName   = $filename . "." . $extension;

        $destName = $getFullDir . $allName;

        $this->newFileName[$name] = $uploadDir . $allName;

        $this->moveFile($file['tmp_name'], $destName);

    }

    private function moveFile($from, $to)
    {
        return move_uploaded_file($from, $to);
    }

    private function errorMsg() {
        return [
            '0' => 'Форма не заполнена',
            '1' => 'Пустое значение в поле',
            '2' => 'При загрузке была ошибка, попробуйте снова',
            '3' => 'Превышен размер файла',
            '4' => 'Неверный тип файла',
            '5' => 'Попробуйте снова'
        ];
    }

    public function delete($params) {
        (new NewsModel())->deleteNewsById($params['id']);

        $_SESSION['alert'] = 'msg';
        header("Location: /");
    }

    public function detail($params)
    {

        $oneNews = (new NewsModel())->detail($params['id']);

        return $this->render('Детальная страница', 'news/detail', ['oneNews' => $oneNews]);
    }
}