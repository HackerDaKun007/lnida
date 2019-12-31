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
        $action = request()->action();//获取控制名称
        $actionTable = $controller.'/'.$action;
        //针对loging
        if($controller != 'Login'){
            if($actionTable != 'Index/index'){

            }
        }else{

        }

    }

    /*
     * 验证展示数据，并输出
     * @param array 验证数据
     * @param array 条件查询
     * */
    protected function yzShow($get,$where=[])
    {
        $data = [];
        $count = 0;
        $page = false;
        $success = 'error';
        if(!empty($get['api']) && $get['api'] = 200){
            $yz = Validate('Comm');
            $str = $yz->scene('page')->check($get);
            if(!empty($str)){
                $model = $this->model->Show($get,$where);
                $data = $model['data'];
                $count = $model['count'];
                $page = true;
            }
        }
        uiJson($data,$count,$page,$success);
    }
}
?>
