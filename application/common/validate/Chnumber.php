<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks: 验证器
 */
namespace app\common\validate;
class chnumber extends Share
{
    protected $rule = [
        'username' => 'require|length:1,32|alphaNum',
        'back' => 'length:1,100',
        'disable' => 'require|in:1,2|number|length:1,11',
        'chnumber_id' => 'require|length:1,11|number',
        'channel_id' => 'require|number|length:1,11|yzGroup:渠道分组异常'
    ];

    protected $message = [
        'username' => '渠道分组名称不能为空，长度只能是1-32位、只能支持字母和数字',
        'back' => '备注长度只能是1-100位',
        'disable' => '是否启用异常',
        'chnumber_id' => 'ID异常',
        'channel_id' => '渠道分组不能为空',
    ];
    protected $scene = [
        'add' => ['username','back','disable','channel_id'],
        'edit' => ['username','back','disable','chnumber_id','channel_id'],
        'del' => ['chnumber_id'],
    ];

    protected function yzGroup($value,$rul, $data = [])
    {
        $sql = $data['Group']->yzFiled($value);
        if($sql['code'] == 0){
            return $sql['msg'];
        }else{
            return true;
        }
    }
}
?>