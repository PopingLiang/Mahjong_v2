<?php
class session extends Database
{
    public function __construct()
    {
        session_start();
    }

    //設定session直
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public function close()
    {
        session_destroy();
    }
}
