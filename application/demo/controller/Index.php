<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;
use think\db\Query;

class Index extends Controller
{
    public function index()
    {
        $rs=Db::name("phone p,band b")->where("b.bid=p.bid")->select();
        $rs2=Db::query( "select gid from (select gid,count(*) as count from order2 group by gid) a order by count desc limit 1");
        $rs22=[];
        array_walk_recursive($rs2, function($value) use (&$rs22) {
            array_push($rs22, $value);
        });
//        dump($rs22);
        $rs3=Db::name("good g,phone p")->where("g.pid=p.pid and g.gid=$rs22[0]")->select();
//        dump($rs3);
        $this->assign("goods",$rs);
        $this->assign("good2",$rs3);
        return $this->fetch();

    }

    public function index2()
    {

    }
}
