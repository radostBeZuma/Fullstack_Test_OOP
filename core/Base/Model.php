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

    protected function findOne($query)
    {
        $result = mysqli_query(self::$link, $query) or die(mysqli_error(self::$link));
        return mysqli_fetch_assoc($result);
    }

    protected function getRowsLimitNOffset($query, $limit, $offset) {
        $stmt = mysqli_prepare(self::$link, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $limit, $offset);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
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

    protected function deleteId($id) {
        $stmt = mysqli_prepare(self::$link, "DELETE FROM news WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) != 1) {
            return false;
        }
        mysqli_stmt_close($stmt);
        return true;
    }

    protected function getById($id, $query) {
        $stmt = mysqli_prepare(self::$link, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    protected function update($query, $fields, $types) {
        $stmt = mysqli_prepare(self::$link, $query);
        $this->myBind($stmt, $types, $fields);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) != 1) {
            return false;
        }
        mysqli_stmt_close($stmt);
        return true;
    }

    private function myBind($stmt, $types, $data) {
        $references_to_data = array();
        foreach ($data as &$reference) { $references_to_data[] = &$reference; }
        unset($reference);
        call_user_func_array(
            array($stmt, "bind_param"),
            array_merge(array($types), $references_to_data));
    }
}