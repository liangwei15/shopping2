<?php
namespace app\admin\validate;

use think\Validate;

class index extends Validate
{
    protected $rule = [
        'aname'  =>  'require|max:8',
    ];

}
?>
