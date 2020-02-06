<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/2
 * Time: 21:13
 */

namespace app\exception;


use think\Exception;

class Base extends Exception
{
    public $http_code = 500;
    public $client_code = -1;
    //-1 正常错误
    //-2 返回后前台需要删除登陆态
    public $msg = 'failed';
    public $data;


    public function __construct(array $params = [])
    {
	    if (array_key_exists('msg', $params)) {
		    $this->msg = $params['msg'];
	    }
	    if (array_key_exists('data', $params)) {
		    $this->data = $params['data'];
	    }
	    if (array_key_exists('client_code', $params)) {
		    $this->client_code = $params['client_code'];
	    }
	    if (array_key_exists('http_code', $params)) {
		    $this->http_code = $params['http_code'];
	    }
    }
}