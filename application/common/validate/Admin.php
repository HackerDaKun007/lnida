<?php
/*
 * admin验证信息模块
 * */
namespace app\common\validate;
class Admin extends Share
{
    protected $rule = [
        'username' => 'require|alphaNum|length:2,8',
        'password' => 'require|length:4,16',
        'repassword' => 'require|confirm:password',
        'disable' => 'require|number|in:1,2',
        'img' => 'require|length:1,150|ImgYz:头像不存在，请重新上传',
        'contact' => 'require|chsAlphaNum|length:1,32',
        'listed_id' => 'chsDash|length:1,11',
        'admin_id' => 'require|number|length:1,11',
    ];

    protected $message = [
        'username' => '用户名称不能为空、只支持字母和数字、长度2位之8位',
        'password' => '密码不能为空、长度4位之16位',
        'repassword.require' => '确定密码不能空',
        'repassword.confirm' => '确定密码不正确',
        'disable' => '是否启用异常',
        'contact' => '联系人不能为空、只支持汉字，字母，数字、长度1位之32位',
        'img' => '请上传头像',
        'listed_id' => '选择权限异常',
        'admin_id' => 'ID异常',
    ];

    protected $scene = [
        'add' => ['username','password','repassword','disable','contact','img','listed_id'],
        'edit' => ['username','password','repassword','disable','contact','img','listed_id','admin_id'],
        'edit_img' => ['username','password','repassword','disable','contact','listed_id','admin_id'],
        'edit_pass' => ['username','disable','contact','listed_id','admin_id','img'],
        'edit_pass_img' => ['username','disable','contact','listed_id','admin_id'],
        'del' => ['admin_id'],
    ];
}

?>