<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks:
 */
namespace app\admin\controller;
class Channel extends Share
{
    protected  $model;
    protected  $validate;

    public function initialize()
    {
        $this->model = Model('Channel');
        $this->validate = Validate('Channel');

    }

    public function index()
    {
        //展示数据
        if(request()->isGet()){
            $get = input('get.');
            $where = [];
            if(!empty($get['username'])){
                $where[] = ['username','like','%'.$get['username'].'%'];
            }
            $this->yzShow($get,$where);
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
                $model = $this->model->Add($data);
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
                $model = $this->model->Del($post['channel_id']);
                $code = $model['code'];
                $msg =  $model['msg'];
            }
        }
        dataJson($code,$msg);
    }
}
?>