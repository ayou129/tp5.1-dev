<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/10
 * Time: 13:30
 */

namespace app\api\job;

use app\api\model\ResourceTypes as ResourceTypesModel;
use app\api\service\Qiniu;
use think\queue\Job;

class Test
{
    //XXX.bat
    //cmd /k "cd C:\inetpub\LocalUser\resources&php think queue:listen --queue Test --memory 1024 --timeout 300 --sleep 3"
    public function fire(Job $job, $data)
    {
        $now_time = date("Y-m-d H:i:s",time());
        // 有些消息在到达消费者时,可能已经不再需要执行了
        //        set_time_limit(0);
        $isJobStillNeedToBeDone = $this->checkDatabaseToSeeIfJobNeedToBeDone($data);
        if ($isJobStillNeedToBeDone) {
            print("<warn>检测到该任务已经完成，执行删除! 时间:{$now_time}" . "</warn>\n");
            $job->delete();
            return true;
        }
        $isJobDone = $this->doJob($data);
        if ($isJobDone) {
            // 如果任务执行成功， 记得删除任务
            print("<warn>任务执行完毕，现在删除该任务! 时间:{$now_time}" . "</warn>\n");
            $job->delete();
        } else {
            if ($job->attempts() > 0) {
                //通过这个方法可以检查这个任务已经重试了几次了
                print("<warn>任务执行超过1次，执行删除! 时间:{$now_time}" . "</warn>\n");
                $job->delete();

                // 也可以重新发布这个任务
                //print("<info>Hello Job will be availabe again after 2s."."</info>\n");
                //$job->release(2); //$delay为延迟时间，表示该任务延迟2秒后再执行
            } else {
                $job->release(10);
            }
        }
    }

    private function doJob($data)
    {
        try {
//            $download_url = trim($data['download_url']);
//            $resource_type_id = trim($data['resource_type_id']);

            if (true) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 有些消息在到达消费者时,可能已经不再需要执行了
     * @param array|mixed $data 发布任务时自定义的数据
     * @return boolean                 任务执行的结果
     */
    private function checkDatabaseToSeeIfJobNeedToBeDone($data)
    {
        if (true) {
            return true;
        }
        return false;
    }

    public function failed($data)
    {
        // ...任务达到最大重试次数后，失败了
    }
}