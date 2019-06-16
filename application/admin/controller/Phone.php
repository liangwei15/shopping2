<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
define('UserPhotoPath', APP_PATH.'/../public/static/img/');

class Phone extends Base
{
    public function index(){
        Session::set('search',2);
        $id=input('param.id');
        if($id){
            $rs=Db::name("phone p,band b")->where("p.bid=b.bid and b.bid='$id'")->paginate(5);
            $this->assign("phones",$rs);
            return $this->fetch();
        }else{
            $rs=Db::name("phone p,band b")->where("p.bid=b.bid")->paginate(5);
            $this->assign("phones",$rs);
            return $this->fetch();
        }

    }

    public function delete($id){
        $users=Db::name("phone")->find($id);
        $plogo=$users["plogo"];
        $file=ROOT_PATH."public".DS."static".DS."img".DS.$plogo;
        if(file_exists($file))
            unlink($file);
        if(Db::name("phone")->delete($id))
            $this->success();
        else $this->fail();
    }

    public function updates(){
        $file=request()->file('plogo');
        $pic="";
        if($file){
            $info=$file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'static'.DS.'img');
            if($info){
                $pic=$info->getFilename();
            }
        }
        $pid=input('pid');
        //var_dump(input('Operating'));

        $data=[
            'pname'=>input('pname'),
            'plogo'=>$pic,
            'Resolution'=>input('Resolution'),
            'Rrocessor'=>input('Rrocessor'),
            'Network'=>input('Network'),
            'size'=>input('size'),
            'battery'=>input('battery'),
            'Operating'=>input('Operating'),
            'bid'=>input('bid'),
        ];
       /* var_dump($data);*/
        //var_dump(input('bid'));input('Operating')
        $lsit=Db::name("phone")->where('pid',$pid)->update($data);
        var_dump(123);
       // exit();
        if($lsit){
            $this->success('修改成功','index');
        }
        else{
            $this->error('修改失败','index');
        }
    }

    public function edit(){
        $pid=input('param.pid');
        $type=Db::name("phone")->find($pid);
//        dump($type);
        echo json_encode($type);

//        $this->assign("phone4",$type);
//        dump(phone4);
    }

    public function edit2(){
        $pid=input('param.pid');
        $type=Db::name("phone")->find($pid);
        echo json_encode($type);
    }


    public function comment($id){
        $comment=Db::name("comment c,user u,good g, phone p")->
                where("c.uid=u.uid and c.gid=g.gid and g.pid=p.pid and c.cid='$id'")
                  ->select();
        $this->assign("rs", $comment);
        return $this->fetch();
    }

    public function add()
    {
        $file = request()->file('plogo');
        $pic= "";
        if ($file) {
            $info=$file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'static'.DS.'img');
            if($info){
                $pic=$info->getFilename();
            }
        }
        if (request()->isPost()) {
            $data = [
                'pname'=>input('pname'),
                'plogo'=>$pic,
                'Resolution'=>input('Resolution'),
                'Rrocessor'=>input('Rrocessor'),
                'Network'=>input('Network'),
                'size'=>input('size'),
                'battery'=>input('battery'),
//                'Operating	'=>input('Operating'),
                 'bid'=>input('bid'),
                ];
            $res = Db::name("phone")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }


}