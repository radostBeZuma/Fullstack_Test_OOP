<?php
namespace Project\Models;
use Core\Base\Model;


class NewsModel extends Model
{
    public function detail($id) {
        $query ='SELECT * FROM `news` WHERE `id` = ' . $id;
        return $this->findOne($query);
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
}