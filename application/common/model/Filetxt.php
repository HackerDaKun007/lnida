<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks:自定义上传文件 - model
 */
namespace app\common\model;
use think\Exception;

class Filetxt extends Share
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
            $msg = '当前栏目名称已存在';
        }else{
            $this->startTrans();
            try{
                if($this->allowField($this->allow)->isUpdate(false)->save($value)){
                    $arr = $this->FileCreate($this->path['imgPhp'].$value['username']);
                    if($arr['code'] == 0){
                        $msg = $arr['msg'];
                    }else{
                        $this->commit();
                        $code = 1;
                        $msg = '添加成功';
                    }
                }
            }catch(Exception $e){
                $this->rollback();
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
            ['filetxt_id','neq',$value['filetxt_id']],
        ];
        $find = $this->field('username')->where('filetxt_id','=',$value['filetxt_id'])->find();
        $count = $this->where($where)->count();
        $code = 0;
        $msg = '修改失败';
        if(!empty($count)){
            $msg = '当前栏目名称已存在';
        }else{
            $this->startTrans();
            try{
                if($this->allowField($this->allow)->isUpdate(true)->save($value,['filetxt_id'=>$value['filetxt_id']])){
                    $arr = $this->FileCreate($this->path['imgPhp'].$find['username'],true,$this->path['imgPhp'].$value['username']);
                    if($arr['code'] == 1){
                        $this->commit();
                        $code = 1;
                        $msg = '修改成功';
                    }else{
                        $msg = $arr['msg'];
                    }
                }
            }catch(Exception $e){
                $this->rollback();
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
        $find = $this->field('username')->where('filetxt_id','=',$id)->find();
        if($this->where('filetxt_id','=',$id)->delete()){
            $this->delFile($this->path['imgPhp'].$find['username'].'/');
            $code = 1;
            $msg = '删除成功';
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
        $sql = $this->where($where)->order('filetxt_id desc')->paginate($data['limit'],false,['page'=>$data['page']])->toArray();
        $count = $this->where($where)->count();
        return returnModel($sql['data'],$count,'','');
    }


}
?>