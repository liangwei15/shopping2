<?php
namespace app\admin\model;
use \think\Session;
use \think\Model;
use \think\Db;

class Login2 extends Model
{
    public function login($a,$p)
    {
        if(request()->isPost()){
            $ca=input('verifycode');
            if(!captcha_check($ca)){
                //验证失败
                echo "<script> alert('验证码错误');</script>";
            }else{
                //判断用户名密码
                //正确，把管理员id和用户名存入session，调转到视频列表页；
                //错误，则分情况提示：用户不存在;密码错误;
                $a=input('name');
                $p=input('pwd');
                $admin=Db::name('admin')->where('aname',$a)->find();
                if($admin){
                    if(md5($p)==$admin['apwd']){
                        //正确，，把管理元id和用户存入session，调转到视频列表页
                        Session::set('login_id',$admin['adminid']);
                        Session::set('login_name',$a);
                        // $this->redirect("video/index");
                        return 3;
                    }else{
                        // echo "<script>alert('用户名密码错误')</script>";
                        return 2;
                    }
                }else{
                    // echo "<script>alert('用户不存在');</script>";
                    return  1;
                }
            }
        }

        return $this->fetch();
    }

}
?>