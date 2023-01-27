<?php

class Controller
{
    // 載入 model
    public static function model($model)
    {
        require_once './app/models/' . $model . '.php';
        return new $model();
    }

    // 載入 view
    // 其中 view 可能有需要從 Controller 帶過去的資料，故多了 $data 陣列作為第二個參數
    public function view($view, array $data = [])
    {
        // 如果檔案存在就引入它
        if (file_exists('./app/views/' . $view . '.php')) {
            require_once './app/views/' . $view . '.php';
        } else {
            require_once './app/views/errorPage.php';
            //die('View does not exist');
        }
    }
}
