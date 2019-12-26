<?php
/*
 * 公共验证
 * */
namespace app\common\validate;
use think\Validate;

class Share extends Validate
{

    //验证上传文件是否存在
    protected function ImgYz($value, $rul, $data = []){
        if(empty(file_exists($value))){
            return $rul;
        }
        return true;
    }
}

?>