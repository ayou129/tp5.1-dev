<?php


namespace app\api\controller\v1;

use think\Controller;
use app\exception\Base as BaseException;

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
					$return[$item] = self::guolvParam($example);
				}
			}
			foreach ($return as $item) {
				if (preg_match('/(and|or|union|where|limit|group by|select|hex|substr)/i', $item)) {
					throw new BaseException(['msg' => "参数错误"]);
				}
			}
			return $return;
		} else if (is_string($name)) {
			$result = @$param[$name];
			$result = self::guolvParam($result);
			if (preg_match('/(and|or|union|where|limit|group by|select|hex|substr)/i', $result)) {
				throw new BaseException(['msg' => "参数错误"]);
			}
			return $result;
		}
	}

	public static function guolvParam($value) {
		if(!get_magic_quotes_gpc()) {
			// 进行过滤
			$value = addslashes($value);
		}
		$value = str_replace("_", "\_", $value);
		$value = str_replace("%", "\%", $value);
		$value = nl2br($value);
		$value = htmlspecialchars($value);
		return $value;
	}
}