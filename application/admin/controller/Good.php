<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
define('UserPhotoPath', APP_PATH.'/../public/static/img/');

class Good extends Base
{
    public function index(){
        Session::set('search',3);
     /*   $re = Session::get('search');*/
//        dump($re);
        $rs=Db::name("good g,phone p")->where("g.pid=p.pid")->paginate(5);
        $this->assign("goods",$rs);
        return $this->fetch();
    }

    public function delete($gid){
        if(Db::name("good")->delete($gid)){
            $this->success('下架成功','index');
        }else{
            $this->fail();
        }
    }

    public function update(){
        $gid=input('id');
        $rs=Db::name("good g,phone p")->where("g.pid=p.pid")->find($gid);
        $this->assign("il",$rs);
        $rs2=Db::name("phone")->select();
        $this->assign("phones",$rs2);
        return $this->fetch();
    }

    public function doUpdate(){
        $gid=input('gid');
        $data=[
            'Ram'=>input('Ram'),
            'colour'=>input('colour'),
            'Iprice'=>input('Iprice'),
            'Oprice'=>input('Oprice'),
            'profit'=>input('Iprice')-input('Iprice'),
            'time'=>date('Y-m-d H:i:s'),
            'amount'=>input('amount'),
            'pid'=>input('pid3'),
        ];
        if(Db::name("good")->where('gid',$gid)->update($data)){
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
    }

    public function  add(){
        $rs=Db::name("phone")->select();
        $this->assign("goods",$rs);
        return $this->fetch();
    }



    public function add2()
    {
        if (request()->isPost()) {
            $data = [
                'Ram'=>input('Ram'),
                'colour'=>input('colour'),
                'Iprice'=>input('Iprice'),
                'Oprice'=>input('Oprice'),
                'profit'=>input('Iprice')-input('Iprice'),
                'time'=>date('Y-m-d H:i:s'),
                'amount'=>input('amount'),
                'pid'=>input('pid2'),
            ];
            $res = Db::name("good")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }

    }