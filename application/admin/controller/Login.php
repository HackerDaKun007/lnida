<?php
namespace app\admin\controller;
use think\captcha\Captcha;
class Login extends Share
{
    /*
     * 登陆信息
     * */
    public function index()
    {
        //提交
        if(request()->isPost()){
            $data = input('post.');
            print_r($data);
            exit;
        }
        return view();
    }

    /*
     * 验证码
     * */
    public function yzm()
    {
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码位数
            'length'      =>    4,
            'fontttf'     =>   '5.ttf',
            // 关闭验证码杂点
//            'useNoise'    =>    false,
//            'codeSet'     =>    '0123456789'
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}

?>