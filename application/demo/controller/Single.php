<?php
namespace app\demo\controller;
use \think\Db;
use \think\Request;
use \think\Controller;
use  \think\Session;
class Single extends Controller
{
    public function index($id)
    {

        if(Session::has("amount")){
            $rs=Db::name("good g,phone p,band b")->where("g.pid=p.pid and b.bid=p.bid and p.pid=$id")->select();
            $this -> view -> assign('amount',Session::get("amount"));
            $this -> view -> assign('phone2',$rs);
            return $this -> view ->fetch();
        }else{
            $rs=Db::name("good g,phone p,band b")->where("g.pid=p.pid and b.bid=p.bid and p.pid=$id")->select();
            $rs2=Db::name("phone p,band b")->where("b.bid=p.bid and p.pid=$id")->select();

            $rs3=Db::name("phone p,band b")->where("b.bid=p.bid and p.pid=$id")->select();
            $rs4=$rs3[0]["bname"];
            $rs5=Db::name("phone p,band b")->where("b.bid=p.bid and b.bname like '$rs4'")->select();

            $rs6=Db::name("comment c,good g,phone p,user u")->where("c.gid=g.gid and g.pid=p.pid and c.uid=u.uid and p.pid=$id")->
                   paginate(5);

            $this -> view -> assign('phone2',$rs);
            $this -> view -> assign('comment',$rs6);
            $this -> view -> assign('phone3',$rs2);
            $this -> view -> assign('phone4',$rs5);
            return $this -> view ->fetch();
        }


//        if(Request::instance()->isPost()) {
////              dump($rs);
//            $data = $request -> post();
//var_dump($data);
//die();
//            $rs1 = $data['rs'];
//             $Ram = Db::table('good')->where(['Ram' => $rs1])-> select();
//
//           //二级联动
//          $opt = '<option>颜色</option>';
//       foreach($Ram as $key=>$val){
//               $opt .= "<option value='{$val['gid']}'>{$val['colour']}</option>";
//         }
//          echo json_encode($opt);
//        }else {
//               $this -> view -> assign('phone2',$rs);
//               return $this -> view ->fetch('index');
//           }


    }

    public  function getdata($id){
        $opt = '<option value="0">颜色</option>';
        $list=Db::name("good")->where("gid",$id)->select();

        foreach($list as $key=>$val){
          $opt .= "<option value='{$val['gid']}'>{$val['colour']}</option>";
         }
        echo json_encode($opt);
    }


    public  function getdata2($gid){
       $type=Db::name("good")->find($gid);
       /* $type=Db::name("good g,phone p")->where("g.pid=p.pid and g.gid='$gid' ");*/
        echo json_encode($type);
    }


    public function add()
    {
        $c=Session::get('uid');
        if($c){
            if (request()->isPost()) {
                $data = [
                    'gid'=>input('gid'),
                    'uid'=>$c,
                    'count'=>1,
                ];
                $res = Db::name("cart")->insert($data);
                if ($res) {
                    $this->success("购物车添加成功");
                } else {
                    $this->error("购物车添加失败");
                }
            }
        }else{
            echo "<script>alert('您未登陆，添加失败！')</script>";
            $this->redirect('Login/index');
        }

    }

    public function add2()
    {
        $c=Session::get('uid');
        $se=Db::name("order2")->where('uid','$c')->find();
        if(!$se){
               $pro=Db::table("user")->where("user.uid='$c'")->select();
               if (1==$pro[0]["status"]){
                   if (request()->isPost()) {
                       $data = [
                           'remark'=>input('remark'),
                           'uid'=>$c,
                           'gid'=>1,
                       ];
                       $res = Db::name("comment")->insert($data);
                       if ($res) {
                           $this->success("评论成功");
                       } else {
                           $this->error("评论失败");
                       }
                   }
               }else{
                   $this->error("对不起，您已被禁言，不能发表评论");
               }
        }else{
            $this->error("您未购买过该商品，添加失败");
        }

    }

}
