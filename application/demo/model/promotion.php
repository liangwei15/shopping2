<?php
namespace app\demo\model;
use \think\Session;
use \think\Model;
use \think\Db;

class promotion extends Model
{
    public function login($a,$p)
    {
        if(request()->isPost()){
            $rs=Db::name("promotion ")-> field('time')->select();
            $rs2=Db::name("promotion ")->select();
            dump($rs2);

        }

        return $this->fetch();
    }

}
?>