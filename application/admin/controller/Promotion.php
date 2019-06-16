<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
//define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Promotion extends Base
{
    public function index(){
        $rs=Db::name("promotion")->order(' pid')->paginate(5);
        $this->assign("pro",$rs);
        return $this->fetch();
    }

    public function delete($id){
        if(Db::name("promotion")->delete($id)){
            $this->success('删除成功','index');
        }
        else {
            $this->error('删除失败','index');
        }
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = [
                'pname'=>input('pname'),
                'amount1'=>input('amount1'),
                'amount2'=>input('amount2'),
                'time'=>date('Y-m-d H:i:s'),
                'time2'=>date('Y-m-d H:i:s'),
               ];
            $res = Db::name("promotion")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }
}