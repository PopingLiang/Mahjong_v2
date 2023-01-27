<?php

class Database
{
    // 設定資料庫的常數來自於 config/config.php
    private static $host = DB_HOST;
    private static $dbname = DB_NAME;
    private static $user = DB_USER;
    private static $pass = DB_PASS;

    // 定義一些操作 Database 的變數，例如：
    private $dbh;
    private $stmt;
    private $error;

    private static function connect()
    {
        // 透過 PDO 建立資料庫連線
        // 實例化 PDO
        try {
            $conn = new PDO("mysql:host=" . self::$host . ";charset=utf8;dbname=" . self::$dbname, self::$user, self::$pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            //echo "Connected Successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Bind values
    public function bind($param, $value, $type = null)
    {
    }

    // 執行 prepared statement
    public static function execute($sql, $data, $fetch_control = true, $insertID = false)
    {
        $conn = self::connect();
        $prepare = $conn->prepare($sql);
        $query = $prepare->execute($data);

        $control = explode(' ', $sql)[0];

        switch ($control) {
            case 'SELECT':
                if ($fetch_control) {
                    return $prepare->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return $prepare->fetch(PDO::FETCH_ASSOC);
                }
                break;
            case 'UPDATE':
                return $query;
                break;
            case 'INSERT':
                if ($insertID) return $conn->lastInsertId();
                return $query;
                break;
        }
    }



    // 以下是 Model 可以操作資料庫的幾個預設方法
    // 可以自行定義更多需要的或常用的

    // 取得資料表的所有資料
    public function getAll($conn)
    {
        return $conn->fetchAll(PDO::FETCH_ASSOC);
    }

    // 取得資料表的單一筆資料
    public static function getSingle($sql, $data)
    {
    }
    // 取得資料表中資料的筆數
    public function getRowCount()
    {
    }
}
