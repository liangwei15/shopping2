<?php
namespace app\api\controller;
use \think\Db;
use \think\Controller;

class Phone extends Controller
{
    public function index(){
        $rs=Db::name("phone")->select();
        return json($rs);
    }


}