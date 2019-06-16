<?php

namespace app\admin\controller;
use \think\Db;
use \think\Session;
use \think\Cookie;
use \think\Controller;
class Sbase extends Controller
{
    public function _initialize(){
        if(!Session::has('sname')){
            Session::clear();
            $this->redirect('Login/index');
        }
    }
}
