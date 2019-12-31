<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks: 自定义页面分组 - model模块
 */
namespace app\common\model;
class Group extends Share
{
    protected $autoWriteTimestamp = true;
    protected $allow = ['username','back'];
    /*
     * 添加数据
     * @param array $value 添加数据数组
     * return 返回0-1的状态码，提示是否成功语句
     * */
    public function Add($value)
    {
        //判断是否存在名称
        $count = $this->where('username','=',$value['username'])->count();
        $code = 0;
        $msg = '添加失败';
        if(!empty($count)){
            $msg = '当前分组名称已存在';
        }else{
            if($this->allowField($this->allow)->isUpdate(false)->save($value)){
                $this->whole(true);
                $code = 1;
                $msg = '添加成功';
            }
        }
        return returnModel('','',$msg,$code);
    }

    /*
    * 修改数据
    * @param array $value 添加数据数组
    * return 返回0-1的状态码，提示是否成功语句
    * */
    public function Edit($value)
    {
        //判断是否存在名称
        $where = [
            ['username','eq',$value['username']],
            ['group_id','neq',$value['group_id']],
        ];
        $count = $this->where($where)->count();
        $code = 0;
        $msg = '修改失败';
        if(!empty($count)){
            $msg = '当前分组名称已存在';
        }else{
            if($this->allowField($this->allow)->isUpdate(true)->save($value,['group_id'=>$value['group_id']])){
                $this->whole(true);
                $code = 1;
                $msg = '修改成功';
            }
        }
        return returnModel('','',$msg,$code);
    }

    /*
     * 删除
     * @param int $id 删除的id
     * return 返回0-1的状态码，提示是否成功语句
     * */
    public function Del($id)
    {
        if($this->where('group_id','=',$id)->delete()){
            $code = 1;
            $msg = '删除成功';
            $this->whole(true);
        }else{
            $code = 1;
            $msg = '删除失败';
        }
        return returnModel('','',$msg,$code);
    }

    /*
     * 返回分组数据
     * @param array $data 分页数组参数
     * @param array $where 传入相关数据条件
     * return 返回查询分组数据
     * */
    public function Show($data,$where=[])
    {
        $sql = $this->where($where)->order('group_id desc')->paginate($data['limit'],false,['page'=>$data['page']])->toArray();
        $count = $this->where($where)->count();
        return returnModel($sql['data'],$count,'','');
    }

    /*
     * 查询全部分组数据
     * @access public
     * @param bool $bool 是否更新缓存
     * @return array 缓存信息
     * */
    public function whole($bool=false)
    {
        $group = cache($this->path['groupWhole']);
        if(empty($group) || $bool == true){
            $sql = $this->field('group_id,username')->order('group_id desc')->select()->toArray();
            cache($this->path['groupWhole'],$sql);
        }else{
            $sql = $group;
        }
        return $sql;
    }

    /*
     * 验证id是否存在
     * @param int ID值
     * @return array  返回code(0-1)值，msg提示语
     * */
    public function yzFiled($id)
    {
        $sql = $this->where('group_id','=',$id)->count();
        $code = 0;
        $msg = '分组id不存在'.$id;
        if(!empty($sql)){
            if($sql['disable'] == 2){
                $msg = '当前分组id已禁用';
            }else{
                $msg = 'success';
                $code = 1;
            }
        }
        return returnModel('','',$msg,$code);
    }
}
?>