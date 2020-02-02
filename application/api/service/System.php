<?php
/**
 * Created by PhpStorm.
 * User: lee <email:guoxinlee129@gmail.com>
 * Date: 2019/1/8
 * Time: 14:03
 */

namespace app\common\service;


use app\api\exception\ExceptionBase;

class System
{
    /**
     * @return string
     * @throws ExceptionBase
     */
    public function backup()
    {
        set_time_limit(0);
        ignore_user_abort(true);

        $filename = 'DATA' . '_' . date('Y-m-d_H-i-s') . '.sql';
        $db_database = config('database.database');
        $db_username = config('database.username');
        $db_password = config('database.password');
        $db_host_port = config('database.hostport');
        if (!is_dir(BACKUP_PATH)) {
            mkdir(BACKUP_PATH);
        }
        if (substr(php_uname(), 0, 7) == "Windows") {
            system('F:/work/phpStudy/PHPTutorial/MySQL/bin/mysqldump.exe ' . $db_database . ' -u' . $db_username . ' -p' . $db_password . ' -P' . $db_host_port . ' > ' . BACKUP_PATH . $filename, $return_val);
        } else {
            system('/usr/local/mysql/bin/mysqldump ' . $db_database . ' -u' . $db_username . ' -p' . $db_password . ' -P' . $db_host_port . ' > ' . BACKUP_PATH . $filename, $return_val);
        }

        if ($return_val == 0) {
            //防止其他意外情况备份失败
            $file_content = file_get_contents(BACKUP_PATH . $filename);
            if (is_null($file_content) || $file_content == false) {
                unlink(BACKUP_PATH . $filename);
                throw new ExceptionBase(['msg' => "备份数据失败"]);
            }
            return $filename;
        } else {
            if (is_file(BACKUP_PATH . $filename)) {
                unlink(BACKUP_PATH . $filename);
            }
            throw new ExceptionBase(['msg' => "备份数据失败"]);
        }
    }

//    public function import(){}
}