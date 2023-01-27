<?php
class Mahjong extends Controller
{
    public function index()
    {
        Controller::view("Mahjong/index");
    }

    public function main()
    {
        Controller::view("Mahjong/main");
    }
}
