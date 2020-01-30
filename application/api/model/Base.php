<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/4
 * Time: 19:50
 */

namespace app\api\model;


use think\Model;
use think\model\concern\SoftDelete;

class Base extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['delete_time', 'update_time'];
    protected $type = [
        'id'                => 'integer',
    ];
}