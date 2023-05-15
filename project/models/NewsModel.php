<?php
namespace Project\Models;
use Core\Base\Model;


class NewsModel extends Model
{
    public function index() {
        return $this->findOne('SELECT * FROM `news`');
    }
}