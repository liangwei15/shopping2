<?php
namespace app\admin\controller;
use \think\Session;
use \think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!Session::has('aname')){
            Session::clear();
            $this->redirect('Login/index');
        }
    }
}
