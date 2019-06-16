<?php
namespace app\admin\controller;
use \think\Db;

use \think\Controller;
class index extends Base
{
    public function index()
    {


        $result=Db::query("select bname,sum(profit) sp from Order2 as o,good as g,phone p,band b WHERE o.gid=g.gid and 
                           g.pid=p.pid and p.bid=b.bid group BY bname");
        /*dump($result);*/
        $this->assign("result",$result);

        return $this->fetch();

    }
}
