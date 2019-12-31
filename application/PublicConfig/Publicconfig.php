<?php

//controller 和 model公用的操作方法
namespace app\PublicConfig;
use Net\IpLocation; //IP库
trait Publicconfig{

    /*
     * 上传图片
     * @param string $url 上传的目录地址
     * @param string $val 使用上传的键名
     * @param string $size 允许上传文件大小
     * @param string $ext 设置允许后缀名称
     * return array 状态码(code),相关信息(data)
     * */
    protected function imgApi($url='',$val='file',$size=1024*1024,$ext='jpg,png,gif,jpeg,ico')
    {
        $path = config('path.');
        if(empty($url)){
            $url = $path['runtimeImg'];
        }
        if(!empty(is_writable($url))){ //判断当前目录是否有权限写入
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file($val);
            // 移动到框架应用根目录/uploads/ 目录下
            $info = @$file->validate(['size'=>$size,'ext'=>$ext])->move($url);
            if($info){
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $code = 1;
                $data = str_replace('\\','/',$info->getSaveName());
                //判断根目录文件夹是否存在，没有就创建文件夹
                $url_times = $path['imgPhp'].'/'.date('Ymd');
                if(empty(file_exists($url_times))){ //为空就创建文件夹
                    if(!is_dir($url_times)){
                        $res = @mkdir(iconv("UTF-8", "GBK", $url_times),0777,true);
                    }
                }
            }else{
                // 上传失败获取错误信息
                $code = 0;
                $data = $file->getError();
            }
        }else{
            $code = 0;
            $data = '当前上传文件没有权限写入服务器，请联系管理员';
        }
        return [
            'code' => $code,
            'data' => $data,
        ];
    }
    /*
     * 移动文件
     * @param string $url 要复制的文件地址
     * @param string $val 目标地址
     * return bool 返回布尔值
     * */
    protected function moving($url,$val)
    {
        if(!empty(copy($url,$val))){
            return true;
        }
        return false;
    }

    /*
     * 验证文件是否有权
     * @param $val string 目录或文件地址
     * return array 状态码(code),提示语(msg)
     * */
    protected function Authority($val)
    {
        $msg = '当前没有操作写入权限，请联系管理员！';
        $code = 0;
        if(!empty(is_writable($val))){
            if(!empty(file_exists($val))){
                $msg = 'success';
                $code = 1;
            }else{
                $msg = '文件不存在';
            }
        }
        return ['code'=>$code,'msg'=>$msg];
    }


    /*
     * 删除文件
     * @param $value string 文件地址
     * */
    protected  function FileDel($value)
    {
        if(!empty(file_exists($value))){
            unlink($value);
        }
    }

    /*
     * 创建文件并写入数据
     * @param $data 文件目录
     * @param $username 文件名称
     * return array 状态码(code),提示语(msg)
     * */
    protected function FileCount($data,$username,$txt)
    {
        if(!empty(is_writable($data))){
            $fh = fopen($data.$username, 'w');
            fwrite($fh , $txt);
            fclose($fh);
            return true;
        }
        return false;
    }

    /*
     * 返回文件目录列表数据
     * @param string $value 文件目录
     * @return array 返回状态码、文件数据
     * */
    protected function returnFile($value)
    {
        $data = [];
        if(is_dir($value)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($value);
            foreach ($p as $k => $v){
                if($v != '.' && $v != '..'){
                    $data[] = [
                        'data' => $v,
                        'key' => $k,
                    ];
                }
            }
            $code = 1;
        }else{
            $code = 0;
        }
        return [
            'code' => $code,
            'data' => $data,
        ];
    }
    /*
     * 删除文件夹
     * @param string $path 文件目录
     * */
    protected function delFile($path)
    {
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            $count = count($p);
            foreach($p as $k => $v){
                if($v != '.' && $v != '..'){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.$v)){
                        //子目录中操作删除文件夹和文件
                        $this->delFile($path.$v.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.$v.'/');
                    }else{
                        //如果是文件直接删除
                        unlink($path.$v);
                    }
                }
                if($count == $k+1){
                    @rmdir($path);
                }
            }
        }
    }
    /*
     * 打开文件
     * @param $data 文件目录
     * */
    protected function openFile($data)
    {
        $fh = fopen($data, 'r');
//        $arr = '';
        $arr = fread($fh, filesize ($data));
//        while(! feof($fh))
//        {
//            $arr .= fgets($fh);
//        }
        fclose($fh);
        return $arr;
    }
    /*
     * 创建文件夹
     * @param $url_times 文件目录
     * @param bool $bool 判断是否要修改文件名
     * @param string $rename 新的文件名目录
     * return array 状态码(code),提示语(msg)
     * */
    protected function FileCreate($url_times,$bool=false,$rename='')
    {
        //判断目录文件夹是存在
        $code = 0;
        $msg = '创建文件失败，请检查是否权问题';
        if(empty(file_exists($url_times))){ //为空就创建文件夹
            if(!is_dir($url_times)){
                $res = @mkdir(iconv("UTF-8", "GBK", $url_times),0777,true);
                if($res){
                    $code = 1;
                    $msg = true;
                }
            }else{
                $msg = '当前不是一个正确的目录地址';
            }
        }else if($bool == true && !empty(file_exists($url_times)) && !empty($rename)){
            $res = iconv("UTF-8", "GBK", $url_times); //旧文件
            $name = iconv("UTF-8", "GBK", $rename); //新文件
            if (rename($res, $name))//修改目录
            {
                $code = 1;
                $msg = true;
            }else{
                $msg = '修改文件失败';
            }

        }else{
            $code = 1;
            $msg = true;
        }
        return ['code'=>$code,'msg'=>$msg];
    }

    /*
     * 返回IP相关信息
     * @param $ip string 传入ip地址
     * return 返回地区信息
     * */
    protected function Ip($ip='')
    {
        if(empty($ip)){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $Ip = new IpLocation('UTFWry.dat');
        $ipadder = $Ip->getlocation($ip);
        $data['ip'] = $ip;
        if($ip == '127.0.0.1'){
            $data['country'] = '本地局网地址';
        }else{
            $data['country'] = $ipadder['country'].' '.$ipadder['area'];
        }
        return $data;
    }
}

?>