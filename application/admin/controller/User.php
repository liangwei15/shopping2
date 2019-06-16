<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class User extends Base
{
    public function index(){
        Session::set('search',4);
        $rs=Db::name("user")->order('uid asc')->select();
        $this->assign("users",$rs);
        return $this->fetch();
    }

    public function update2(){
        $uid=input('uid');
        if(Db::name("user")->where('uid',$uid)->update(['status'=>'0'])){
            $this->success('禁言成功','index');
        }else{
            $this->error('禁言失败','index');
        }
    }

    public function edit(){
        $uid=input('param.uid');
        $user=Db::name("user")->find($uid);
        echo json_encode($user);
    }


}