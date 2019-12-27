<?php
/*
 * 自定义页面 - 控制
 * */
namespace app\admin\controller;
class Html extends Share
{
    protected $model;
    protected $validate;

    public function initialize()
    {
        $this->validate = Validate('Html');
        $this->model = Model('Html');
    }
    public function index()
    {
        if(request()->isGet()){
            $get = input('get.');
            $data = [];
            $count = 0;
            $page = false;
            $success = 'error';
            if(!empty($get['api']) && $get['api'] = 200){
                $yz = Validate('Comm');
                $str = $yz->scene('page')->check($get);
                if(!empty($str)){
                    $where = [];
                    if(!empty($get['username'])){
                        $where[] = ['username','like','%'.$get['username'].'%'];
                    }if(!empty($get['back'])){
                        $where[] = ['back','like','%'.$get['back'].'%'];
                    }
                    $model = $this->model->Show($get,$where);
                    $data = $model['data'];
                    $count = $model['count'];
                    $page = true;
                }
            }
            uiJson($data,$count,$page,$success);
            exit;
        }
        return view();
    }

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
                $data['html'] = suizm(32);
                $model = $this->model->add($data);
                $msg = $model['msg'];
                $code = $model['code'];
            }
        }
        dataJson($code,$msg);
    }

    public function edit()
    {
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $data = input('post.');
            //验证
            $yz = $this->validate->scene('edit')->check($data);
            if(!$yz){
                $msg = $this->validate->getError();
            }else{
                $model = $this->model->Edit($data);
                $msg = $model['msg'];
                $code = $model['code'];
            }
        }
        dataJson($code,$msg);
    }

    public function del()
    {
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $post = input('post.');
            $yz = $this->validate->scene('del')->check($post);
            if(!$yz){
                $msg = $this->validate->getError();
            }else{
                $model = $this->model->Del($post['html_id']);
                $code = $model['code'];
                $msg =  $model['msg'];
            }
        }
        dataJson($code,$msg);
    }
}

?>