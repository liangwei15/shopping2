<?php
/**
 * Created by PhpStorm.
 * User: liang
 * Date: 2019/5/13
 * Time: 17:17
 */
namespace app\demo\controller;
use \think\Db;
use \think\Session;
use \think\Cookie;
use \think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!Session::has('uname')){
            $this->redirect('Login/index');
        }
    }
}
