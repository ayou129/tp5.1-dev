<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2019/3/20
 * Time: 11:46
 */

namespace app\common\behavior;


class CORS
{
    public function appInit()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Token, X-Requested-With, Content-Type, Accept, Authorization");
        header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
        if (request()->isOptions()) {
            exit();
        }
    }
}