<?php
/**
 * Created by PhpStorm.
 * User: Administrator <email:guoxinlee129@gmail.com>
 * Date: 2020/1/9
 * Time: 17:51
 */

namespace app\api\service;


use app\api\message\Error;
use app\exception\Base;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\facade\Log;

class Qiniu
{
    public $auth;
    public $expires = 3600;
    public $policy = null;

    public function __construct()
    {
        $accessKey = "BmAFAtU4xpqUzR6C92FsMSp4tnR4gySHnKcJ4Yx4";
        $secretKey = "eu_QRA3BXMlZ5z9cgAkGalsCgp8RBt42CtDY8Eqq";

        // 初始化Auth状态
        $this->auth = new Auth($accessKey, $secretKey);
    }

    /**
     * @param $file_path |要上传文件的本地路径
     * @param $file_save_name_in_qiniu |上传到七牛后保存的文件名
     * @param $bucket |容器的名称
     * @return mixed
     * @throws Base
     */
    public function putFile($file_path, $file_save_name_in_qiniu, $bucket)
    {
        // 生成上传 Token
        $token = $this->auth->uploadToken($bucket);

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $file_save_name_in_qiniu, $file_path);
        if ($err !== null) {
            new Email("1422476675@qq.com", 'lee', [
                "subject" => "上传文件失败",
                "body"    => "详细代码：{$err}"
            ]);
        } else {
//            'hash' => string 'lshf1cFWuOYkhfwVdUPByWYoAOF7' (length=28)
//            'key' => string '588ku_67114e9dec378c48e9b3d5ed1e8f1366.zip' (length=42)
            return $ret;
        }
    }
}