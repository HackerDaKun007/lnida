<?php
/*
 * 管理员账号model模块
 * */
namespace app\common\model;
class Admin extends Share
{
    protected $autoWriteTimestamp = true;
    protected $allow = ['username','password','encryption','disable','img','listed_id','contact'];
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
        if(empty($find)){
            $msg = '当前用户已经存在';
        }else{
            $this->startTrans();
            try{
                if($this->isUpdate(false)->allowEmpty($this->allow)->save($value)){
                    //移动文件
                    if($this->moving($this->path['runtimeImg'].$value['img'],$this->path['imgPhp'].$value['img'])){
                        $this->commit();
                        $code = 1;
                        $msg = '添加成功';
                    }else{
                        $msg = '当前头像移动失败';
                    }

                }
            }catch(Exception $c){
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
        $where = [
            ['username','eq',$value['username']],
            ['admin_id','neq',$value['admin_id']],
        ];
        $find = $this->where($where)->field('img')->find();
        if(empty($find)){
            $msg = '当前用户已经存在';
        }else{
            $this->startTrans();
            try{
                if($this->isUpdate(true)->allowEmpty($this->allow)->save($value,['admin_id'=>$value['admin_id']])){
                    if(!empty($value['img'])){
                        //移动文件
                        if($this->moving($this->path['runtimeImg'].$value['img'],$this->path['imgPhp'].$value['img'])){
                            //删除图片
                            if(!empty($find['img'])){
                                $this->FileDel($this->path['imgPhp'].$find['img']);
                            }
                            $this->commit();
                            $code = 1;
                            $msg = '修改成功';
                        }else{
                            $msg = '当前头像移动失败';
                        }
                    }
                }
            }catch(Exception $c){
                $this->rollback();
            }
        }
        return returnModel([],0,$msg,$code);
    }

    /*
     * 删除用户
     * @param $id int 传入用户ID
     * return 返回是否删除成功状态码
     * */
    public function Del($id)
    {
        //搜索用户
        $find = $this->field('id,img')->find($id)->toArray();
        $code = 0;
        $msg = '删除失败';
        if(!empty($find)){
            $this->startTrans();
            try{
                if($this->where('id','=',$id)->delete()){
                    //删除文件
                    if(!empty($find['img'])){
                        if(!$this->FileDel($this->path['imgPhp'].$find['img'])){
                            return returnModel([],0,'删除没权限删除图片',$code);
                        }
                    }
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
        $sql = $this->where($where)->order('admin_id desc')->paginate($val['limit'],false,['page'=>$val['page']])->toArray();
        $count = $this->where($where)->count();
        return returnModel($sql['data'],$count,'seccess',200);
    }
}

?>