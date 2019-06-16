<?php
namespace app\demo\controller;
use app\demo\controller\Base;
use \think\Controller;
use \think\Db;
use \think\Session;
//define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Order extends Base
{
    public function index(){
        $a=Session::get('uid');
        $rs=Db::table("Order2 o,good g,user u,phone p,address a")->
                   where("o.gid=g.gid and o.uid=u.uid and o.aid=a.aid and g.pid=p.pid and u.uid='$a' ")
              ->select();

        $this->assign("rs",$rs);
        return $this->fetch();
    }



}