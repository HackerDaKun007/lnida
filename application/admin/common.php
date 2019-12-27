<?php

/*
 * 返回layui数据
 * @param $data array 结果数组
 * @param $count int 数据总长度
 * @para $page bool 正常true不正常false
 * */
function uiJson($data=[],$count='',$page=true,$success='')
{
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
function dataJson($code=1,$msg='', $data='',$url='')
{
    echo json_encode([
        'code' => $code
        ,'msg' => $msg
        ,'data' => $data
        ,'url' => $url
    ]);
}


/*
 * 加密信息
 * @param $val string 加密信息
 * @param $random string 随机加密信息
 * @param $dakun string 固定加密信息
 * */
function password($val,$random='',$dakun='heikedakun007@hide.com')
{
    if(empty($random)){
        $random = sui(8);
    }
    return [
        'random' => $random,
        'data' => sha1(md5($val.$random.$dakun)),
    ];
}

/*
 * 删除数组指定元素
 * @param $data array 原生数组
 * @param $value array 要删除数组的键值
 * return array 返回已删除数组
 * */
function unsetData($data,$value)
{
    foreach ($value as $k => $v)
    {
        if(isset($data[$v])){
            unset($data[$v]);
        }
    }
    return $data;
}

?>
