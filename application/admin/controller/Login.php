<?php
namespace app\admin\controller;
use app\admin\model\Login2;
use \think\Db;
use \think\Session;
use \think\Cookie;
//use \think\admin\Model\Login2;
use \think\Controller;
class Login extends Controller
{
    public function index(){
       $yid=input('yid');
       if('1'==$yid){
         /*  dump($yid);*/
           if(request()->isPost()){
               $ca=input('verifycode');
               if(!captcha_check($ca)){
                   //验证失败
                   echo "<script> alert('验证码错误');</script>";
               }else{
                   //判断用户名密码
                   //正确，把管理员id和用户名存入session，调转到视频列表页；
                   //错误，则分情况提示：用户不存在;密码错误;
                   $a=input('aname');
                   $p=input('apwd');
                   $admin=Db::name('admin')->where('aname',$a)->find();
                   if($admin){
                       if($admin['apwd']==($p)){
                           //正确，，把管理元id和用户存入session，调转到商品页
                           Session::set('aid',$admin['aid']);
                           Session::set('aname',$a);
                           Cookie::set('aname',$a,6000);
//                           $this->redirect("Index/index");
                           echo "<script>alert('登陆成功')</script>";
                        /*   $this->success(url('Index/index'));*/
                           $this->success('正在跳转','Index/index');
                           echo think.Cookice.aname;
                       }else{
                           echo "<script>alert('用户名密码错误')</script>";
                       }
                   }else{
                       echo "<script>alert('用户不存在');</script>";
                   }
               }
           }
       }else{
           if(request()->isPost()){
               $ca=input('verifycode');
               if(!captcha_check($ca)){
                   //验证失败
                   echo "<script> alert('验证码错误');</script>";
               }else{
                   $a=input('aname');
                   $p=input('apwd');
                   $shopadmin=Db::name('shopadmin')->where('sname',$a)->find();
                   /*dump($shopadmin);*/
                   if($shopadmin){
                       if(($p)==$shopadmin['spwd']){
                           //正确，，把管理元id和用户存入session，调转到商品页
                           Session::set('sid',$shopadmin['sid']);
                           Session::set('sname',$a);
                           Cookie::set('sname',$a,6000);
//                           $this->redirect("Index/index");
                           $this->success('超级管理员登陆成功','Shopadmin/index');
                           echo think.Cookice.aname;
                       }else{
                           echo "<script>alert('密码错误')</script>";
                       }
                   }else{
                       echo "<script>alert('用户不存在');</script>";
                   }
               }
           }
       }
        return $this->fetch();
    }


    public function show_captcha(){
        $captcha = new \think\captcha\Captcha();
        ob_clean();
        $captcha->fontSize =14;
        $captcha->length   = 4;
        $captcha->useNoise = false;
        return $captcha->entry();
    }

    public function logout(){
        Session::clear();
        $this->redirect('index/index');
    }


}
