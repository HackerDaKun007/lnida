<?php
namespace app\common\model;
class Html extends Share
{
    protected $autoWriteTimestamp = true;
    protected $allow = ['username','back','html','group_id'];

    /*
     * 添加
     * @param array $value 传入提交post数组
     * return array 返回状态码(code)、提示语(msg)
     * */
    public function Add($value)
    {
        $code = 0;
        $msg = '添加失败';
        //判断用户名称是否存在
        $find = $this->where('username','=',$value['username'])->count();
        if(!empty($find)){
            $msg = '当前页面名称已经存在';
        }else{
            $this->startTrans();
            try {
                if($this->isUpdate(false)->allowField($this->allow)->save($value)) {
                    if($this->FileCount($this->path['fileIndex'],$value['html'].'.html',$_POST['count'])){
                        $this->commit();
                        $code = 1;
                        $msg = '添加成功';
                    }else{
                        $msg = '添加失败,没权限写入文件！';
                    }
                }
            }catch(Exception $e){
                $this->rollback();
            }
        }
        return returnModel([],0,$msg,$code);
    }

    /*
     * 修改
     * @param array $value 传入提交post数组
     * return array 返回状态码(code)、提示语(msg)
     * */
    public function Edit($value)
    {

        $code = 0;
        $msg = '修改失败';
        //判断用户名称是否存在
        $where[] = [
            ['username','eq',$value['username']],
            ['html_id','neq',$value['html_id']],
        ];
        $find = $this->field('username,html')->where('html_id','eq',$value['html_id'])->find()->toArray();
        $count = $this->where($where)->count();
        if(!empty($count)){
            $msg = '当前页面名称已经存在';
        }else{
            $this->startTrans();
            try {
                if($this->isUpdate(true)->allowField($this->allow)->save($value,['html_id'=>$value['html_id']])) {
                    if($this->FileCount($this->path['fileIndex'],$find['html'].'.html',$_POST['count'])){
                        $this->commit();
                        $code = 1;
                        $msg = '修改成功';
                    }else{
                        $msg = '修改失败,没权限写入文件！';
                    }
                    $code = 1;
                    $msg = '修改成功';
                }
            }catch(Exception $e){
                $this->rollback();
            }
        }
        return returnModel([],0,$msg,$code);
    }

    /*
     * 删除
     * @param $id int 传入用户ID
     * return 返回是否删除成功状态码
     * */
    public function Del($id)
    {
        //搜索用户
        $find = $this->field('html')->where('html_id','=',$id)->find()->toArray();
        $code = 0;
        $msg = '删除失败';
        if(!empty($find)){
            $this->startTrans();
            try{
                if($this->where('html_id','=',$id)->delete()){
                    //删除文件
                    $this->FileDel($this->path['fileIndex'].$find['html'].'.html');
                    $this->commit();
                    $msg = '删除成功';
                    $code = 1;
                }
            }catch (Exception $e){
                $this->rollback();
            }
        }
        return returnModel([],0,$msg,$code);
    }

    /*
     * 返回管理员账号展示数据
     * @val array 传入分页数据limit,page
     * $where array 传入相关的搜索数据
     * */
    public function Show($val,$where=[])
    {
        $sql = $this->where($where)->field('a.*,b.username as user')->alias('a')->join('group b','b.group_id = a.group_id','LEFT')->order('a.html_id desc')->paginate($val['limit'],false,['page'=>$val['page']])->toArray();
        $count = $this->alias('a')->where($where)->count();
        return returnModel($sql['data'],$count,'seccess',200);
    }

}

?>