<?php
namespace app\admin\controller;
use think\Validate;

class Admin extends Share
{
    protected $model;
    protected $validate;

    public function initialize()
    {
        $this->validate = Validate('Admin');
        $this->model = Model('Admin');
    }
    //展示
    public function index()
    {
        if(request()->isGet()){
            $get = input('get.');
            $yz = Validate('Comm');
            $str = $yz->scene('page')->check($get);
            $data = [];
            $count = 0;
            $page = true;
            $success = 'success';
            if(!empty($str)){
                $model = $this->model->Show($get);
                $data = $model['data'];
                $count = $model['count'];
            }else{
                $page = false;
                $success = 'error';
            }
            uiJson($data,$count,$page,$success);
            exit;
        }
        return view();
    }

    //添加
    public function add()
    {
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $data = input('post.');
            //验证
            $yz = $this->validate->scene('add')->check($data);
            if(!$yz){
                $msg = $this->validate->getError();
            }else{
                $model = $this->model->add($data);
                $msg = $model['msg'];
                $code = $model['code'];
            }
        }
        dataJson($code,$msg);
    }
    //修改
    public function edit()
    {

    }

    //删除
    public function del()
    {

    }
}

?>