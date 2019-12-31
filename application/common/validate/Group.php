<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks:分组栏目 - 控制验证区域
 */
namespace app\common\validate;
class Group extends Share
{
    protected $rule = [
        'username' => 'require|length:1,32',
        'back' => 'length:1,100',
//        'disable' => 'require|in:1,2|number|length:1,11',
        'group_id' => 'require|number|length:1,11'
    ];

    protected $message = [
        'username' => '分组名称不能为空，长度只能是1-32位',
        'back' => '备注长度只能是1-100位',
//        'disable' => '是否启用异常',
        'group_id' => 'ID异常',
    ];
    protected $scene = [
        'add' => ['username','back',],
        'edit' => ['username','back','group_id'],
        'del' => ['group_id'],
    ];
}

?>