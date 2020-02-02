<?php


namespace app\api\controller\v1;


use think\Controller;
use think\Queue;

class V1Base extends Controller
{
	protected function getParams($name)
	{
		$param = \request()->param();
		if (is_array($name)) {
			$return = [];
			foreach ($name as $item) {
				$example = @$param[$item];
				if ($example === null) {
					$return[$item] = null;
				} elseif ($example === 0) {
					$return[$item] = 0;
				} else {
					$return[$item] = $example;
				}
			}
			return $return;
		} else if (is_string($name)) {
			return @$param[$name];
		}
	}
}