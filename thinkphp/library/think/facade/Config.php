<?php

namespace think\facade;

use think\Facade;

/**
 * @see \think\Config
 * @mixin \think\Config
 * @method bool has(string $name) static 检测配置是否存在
 * @method array pull(string $name) static 获取一级配置
 * @method mixed get(string $name,mixed $default = null) static 获取配置参数
 * @method mixed set(string $name, mixed $value = null) static 设置配置参数
 * @method array reset(string $prefix ='') static 重置配置参数
 */
class Config extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'config';
    }
}
