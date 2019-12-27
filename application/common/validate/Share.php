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
        $path = config('path.');
        if(empty($path['runtimeImg'].file_exists($value))){
            return $value;
        }
        return true;
    }
}

?>