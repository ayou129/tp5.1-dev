<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/2
 * Time: 21:13
 */

namespace app\exception;

use app\api\service\Email;
use Exception;
use think\exception\HttpException;
use think\facade\Log;

class Handle extends \think\exception\Handle
{
    public $http_code = 500;
    public $client_code = -1;
    public $msg = 'failed';
    public $data;

    public function render(Exception $e)
    {
//        var_dump($e);
//        halt($e->getMessage());
        if ($e instanceof Base) {
            //参数验证错误 //无权限
            $this->server_code = $e->http_code;
            $this->client_code = $e->client_code;
            $this->msg = $e->msg;
            if (!is_null($e->data)) {
                $this->data = $e->data;
            }
        } elseif ($e instanceof HttpException) {
            //请求异常
            $this->http_code = 404;
            $this->client_code = -1;
            $this->msg = 'pages is not found!';
        } elseif ($e instanceof Exception) {
            //系统异常 如1/0，记录日志
            $params = implode(",", \request()->param());
            new Email("1422476675@qq.com", 'lee', [
                "subject" => "系统错误",
                "body" => "参数：{$params};详细：{$e->getMessage()}"
            ]);
            $this->server_code = 1000;
            $this->msg = '数据异常，管理员处理中...';
            Log::error($e->getMessage());
        } else {
            // 其他错误交给系统处理
            return parent::render($e);
        }
        $result = [
            'client_code' => $this->client_code, 'msg' => $this->msg,
        ];
        if (!is_null($this->data)) {
            $result['data'] = $this->data;
        }
        return json($result, $this->http_code);
    }
}