<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;
use \think\Session;
use \think\Cookie;
class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
                $a=input('uname');
                $p=input('upwd');
                $user=Db::name('user')->where('uname',$a)->find();
                if($user){
                    if($user['upwd']==($p)){
                        //正确，，把管理元id和用户存入session，调转到商品页
                        Session::set('uid',$user['uid']);
                        Session::set('uname',$a);
                         Cookie::set('uname',$a,6000);
                        $this->redirect("Index/index");
                  //      echo think.Cookice.aname;
                    }else{
                        echo "<script>alert('用户名密码错误')</script>";
                    }
                }else{
                    echo "<script>alert('用户不存在');</script>";
                }
            }
        return $this->fetch();

    }

    public function logout(){
        Session::clear();
        $this->redirect('index/index');
    }
}
