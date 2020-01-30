<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/2
 * Time: 22:02
 */

namespace app\api\validate;


class Resource extends Base
{
    protected $rule = [
        'resource_type_id' => 'require|integer|between:1,1000000',
    ];

    protected $message = [
        'resource_type_id.require' => '资源类型ID有误',
        'resource_type_id.integer' => '资源类型ID有误',
        'resource_type_id.between' => '资源类型ID有误',
    ];
    protected $scene = [
        'download' => ['resource_type_id'],
    ];
}