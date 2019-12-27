<?php
/*
 * 自定义文件 - 验证
 * */
namespace app\common\validate;
class Html extends Share
{
    protected $rule = [
        'username' => 'require|length:2,16|alphaDash',
        'back' => 'require|length:1,32',
        'disable' => 'require|length:1,11|in:1,2',
        'html_id' => 'require|length:1,11|number',
    ];

    protected $message = [
        'username' => '网页名称不能为空，只支持字母、数字以及-_，长度2位之16位',
        'back' => '备注不能为空，长度1位之32位',
        'disable' => '是否启用异常',
        'html_id' => 'ID异常',
    ];

    protected $scene = [
        'add' => ['username','back','disable'],
        'edit' => ['username','back','disable','html_id'],
        'del' => ['html_id'],
    ];
}

?>