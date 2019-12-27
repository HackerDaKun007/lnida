<?php
namespace app\admin\controller;
use app\PublicConfig\Publicconfig;
class Admin extends Share
{
    use Publicconfig;
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
        if(request()->isPost()){
            $post = input('post.');
            //上传图片
            if(!empty($post['api']) && $post['api'] == 200){
                $imgData = '';
                $msg = 'error';
                $code = 0;
                $img = $this->imgApi();
                if($img['code'] == 1){
                    $imgData = $img['data'];
                    $code = $img['code'];
                    $msg = 'success';
                }else{
                    $msg = $img['data'];
                }
                dataJson($code,$msg,$imgData);
                exit;
            }

        }
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
                        $where[] = ['username','eq',$get['username']];
                    }if(!empty($get['contact'])){
                        $where[] = ['contact','like','%'.$get['contact'].'%'];
                    }if(!empty($get['disable'])){
                        $where[] = ['disable','eq',$get['disable']];
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
                $mi = password($data['password']);
                $data['password'] = $mi['data'];
                $data['encryption'] = $mi['random'];
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
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $data = input('post.');
            //验证
             if(empty($data['password']) && empty($data['repassword']) && empty($data['img'])){
                $yz = $this->validate->scene('edit_pass_img')->check($data);
                $data = unsetData($data,['password','repassword','img']);
            }else if(empty($data['password']) && empty($data['repassword'])){
                $yz = $this->validate->scene('edit_pass')->check($data);
                $data = unsetData($data,['password','repassword']);
            }else if(empty($data['img'])){
                 $yz = $this->validate->scene('edit_img')->check($data);
                 $data = unsetData($data,['img']);
             }else{
                 $yz = $this->validate->scene('edit')->check($data);
             }

            if(!$yz){
                $msg = $this->validate->getError();
            }else{
                if(isset($data['password'])){
                    $mi = password($data['password']);
                    $data['password'] = $mi['data'];
                    $data['encryption'] = $mi['random'];
                }
                $model = $this->model->edit($data);
                $msg = $model['msg'];
                $code = $model['code'];
            }
        }
        dataJson($code,$msg);
    }

    //删除
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
                $model = $this->model->Del($post['admin_id']);
                $code = $model['code'];
                $msg =  $model['msg'];
            }
        }
        dataJson($code,$msg);
    }
}

?>