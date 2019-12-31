<?php
/**
 * User: 大坤PHPer
 * Created by DaKun
 * Remarks: 自定义上传文件 - 验证器
 */

namespace app\common\validate;
class Filetxt extends Share
{
    protected $rule = [
        'username' => 'require|length:1,32|alphaNum',
        'back' => 'length:1,100',
        'filetxt_id' => 'require|number|length:1,11'
    ];

    protected $message = [
        'username' => '栏目名称不能为空，长度只能是1-32位、只能支持字母和数字',
        'back' => '备注长度只能是1-100位',
        'filetxt_id' => 'ID异常',
    ];
    protected $scene = [
        'add' => ['username','back'],
        'edit' => ['username','back','filetxt_id'],
        'del' => ['filetxt_id'],
    ];
}
