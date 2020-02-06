<?php


namespace app\api\controller;


use think\Controller;

class Base extends Controller
{
	public function home()
	{
//		$a = [
//			'token' => 'token content',
//			"temp"  => ['。；。；‘123·12.+·1*-2*-·/12/’', 'bbb', 'ccc' => ["cAA" => 1]]
//		];
//		$a = serialize($a);
//		$encrypt = authCrypt($a);
//		$decrypt = authCrypt($encrypt, "D");
//		halt(unserialize($decrypt));
		//    	halt(\Config::get("app.default_return_type"));
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