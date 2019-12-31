<?php
/*
 * 自定义页面 - 控制
 * */
namespace app\admin\controller;
use app\PublicConfig\Publicconfig;
class Html extends Share
{
    use Publicconfig;
    protected $model;
    protected $validate;
    protected $group;
    protected $path;

    public function initialize()
    {
        $this->validate = Validate('Html');
        $this->model = Model('Html');
        $this->group = Model('Group');
        $this->path = config('path.');
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
                        $where[] = ['a.username','like','%'.$get['username'].'%'];
                    }if(!empty($get['back'])){
                        $where[] = ['a.back','like','%'.$get['back'].'%'];
                    }if(!empty($get['group_id'])){
                        $where[] = ['a.group_id','eq',$get['group_id']];
                    }
                    $model = $this->model->Show($get,$where);
                    $data = $model['data'];
                    $count = $model['count'];
                    $page = true;
                }
            } if(isset($get['id']) && is_numeric($get['id'])){
                $sql = $this->field('html')->model->where('html_id','=',$get['id'])->find();
                if(!empty($sql)){
                    $data =  $this->openFile($this->path['fileIndex'].$sql['html'].'.html');
                    $page = true;
                    $success = 'success';
                }
            }
            uiJson($data,$count,$page,$success);
            exit;
        }
        if(request()->isPost()){
            $post = input('post.');
            if(isset($post['id']) && is_numeric($post['id'])){
                $count = [];
                $sql = $this->model->field('html')->where('html_id','=',$post['id'])->find();
                if(!empty($sql)){
                    $data =  $this->openFile($this->path['fileIndex'].$sql['html'].'.html');
                    $page = true;
                    $success = 'success';
                }else{
                    $data =  [];
                    $page = false;
                    $success = 'error';
                }
                uiJson($data,$count,$page,$success);
                exit;
            }
        }
        return view('',[
            'Group' => $this->group->whole(),
        ]);
    }

    public function add()
    {
        $code = 0;
        $msg = 'error';
        if(request()->isPost()){
            $data = input('post.');
            //验证
            $data['Group'] = $this->group;
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
            $data['Group'] = $this->group;
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