<?php


namespace app\api\controller;


use think\Controller;

class Base extends Controller
{
    public function home()
    {
        return json(['msg' => 'welcome！'], 200);

        //        echo phpinfo();
    }

    /**
     * @return \think\response\Json
     */
    public function miss()
    {
        return json(['msg' => '资源不存在！', 'client_code' => -1], 404);
    }

}