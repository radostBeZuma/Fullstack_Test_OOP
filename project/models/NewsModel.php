<?php
namespace Project\Models;
use Core\Base\Model;


class NewsModel extends Model
{
    public function detail($id) {
        $query = 'SELECT * FROM `news` WHERE `id` = ?';
        return  $this->getById($id, $query);
    }

    public function getRows($offset, $limit) {
        $query = 'SELECT * FROM `news` order by date_created desc, id asc limit ' . $offset . ',' . $limit;
        return $this->findMany($query);
    }

    public function getCountFields() {
        $query = 'SELECT COUNT(id) as total FROM `news`';
        $data = $this->findOne($query);
        return $data['total'];
    }

    public function saveNewNews($title, $anounce, $fileAnounce, $detail, $fileDetail) {
        return $this->save($title, $anounce, $fileAnounce, $detail, $fileDetail);
    }

    public function getLastIdNews()
    {
        return $this->getLastId();
    }

    public function deleteNewsById($id){
        return $this->deleteId($id);
    }

    public function getLinksFiles($id) {
        $query = 'SELECT `announce_url`, `detail_url` FROM news WHERE id = ?';

        return $this->getById($id, $query);
    }

    public function getOldUrl($id, $files){
        $sql = [];
        $query = 'SELECT ';

        if (isset($files['fileAnounce'])) {
            $sql[] = ' `announce_url` ';
        }

        if (isset($files['fileDetail'])) {
            $sql[] = ' `detail_url` ';
        }

        $query .=  implode(',', $sql) . 'FROM news WHERE id=?';

        return $this->getById($id, $query);
    }
    
    public function updateTable($id, $fields) {
        $counter = 0;
        $sql = [];

        $fields['id'] = $id;

        $query = 'UPDATE `news` SET ';

        if (isset($fields['title'])) {
            $sql[] = ' `title` = ? ';
            $counter++;
        }

        if (isset($fields['anounce'])) {
            $sql[] = ' `announce_text` = ? ';
            $counter++;
        }

        if (isset($fields['detail'])) {
            $sql[] = ' `detail_text` = ? ';
            $counter++;
        }

        if (isset($fields['fileAnounce'])) {
            $sql[] = ' `announce_url` = ? ';
            $counter++;
        }

        if (isset($fields['fileDetail'])) {
            $sql[] = ' `detail_url` = ? ';
            $counter++;
        }

        $query .= implode(',', $sql) . 'WHERE id = ?';

        $types = $this->bindTypes($counter);

        return $this->update($query, $fields, $types);
    }

    private function bindTypes($c) {
        $str = '';

        for ($i = 0; $i < $c; $i++) {
            $str .= 's';
        }

        $str .= 'i';

        return $str;
    }

}