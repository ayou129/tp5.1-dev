MYSQL  3306
sshd   22
Vsftp  21、20
httpd  80
HTTPS/SSL 443

执行cmd的bat文件内容：
cmd /k "cd C:\inetpub\LocalUser\XXX&php think AutoLoginCredentials"

1.关闭电脑自动更新
	运行->  services.msc  ->window update
2.永不熄灭屏幕，电源选项

任务计划程序

C:\ProgramData\Microsoft\Windows\Start Menu\Programs\StartUp
C:\Windows\System32\drivers\etc
C:\wamp64\bin\apache\apache2.4.37\logs
C:\Users\Administrator\Desktop\web


https://npm.taobao.org/mirrors/chromedriver/
安装Composer
    1.下载
        https://getcomposer.org/download/   或U盘里的安装包
    2.更换中国镜像
        composer config -g repo.packagist composer https://packagist.phpcomposer.com

install Composer：https://getcomposer.org/download/
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"

Composer安装
    php composer.phar require facebook/webdriver
    php composer.phar require qiniu/php-sdk
    php composer.phar require ext-curl
    php composer.phar require ext-json
    php composer.phar require phpmailer/phpmailer
    php composer.phar require sunra/php-simple-html-dom-parser
    php composer.phar require topthink/think-queue^2.0.4
    php composer.phar require composer-plugin-api
    php composer.phar require topthink/think-installer
    php composer.phar require topthink/think-helper ^1.0.4
    #这是删除命令，有需要时用 php composer.phar composer remove sunra/php-simple-html-dom-parser

    https://simplehtmldom.sourceforge.io/ 文档
    https://microphp.us/plugins/public/microphp_res/simple_html_dom/manual.htm 中文文档

/*
自动化命令行：
    java -Dwebdriver.chrome.driver=chromedriver.exe -jar selenium-server-standalone-4.0.0-alpha-2.jar
    php think AutoLoginCredentials --site_name all


cmd.exe执行：
    >cacls %COMSPEC% /E /G %COMPUTERNAME%\IUSR_%COMPUTERNAME%:R

1.java -Dwebdriver.chrome.driver=chromedriver.exe -jar selenium-server-standalone-4.0.0-alpha-2.jar


Thinkphp-queue
    php think queue:listen --queue PutFile \
    --memory 1024 \
    --timeout 300 \
    --sleep 3 \
    --delay 300
*/

Mysql
    1.更改密码
        MYSQL>set password for root@localhost = password('abcABC123');

    2.添加局域网访问
        1.防火墙设置(一定要开 入站规则，FTP可以不开)
            控制面板 系统和安全 windows防火墙 高级设置 出站规则 新建规则 3306添加
        2.命令
            update user set host = '%' where user = 'root';
            GRANT ALL PRIVILEGES ON *.* TO 'resources'@'192.168.1.3' IDENTIFIED BY 'abcABC123' WITH GRANT OPTION;
            FLUSH PRIVILEGES;

            delete from user where host = '192.168.1.3';
            DELETE FROM `user` WHERE `User` = 'lee129';


Redis 安装
    下载安装redis
        https://github.com/MicrosoftArchive/redis/releases/tag/win-3.2.100
        下载redis扩展
            http://pecl.php.net/package/redis
            http://pecl.php.net/package/redis/5.1.1/windows
        查看phpinfo();的
            Zend Extension Build	API320170718,TS,VC15
        去选择日期
            -> php_redis-5.1.1-7.4-ts-vc15-x64.zip
        将php_redis.dll放入php/ext中
    运行
        D:\redis>redis-server.exe redis.windows.conf
        若仍报以下错误：
            # Creating Server TCP listening socket 127.0.0.1:6379: bind: No error
        按顺序输入如下命令就可以连接成功
            1. redis-cli.exe
            2. shutdown
            3. exit
            4. redis-server.exe redis.windows.conf
        window下安装redis服务并使其自启
            redis-server --service-install redis.windows-service.conf --loglevel verbose


Window开启FTP服务

    1.程序和功能 打开或关闭Windows功能 安装 在Inter information service下
        前置设置
            先安装.NET Framework低版本  重启
        FTP服务
        FTP扩展性
        IIS管理控制台
    2.创建FTP隔离用户(文件夹)
        所有web文件目录全放到 ftp当中(首先创建LocalUser，创建对应的用户例如：project1)
        C:\inetpub\LocalUser\project1
        C:\inetpub\LocalUser\project2
        C:\inetpub\LocalUser\project3
    3.计算机管理 系统工具 本地用户和组 用户 添加 新用户
        用户不能更改密码
        密码永不过期
    4.创建FTP
        端口8101 8102
        IP地址设置全部未分配 切记！
    5.点击创建的ftp右键 编辑器权限，给刚创建的用户(找到所在的组)权限
    *可能不需要调整防火墙

自定义任务
    任务计划程序
        1.打开自动化文件(chromedriver&selenium) 选择对应bat
            延时 30S，系统问题，不设置延时打不开
        2.打开队列程序PutFile 选择对应bat
            延迟45秒，因为有redis
        3.打开更新登录态程序(updateLoginTai),每隔4小时更新一次
            (1)重复任务间隔4小时一次，持续时间无限期
            (2)热本文由最多延迟时间(随机延迟) 15分钟
        4.启动wamp
        5.启动QQ
#
<VirtualHost *:8001>
	ServerName api.resources.com
	DirectoryIndex index.php
	DocumentRoot "C:/inetpub/LocalUser/resources/public"
	<Directory  "C:/inetpub/LocalUser/resources/public/">
		Options -Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Allow from all
		Require all granted
		Order allow,deny
	</Directory>
</VirtualHost>

#
<VirtualHost *:8002>
	ServerName www.resources.com
	ServerAlias resources.com
	DirectoryIndex index.html error.html
	DocumentRoot "C:/inetpub/LocalUser/resources_index"
	<Directory  "C:/inetpub/LocalUser/resources_index/">
		Options -Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Allow from all
		Require all granted
		Order allow,deny
	</Directory>
</VirtualHost>