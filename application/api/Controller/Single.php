<?php
namespace app\api\controller;
use \think\Db;
use \think\Controller;

class Single extends Controller
{
    public function index($id,$colour,$Ram){
        $rs=Db::name("Good g")->where("g.colour='$colour' and g.Ram='$Ram' and g.pid='$id'")->select();
        return json($rs);
    }


}