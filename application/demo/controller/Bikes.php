<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;
class Bikes extends Controller
{
    public function index()
    {
        $view = new \think\View();
        return $view->fetch();
    }
}
