<?php

/*
 * 公共验证
 * */
namespace app\common\validate;
class Comm extends Share
{
   protected $rule = [
        'limit' => 'require|number',
        'page' => 'require|number',
   ];

   protected $message = [
        'limit' => 'limit异常',
        'page' => 'page异常',
   ];

   protected $scene = [
        'page' => ['limit','page'],
   ];
}

?>