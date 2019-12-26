<?php

namespace app\common\model;
use think\Model;
use app\PublicConfig\Publicconfig;
class Share extends Model
{
    use Publicconfig;
//    protected $autoWriteTimestamp = true;
    protected $path;
    public function initialize()
    {
        $this->path = config('path.');  //读取相关配置相信
    }
}

?>