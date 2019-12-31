<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks:
 */
namespace app\admin\controller;
use app\PublicConfig\Publicconfig;
class Filetxt extends Share
{
    protected  $model;
    protected  $validate;
    protected  $path;
    use Publicconfig;
    public function initialize()
    {
        $this->model = Model('Filetxt');
        $this->validate = Validate('Filetxt');
        $this->path = config('path.');

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

    //文件列表数据
    public function addFiled()
    {
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $post = input('post.');
            if(!empty($post['username']) && !empty($post['api']) && $post['api'] == 'level'){
                $file = $this->path['imgPhp'].$post['username'];
                $data = $this->returnFile($file);
                $code = $data['code'];
                $msg = $data['data'];
            }
        }
        dataJson($code,$msg);
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
            if(isset($post['del'])){
                $yz = $this->validate->scene('del')->check($post);
                if(!$yz){
                    $msg = $this->validate->getError();
                }else{
                    $model = $this->model->Del($post['filetxt_id']);
                    $code = $model['code'];
                    $msg =  $model['msg'];
                }
            }else if(isset($post['DelFile'])){

            }
        }
        dataJson($code,$msg);
    }
}
?>