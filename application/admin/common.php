<?php

/*
 * 返回layui数据
 * @param $data array 结果数组
 * @param $count int 数据总长度
 * @para $page bool 正常true不正常false
 * */
function uiJson($data=[],$count='',$page=true,$success=''){
    echo json_encode([
        'code' => 0,
        'count' => $count!=''?$count:count($data),
        'data' => $data,
        'page' => $page,
        'success' => $success
    ]);
}

/*
 * 控制返回信息
 * @param $code int 返回状态码
 * @param $msg string 返回提示语句
 * @param $data arrar 返回相关数据
 * @param $data array 返回相关url
 * */
function dataJson($code=1,$msg='', $data='',$url=''){
    echo json_encode([
        'code' => $code
        ,'msg' => $msg
        ,'data' => $data
        ,'url' => $url
    ]);
}


?>
