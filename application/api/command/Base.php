<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/7
 * Time: 19:54
 */

namespace app\api\command;

use app\api\service\Email;
use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;

class Base extends Command
{
    /**
     * 配置指令
     * 教程：https://www.kancloud.cn/manual/thinkphp5_1/354146
     */
    protected function configure()
    {
        //首先在配置文件添加入口：application/command.php
        //'Base' => 'app\api\command\Base',
        //外部执行 php think Base
        $this->setName('test')
            ->addOption("test_param", null, Option::VALUE_REQUIRED)
            ->setDescription('test Description');
    }

    /**
     * 执行指令
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     * @throws \app\exception\Base
     */
    protected function execute(Input $input, Output $output)
    {
        $test_param = trim($input->getOption("test_param"));
        try {
            $output->writeln("done! {$test_param}");
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            $error_str = (string)$exception->getMessage();
            new Email("1422476675@qq.com", 'lee', [
                "subject" => "自动获取所有资源平台登录态失败",
                "body" => "可能系统<b style='color:red'>更新</b>，详细代码：{$error_str}"
            ]);
        }
    }
}