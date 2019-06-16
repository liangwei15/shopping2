<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;
class Best extends Controller
{
    public function index()
    {
        $rs=Db::name("phone p,band b")->where("b.bid=p.bid")->paginate(9);;
        $this->assign("phone",$rs);
        return $this->fetch();
    }

    public function search()
    {
        $key = input('param.key');
        $list = Db::name("Phone p,band b")->where("b.bid=p.bid and pname like '%$key%'")->select();
      /*  dump($list);*/
        $this->assign("list", $list);
        return $this->fetch();
    }

}
