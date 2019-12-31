<?php

// 应用公共文件
/*
 * model模块返回信息
 * $data array 返回数据组
 * $count int 返回一个长度
 * $msg string 返回一个提示
 * $code int 返回一个状态码
 * */
function returnModel($data,$count,$msg,$code)
{
    return [
        'data' => $data,
        'count' => $count,
        'msg' => $msg,
        'code' => $code
    ];
}


/*
 * 随机生成指定数字加字母位数
 * @param $val int 整数
 * return string 随机数
 * */
function suizm($val=8)
{
    $data = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
    return substr(str_shuffle($data),0,$val);
}

/*
 * 随机生成指定位数
 * @param $val int 整数
 * return string 随机数
 * */
function sui($val=8)
{
    $data = 'qwertyuiopasdfghjklzxcvbnm,.!@#$%^*()-=+1234567890?><:"{}|\~';
    return substr(str_shuffle($data),0,$val);
}


//
function josn($val)
{
    return json_encode($val);
}

?>