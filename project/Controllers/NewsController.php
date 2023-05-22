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

    private $response = [];

    private $inputFields = [];

    private $files = [];

    private $OldUrlFiles = [];

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        else {
            return $this->render('Страница не найдена', 'error/notFound');
        }
    }

    private function validFields($fields) {
        foreach ($fields as $nameField => $data) {
            switch ($data['type']) {
                case 'input':
                    if (empty($data['data'])) {
                        $this->errorArr['fields'][$nameField] = ($this->errorMsg())['1'];
                    }
                    else {
                        $this->valid[$nameField] = $this->validateSimpleText($data['data']);
                    }
                    break;
                case 'file':
                    if (empty($data['data'])) {
                        $this->errorArr['fields'][$nameField] = ($this->errorMsg())['1'];
                    }
                    else {
                        if($this->validFile($nameField, $data['data'])) {
                            $this->valid[$nameField] = $data['data'];
                        }
                    }
                    break;
            }
        }

        if (!empty($this->errorArr['fields'])) {
            $this->output = $this->errorArr;
            return false;
        } else {
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
        $err = 0;

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
            $err++;
        }

        if (!$this->validateFileSize($file['tmp_name'], $fileSizeLimit)) {
            $this->errorArr['fields'][$name] = ($this->errorMsg())['3'];
            $err++;
        }

        if(!$this->validateFileType($file['tmp_name'], $allowedTypes)) {
            $this->errorArr['fields'][$name] = ($this->errorMsg())['4'];
            $err++;
        }

        if ($err > 0) {
            return false;
        }
        else {
            return true;
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
            '5' => 'Попробуйте снова',
            '6' => 'Данные совпадаю, внесите новые',
        ];
    }

    public function delete($params) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $params['id'];

            $this->getLinksOldFiles($id);

            if ((new NewsModel())->deleteNewsById($id)) {
                $this->deleteFiles($this->OldUrlFiles);
            }

            $_SESSION['alert'] = 'msg';
            header("Location: /");
        }
        else {
            return $this->render('Страница не найдена', 'error/notFound');
        }
    }

    private function getLinksOldFiles($id) {
        $linksOldFiles = (new NewsModel())->getLinksFiles($id);

        foreach ($linksOldFiles as $key => $oldUrl)
            $this->OldUrlFiles[$key] = $oldUrl;
    }

    public function update($params) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $params['id'];

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

            if ($this->checkEmptyFields($data) && $this->checkFields($data)) {

                if (!empty($this->files)) {

                    // получить старые урлы
                    $this->getOldFiles($id);

                    // загрузить файлы
                    if (isset($this->files['fileAnounce'])) {
                        $this->uploadFile('fileAnounce', $this->files['fileAnounce']);
                        $this->files['fileAnounce'] = $this->newFileName['fileAnounce'];
                    }

                    if (isset($this->files['fileDetail'])) {
                        $this->uploadFile('fileDetail', $this->files['fileDetail']);
                        $this->files['fileDetail'] = $this->newFileName['fileDetail'];
                    }

                    $allFields = array_merge($this->inputFields, $this->files);
                }
                else {
                    $allFields = $this->inputFields;
                }

                if((new NewsModel()) -> updateTable($id, $allFields)) {

                    // удаление файлов
                    $this->deleteFiles($this->OldUrlFiles);

                    $this->errorArr['ok'] = true;
                    $this->response =  $this->errorArr;

                } else {
                    $this->errorArr['fields']['all'] = ($this->errorMsg()['6']);
                    $this->response =  $this->errorArr;
                }

            } else {
                $this->response = $this->errorArr;
            }

            header('Content-Type: application/json; charset=utf-8');
            die(json_encode($this->response));
        }
        else {
            return $this->render('Страница не найдена', 'error/notFound');
        }
    }

    private function checkEmptyFields($fields) {
        $el = 0;

        foreach ($fields as $nameField => $data) {
            if (!empty($data['data'])) {
                $el++;
            }
        }

        if ($el > 0) {
            return true;
        }
        else {
            $this->errorArr['fields']['all'] = $this->errorMsg()['0'];
            return false;
        }
    }

    private function checkFields($fields) {
        foreach ($fields as $nameField => $data) {
            switch ($data['type']) {
                case 'input':
                    if (!empty($data['data'])) {
                        $this->inputFields[$nameField] = $this->validateSimpleText($data['data']);
                    }
                    break;
                case 'file':
                    if (!empty($data['data'])) {
                        if ($this->validFile($nameField, $data['data'])) {
                            $this->files[$nameField] = $data['data'];
                        }
                    }
                    break;
            }
        }

        if (!empty($this->errorArr['fields'])) {
            return false;
        } else {
            return true;
        }

    }

    private function getOldFiles($id) {
        $files = $this->files;

        $oldUrls = (new NewsModel())->getOldUrl($id, $files);

        foreach ($oldUrls as $key => $oldUrl) {
            $this->OldUrlFiles[$key] = $oldUrl;
        }
    }

    private function deleteFiles($files) {
        foreach ($files as $file) {
            $url = $_SERVER['DOCUMENT_ROOT'] . $file;
            if (file_exists($url)) {
                unlink($url);
            }
        }
    }

    public function detail($params)
    {
        $oneNews = (new NewsModel())->detail($params['id']);

        if($oneNews) {
            return $this->render('Детальная страница', 'news/detail', ['oneNews' => $oneNews]);
        }
        else {
            return $this->render('Страница не найдена', 'error/notFound');
        }
    }
}