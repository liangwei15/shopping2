<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
//define('UserPhotoPath', APP_PATH.'/../public/static/posters/');

class Order extends Base
{
    public function index(){
        $or=Db::name(" `order2` o,good g,address a,user u,phone p")->
                where(" o.gid=g.gid and o.aid=a.aid and u.uid=a.uid and p.pid=g.pid")->paginate(6);
        $this->assign("order",$or);
        return $this->fetch();
    }
    //发货状态更新1
     public function update(){
         $oid=input('id');
         if(Db::name("order2")->where('oid',$oid)->update(['state'=>'1'])){
                $this->success('状态已更新','index');
            }else{
                $this->error('状态更新失败','index');
           }
      }
    //发货状态更新2
    public function refund(){
        $oid=input('id');
        if(Db::name("order2")->where('oid',$oid)->update(['state'=>'1'])){
            $this->success('状态已更新','index');
        }else{
            $this->error('状态更新失败','index');
        }
    }


    public function delete($oid){

        if(Db::name("Order2")->delete($oid)){
            $this->success('删除成功','index');
        }
        else {
            $this->error('删除失败','index');
        }
    }


    public function download($oid){
        $rs=Db::name("order2 o,good g,user u,address a,phone p")->
                   where("o.gid=g.gid and o.aid=a.aid and u.uid=a.uid and p.pid=g.pid and o.oid='$oid' ")->find();
        $currdir="static/resources_file/".$rs['resources_file'];
        // var_dump($currdir);
        if (! file_exists($currdir) )
        {
            $this->error('文件未找到');
        }
        else
        {
            // 打开文件
            $file1 = fopen($currdir, "r");
            // 输入文件标签
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length:".filesize($currdir));
            Header("Content-Disposition: attachment;filename=" . $currdir);
            ob_clean();     // 重点！！！
            flush();        // 重点！！！！可以清除文件中多余的路径名以及解决乱码的问题：
            //输出文件内容
            //读取文件内容并直接输出到浏览器
            echo fread($file1, filesize($currdir));
            fclose($file1);
            exit();
        }
    }

    public function word(){
        vendor("PHPWord");
        require_once 'PhpOffice/PhpWord/PhpWord.php'; // 包含头文件

        require_once __DIR__ . '/PhpOffice/PhpWord/Autoloader.php';
        Autoloader::register();
        Settings::loadConfig();

        $PHPWord = new \PhpWord();
       /* $PHPWordHelper= new \PhpOffice\PhpWord\Shared\Font();*/

        $PHPWord->setDefaultFontName('仿宋'); // 全局字体
        $PHPWord->setDefaultFontSize(16);     // 全局字号为3号

        // 设置文档的属性，这些在对文档右击属性可以看到，也可以省去这些步骤
        $properties = $PHPWord->getDocumentProperties();
        $properties->setCreator('张三');   // 创建者
        $properties->setCompany('某公司'); // 公司
        $properties->setTitle('某某文档'); // 标题
        $properties->setDescription('http://wangye.org'); // 描述
        $properties->setLastModifiedBy('李四'); // 最后修改
        $properties->setCreated( time() );      // 创建时间
        $properties->setModified( time() );     // 修改时间

// 添加3号仿宋字体到'FangSong16pt'留着下面使用
        $PHPWord->addFontStyle('FangSong16pt', array('name'=>'仿宋', 'size'=>16));

// /*添加段落样式到'Normal'以备下面使用
     /*   $PHPWord->addParagraphStyle(
            'Normal',array(
                'align'=>'both',
                'spaceBefore' => 0,
                'spaceAfter' => 0,
             /*   'spacing'=>$PHPWordHelper->pointSizeToTwips(2.8),*/


// Section样式：上3.5厘米、下3.8厘米、左3厘米、右3厘米，页脚3厘米
// 注意这里厘米(centimeter)要转换为twips单位


// 下面这句是输入文档内容，注意这里用到了刚才我们添加的
// 字体样式FangSong16pt和段落样式Normal
      /*  $section->addText('文档内容', 'FangSong16pt', 'Normal');
        $section->addTextBreak(1); // 新起一个空白段落*/

        $objWriter = IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save(ROOT_PATH.'public'.DS.'static'.DS.'word'.DS.'demo1.docx');

    }
}