<?php
/**
 * Created by PhpStorm.
 * User: leetx
 * Date: 2019/4/11
 * Time: 14:57
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Collect extends Facade
{
    /**
     * 获取组件的注册名称。
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'collect';
    }
}