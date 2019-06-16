<?php
namespace app\demo\controller;
use app\demo\controller\Base;
use \think\Controller;
use \think\Db;
use \think\Session;
//define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Cart extends Base
{
    public function index(){
          $a=Session::get('uname');
          $d=Session::get('uid');
//        $rs=Db::table("Cart c,phone p,user u")->where('c.pid=p.pid and c.uid=u.uid')->select();
//        $rs=Db::table("Cart c,good g,phone p,user u")->where('c.gid=g.gid and c.uid=u.uid')->select();
          $rs=Db::table("Cart c,good g,phone p")->where("c.gid=g.gid and g.pid=p.pid and c.uid='$d' ")->select();
//          dump($rs);
//        $rs=Db::table("Cart c,phone p,user u")->where('c.gid=g.gid and c.uid=u.uid and ')->select();
//        $rs=db('Cart')->alias('c')->join("LEFT JOIN good g on c.gid=g.gid")->
//                                  join("LEFT JOIN user u on c.uid=u.uid")->select();
//
        //总价
        $result=Db::query("select sum(oprice) sp from cart as c,good as g WHERE c.gid=g.gid  and c.uid='$d' ");
        //优惠券
        $pro=Db::query("select * from promotion where time<=now() and time2>=now()");
        /*dump($pro);*/
        $address=Db::table("address a,user u")->where("a.uid=u.uid and u.uname like '$a' ")->select();
//        dump($address);
        if($pro){
             if($result[0]["sp"]>=$pro[0]["amount1"]){
                 $this->assign("pro1",$pro[0]["amount1"]);
                 $this->assign("pro2",$pro[0]["amount2"]);
             } else{
                $pro[0]["amount2"]=0;
                 $this->assign("pro1",$pro[0]["amount1"]);
                 $this->assign("pro2",$pro[0]["amount2"]);
             }
             if ($result[0]["sp"]>$pro[0]['amount1']) {
                 $result[0]["sp"]=$result[0]["sp"]-$pro[0]['amount2'];
                 $this->assign("result",$result[0]["sp"]);
             }else{
                 $this->assign("result",$result[0]["sp"]);
             }
        }else{
            $pro[0]["amount2"]=0;
            $pro[0]["amount1"]=0;
            $this->assign("pro1",$pro[0]["amount1"]);
            $this->assign("pro2",$pro[0]["amount2"]);
            $this->assign("result",$result[0]["sp"]);
        }

       /* if($result[0]["sp"]>=$pro[0]["amount1"]){
            $this->assign("pro2",$pro[0]["amount2"]);
        } else{
            $pro[0]["amount2"]=0;
            $this->assign("pro2",$pro[0]["amount2"]);
        }

        if ($result[0]["sp"]>$pro[0]['amount1']) {
            $result[0]["sp"]=$result[0]["sp"]-$pro[0]['amount2'];
            $this->assign("result",$result[0]["sp"]);
        }else{
            $this->assign("result",$result[0]["sp"]);
        }*/


//        $this->assign("result",$result[0]["sp"]);
        $this->assign("pro",$pro);
        $this->assign("rs",$rs);
        $this->assign("address",$address);
        return $this->fetch();
    }


    public function delete($cid){
        if(Db::name("Cart")->delete($cid)){
            $this->success('删除成功','index');
        }
        else {
            $this->error('删除失败','index');
        }
    }

    public function add($cid)
    {
        if(Db::name("cart")->where('cid',$cid)->update(['count'=='count'+'1'])){
            $this->success('数量更新成功','index');
        }else{
            $this->error('数量更新失败','index');
        }
    }

    public function reduce($cid)
    {
        if(Db::name("cart")->where('cid',$cid)->update(['count'=='count'-'1'])){
            $this->success('数量更新成功','index');
        }else{
            $this->error('数量更新失败','index');
        }
    }
    public function add2()
    {
        $b=Session::get('uid');
        $rs=Db::table("Cart c,good g,phone p")->where('c.gid=g.gid and g.pid=p.pid ')->select();
        if (request()->isPost()) {
            for($i=0;$i<=count($rs)-1;$i++){
                $data=[
                    'gid'=>$rs[$i]["gid"],
                    'uid'=>$b,
                    'aid'=>input('address'),
                    'number'=>rand()*10001,
                    'count'=>1,
                ];
                $res = Db::name("order2")->insert($data);
            }
            if ($res) {
                   $res2=Db::name("Cart")->where('uid',$b)->delete();
                   if ($res2){
                        $this->success("支付成功");
                   }else{
                       $this->error("支付失败");
                  }
            } else {
                $this->error("支付失败");
            }
        }
    }

}