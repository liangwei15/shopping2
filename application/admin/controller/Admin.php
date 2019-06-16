<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Admin extends Sbase
{
    public function index(){
//        Session::set('search',4);
        $rs=Db::name("admin")->order('aid')->paginate(5);
        $this->assign("admin",$rs);
        return $this->fetch();
    }

    public function delete($aid){
        if(Db::name("admin")->delete($aid))
            $this->success();
        else $this->fail();
    }

    public function update(){
        $data=[
            'aname'=>input('aname'),
            'aphone'=>input('aphone'),
            'apwd'=>md5(input('aphone')),
        ];
        $aid=input('aid');
        if(Db::name("admin")->where('aid',$aid)->update($data)){
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
                'aname'=>input('aname'),
                'aphone'=>input('aphone'),
                'apwd' => md5(input('apwd')),
                ];
            $res = Db::name("admin")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }
    public function edit(){
        $aid=input('param.aid');
        $type=Db::name("admin")->find($aid);
//        dump($type);
        echo json_encode($type);
    }


}