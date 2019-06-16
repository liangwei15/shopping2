<?php
namespace app\demo\controller;
use \think\Db;
use \think\Controller;

class Promotion extends Controller
{
    public function index()
    {

        $rs2 = Db::name("promotion ")->select();
        setInterval(on, 1000);

        $date = new Date;
        dump(date);
        $data=array();
        $k=0;
        for ($i = 0; $i <= count($rs2); $i++){
        if ($date.getTime() >= $rs2.[i].time() && $date . getTime() <= $rs2.[i].time2()) {
            $data1=[
                'pid'=>$rs2.[i].pid,
                'pame'=>$rs2[i].pname,
                'amount1'=>$rs2[i].amount1,
                'amount2'=>$rs2[i].amount2,
            ];
            $data[$k]=$data1;
            $k++;
          }
        }
        $this->assign("data",$data);
        $this->fetch();
}


}
