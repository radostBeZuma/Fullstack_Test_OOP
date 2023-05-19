<?php
namespace Core\Base;


class Model
{
    private static $link;

    public function __construct()
    {
        if (!self::$link) {
            self::$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_query(self::$link, "SET NAMES 'utf8'");
        }
    }

    protected function findMany($query)
    {
        $result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }

    protected function findOne($query)
    {
        $result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
        return mysqli_fetch_assoc($result);
    }

    protected function save($title, $anounce, $anounceUrl, $detail, $detailUrl) {

        $stmt = mysqli_prepare(self::$link, "INSERT INTO news (`title`, `announce_text`, `announce_url`, `detail_text`, `detail_url`) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sssss', $title, $anounce, $anounceUrl, $detail, $detailUrl);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) != 1) {
            return false;
        }
        mysqli_stmt_close($stmt);
        return true;
    }

    protected function getLastId() {

        return mysqli_insert_id(self::$link);
    }
}