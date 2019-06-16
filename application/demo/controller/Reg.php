<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;
use \think\Session;
use \think\Cookie;
class Reg extends Controller
{
    public function index()
    {
        if (request()->isPost()) {
            $a = input('uname');
            $p = input('upwd');
            $user = Db::name('user')->where('uname', $a)->find();
            if (!$user) {
                $data = [
                    'uname' => $a,
                    'upwd' => md5($p),
                    'uphone' => input('uphone'),
                ];
                $res = Db::name("user")->insert($data);
                if ($res) {
                    $this->success("注册成功");
                    $this->redirect('Login/index');
                } else {
                    $this->error("注册失败");
                }
            }

        }
        return $this->fetch();
    }

}
