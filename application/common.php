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

//

?>