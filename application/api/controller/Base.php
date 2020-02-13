<?php


namespace app\api\controller;


use think\Controller;

class Base extends Controller
{

	public function home()
	{
//		try {
//			$de = "该项⽬为单⽤户⽹上商城系统B2C电⼦商务系统，店铺管理员可以进⾏会员制管理、会员卡管理、会员积分管理、会员消费管理、会员营销、结算收银等操作。";
//			var_dump(unserialize($de));
//			die;
//		} catch (\Exception $exception) {
//			var_dump($exception->getMessage());
//			die;
//		}

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