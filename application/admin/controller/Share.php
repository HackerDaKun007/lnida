<?php
namespace app\admin\controller;
use think\Controller;
class Share extends COntroller
{
    /*
     * 公共影响操作方法
     * */
    public function __construct()
    {
        parent::__construct();
        $controller = request()->controller();//获取控制名称
        if($controller != 'Login'){

        }
    }
}
?>
