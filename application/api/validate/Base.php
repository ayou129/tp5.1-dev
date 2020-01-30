<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/2
 * Time: 22:02
 */

namespace app\api\validate;


use app\exception\Base as ExceptionBase;
use think\Validate;

class Base extends Validate
{
    /**
     * @param bool $scene
     * @param array $param
     * @param bool $batch
     * @throws ExceptionBase
     */
    public function goCheck($scene = false, array $param = [], $batch = false)
    {
        $r_params = empty($param) ? \request()->param() : $param;
        if ($scene) $this->scene($scene);
        if ($batch) {
            $this->batch();
        }
        if (!$this->check($r_params)) {
            //            halt($this->error);
            throw new ExceptionBase(['msg' => $this->error]);
        }
    }
}