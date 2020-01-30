<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/7
 * Time: 19:05
 */

namespace app\api\command;

use app\api\service\Core;
use app\api\service\Email;
use think\console\Input;
use think\console\Output;
use think\console\input\Option;

class AutoLoginCredentials extends Base
{
    protected function configure()
    {
        $this->setName('AutoLoginCredentials')->addOption("site_name", null, Option::VALUE_REQUIRED);
    }

    protected function execute(Input $input, Output $output)
    {
        $option = trim($input->getOption("site_name"));
        try{
            switch ($option) {
                case "588ku.com":
                    (new Core())->get588KuLoginCredentials();
                    break;
                case "90sheji.com":
                    (new Core())->get90ShejiLoginCredentials();
                    break;
                case "www.58pic.com":
                    (new Core())->get58PicLoginCredentials();
                    break;
                case "www.51miz.com":
                    (new Core())->get51MizLoginCredentials();
                    break;
                case "all":
                    (new Core())->getLoginCredentialsAll();
                    break;
                default:
                    break;
            }
            $output->writeln("done!");
        }catch (\Exception $exception){
            $output->writeln($exception->getMessage());
            $error_str = (string)$exception->getMessage();
            new Email("1422476675@qq.com", 'lee', [
                "subject" => "自动获取所有资源平台登录态失败",
                "body"    => "可能系统<b style='color:red'>更新</b>，详细代码：{$error_str}"
            ]);
        }
    }
}