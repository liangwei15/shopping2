<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Shopadmin extends Sbase
{
    public function index(){
//        Session::set('search',4);
        $rs=Db::name("shopadmin")->order('sid')->paginate(5);
        $this->assign("sadmin",$rs);
        return $this->fetch();
    }

    public function delete($sid){
        if(Db::name("shopadmin")->delete($sid))
            $this->success();
        else $this->fail();
    }

    public function update(){
        $data=[
            'sname'=>input('sname'),
            'sphone'=>input('sphone'),
            'spwd'=>md5(input('spwd')),
        ];
        $sid=input('sid');
        if(Db::name("shopadmin")->where('sid',$sid)->update($data)){
            $this->success('修改成功','index');
        }
        else{
            $this->error('修改失败','index');
        }
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'sname'=>input('sname'),
                'sphone'=>input('sphone'),
                'spwd' => input('spwd'),
            ];
            $res = Db::name("shopadmin")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }

    public function edit(){
        $sid=input('param.sid');
        $type=Db::name("shopadmin")->find($sid);
        echo json_encode($type);
    }


}