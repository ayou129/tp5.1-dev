<?php


namespace app\api\validate;


class Test extends Base
{
    protected $rule = [
        'XX' => 'require|integer|between:1,1000000',
    ];

    protected $message = [
        'XX.require' => '资源类型ID有误',
        'XX.integer' => '资源类型ID有误',
        'XX.between' => '资源类型ID有误',
    ];
    protected $scene = [
        'xx' => ['xx'],
    ];
}