<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks:
 */
namespace app\common\model;
class Chnumber extends Share
{
    protected $autoWriteTimestamp = true;
    protected $allow = ['username','back','disable','channel_id'];
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
            $msg = '当前渠道号已存在';
        }else{
            if($this->allowField($this->allow)->isUpdate(false)->save($value)){
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
            ['chnumber_id','neq',$value['chnumber_id']],
        ];
        $count = $this->where($where)->count();
        $code = 0;
        $msg = '修改失败';
        if(!empty($count)){
            $msg = '当前渠道号已存在';
        }else{
            if($this->allowField($this->allow)->isUpdate(true)->save($value,['chnumber_id'=>$value['chnumber_id']])){
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
        if($this->where('chnumber_id','=',$id)->delete()){
            $code = 1;
            $msg = '删除成功';
        }else{
            $code = 0;
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
        $sql = $this->alias('a')->field('a.*,b.username as user,b.disable as dis')->join('channel b','b.channel_id = a.channel_id','left')->where($where)->order('chnumber_id desc')->paginate($data['limit'],false,['page'=>$data['page']])->toArray();
        $count = $this->alias('a')->where($where)->count();
        return returnModel($sql['data'],$count,'','');
    }
}
?>