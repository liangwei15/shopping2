<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
//define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Brand extends Base
{
    public function index(){
        Session::set('search',1);
        $rs=Db::name("band")->order(' bid')->paginate(5);
        $this->assign("bands",$rs);
        return $this->fetch();
    }

    public function delete($id){
        $users=Db::name("band")->find($id);
        $logo=$users["logo"];
        $file=ROOT_PATH."public".DS."static".DS."img".DS.$logo;
        if(file_exists($file))
            unlink($file);
        if(Db::name("band")->delete($id)){
            $this->success('删除成功','index');
        }
        else {
            $this->error('删除失败','index');
        }
    }

    public function update(){
        $file=request()->file('logo');
        $pic="";
        if($file){
            $info=$file->rule('uniqid')->move(ROOT_PATH.'public'.DS.'static'.DS.'img');
            if($info){
                $pic=$info->getFilename();
            }
        }
        $bid=input('bid');
        $data=[
            'bname'=>input('bname'),
            'logo'=>$pic,
            'bcompany'=>input('bcompany'),
        ];
        if(Db::name("band")->where('bid',$bid)->update($data)){
            $this->success('修改成功','index');
        }
        else{
            $this->error('修改失败','index');
        }
    }

    public function edit(){
        $bid=input('param.bid');
        $type=Db::name("band")->find($bid);
        echo json_encode($type);
    }

    public function add()
    {
        $file = request()->file('logo');
        $info = "";
        if ($file) {
            $info = $file->rule('uniqid')->validate(['size' => 3000000, 'exit' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'img');
        }
        if (request()->isPost()) {
            $data = [
                'bname'=>input('bname'),
                'logo' => $info->getFilename(),
                'bcompany' => input('bcompany'),];
            $res = Db::name("band")->insert($data);
            if ($res) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败");
            }
        }
    }

    public function  search()
    {
        $key = input('param.key');
        $re = Session::get('search');
        if ($re == 1) {
            $list = Db::name("Band")->where("bname like '%$key%'or bcompany like '%$key%'")->select();
            $this->assign("list", $list);
            return $this->fetch();
        } else {
            if ($re == 2) {
                $list = Db::name("phone")->join('band b','phone.bid=b.bid')->where("pname like '%$key%'")->select();
                $this->assign("list", $list);
                return $this->fetch();
            } else {
                if ($re == 4) {
                    $list = Db::name("user")->where("uname like '%$key%'")->select();
                    $this->assign("list", $list);
                    return $this->fetch();
                } else {
                    if ($re == 5) {
                        $list = Db::name("comment")->join('user u,good g', 'u.uid=comment.uid and g.gid=comment.gid')->
                               where("remark like '%$key%'")->select();
                        $this->assign("list", $list);
                        return $this->fetch();
                    } else {
                        if ($re == 3) {
                            $list = Db::name("Good")->join('phone p', 'p.pid=Good.pid ')->
                                  where("pname like '%$key%' ")->select();
                            $this->assign("list", $list);
                            return $this->fetch();
                        }
                    }
                }
            }
        }
    }






}