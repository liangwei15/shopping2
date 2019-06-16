<?php
namespace app\admin\controller;
use \think\Db;
use \think\Session;
use \think\Controller;
class Comment extends Base
{
    public function index(){
        $cid=input('param.id');
        if($cid){
            $comment=Db::name("comment c,user u, good g,phone p")->where("c.uid=u.uid and c.gid=g.gid and g.pid=p.pid and p.pid='$cid'")->paginate(5);
            $this->assign("rs",$comment);
            return $this->fetch();
        }else{
            $comment=Db::name("comment c,user u, good g,phone p")->where("c.uid=u.uid and c.gid=g.gid and g.pid=p.pid")->paginate(5);
            $this->assign("rs",$comment);
            return $this->fetch();
        }
    }

    public function edit(){
        $cid=input('param.cid');
        $type=Db::name("comment c,user u,good g,phone p")->
                   where("c.uid=u.uid and c.gid=g.gid and g.pid=p.pid and c.cid='$cid' ")->find($cid);
        /* dump($type);*/
        echo json_encode($type);
    }




    public  function getdata($cid){
        $type=Db::name("comment c,user u,reply r,good g,phone p")->
                   where("c.uid=u.uid and c.gid=g.gid and g.pid=p.pid and r.cid=c.cid and c.cid='$cid'  ")->find();
        echo json_encode($type);
    }


    public function add()
    {
        $b=Session::get('aid');
        if (request()->isPost()) {
            $data = [
                'cid'=>input('cid'),
                'content' => input('content'),
                'sid'=> $b,
                 ];
            $res = Db::name("reply")->insert($data);
            if ($res) {
                $this->success("回复成功");
            } else {
                $this->error("回复失败");
            }
        }
    }

}