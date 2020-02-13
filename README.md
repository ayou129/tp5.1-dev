### 将所有系统软件图标放置桌面(方便操作)
***
1. 这台电脑
2. 控制面板
3. 命令提示符
4. 服务
5. 防火墙
6. 任务计划程序
6. 计算机管理

### 将所有第三方软件拉入服务器中
***
1. 微软系统前置软件(MSVBCRT.AIO.2019.04.24.x64)(首先安装，并且重启)
2. Notepad++(wampserver3.1.7_x64)
3. Google浏览器(ChromeStandaloneSetup64_72.0.3626.96)
4. WampServer(wampserver3.1.7_x64)
5. Redis(Redis-x64-3.2.100)
6. Composer(Composer-Setup)
7. Node+npm(node-v12.14.1-x64)
8. 安全狗(safedogfwqV5.0.exe)

### 关闭不相关软件
***
1. 关闭电脑自动更新
- 运行->  services.msc  ->window update(服务) 禁用
2. 永不熄灭屏幕，电源选项
3. 任务计划程序，设置开机自启的软件
    - 任务计划程序
    - wamp
4. 依次建立文件夹```C:\inetpub\LocalUser\web(网站根目录)```
5. 快速文件夹
```
C:\Windows\System32\drivers\etc
C:\wamp64\bin\apache\apache2.4.37\logs
C:\inetpub\LocalUser\web
```
### 增加环境变量
>电脑右键->高级->环境变量->系统变量->Path增加
```text
C:\wamp64\bin\php\php7.2.14
C:\ProgramData\ComposerSetup\bin
```

### 配置各个软件
*** 
#### Composer
##### 下载
- https://getcomposer.org/download/或U盘里的安装包
##### 更换中国镜像
- composer config -g repo.packagist composer https://packagist.phpcomposer.com

#### Npm
***
##### 下载
> http://nodejs.cn/
##### 更换速度更快的节点
```
npm install -g nrm
nrm ls
nrm test *
nrm use *
```
***
#### Mysql
- 更改密码
```mysql
MYSQL>set password for root@localhost = password('abcABC123');
```
- 添加局域网访问
   1. 防火墙设置(一定要开 入站规则，FTP可以不开)
   - 控制面板 系统和安全 windows防火墙 高级设置 出站规则 新建规则 3306添加
   2. 命令
```text
update user set host = '%' where user = 'root';

GRANT ALL PRIVILEGES ON *.* TO 'resources'@'192.168.1.3' IDENTIFIED BY 'abcABC123' WITH GRANT OPTION;

FLUSH PRIVILEGES;

delete from user where host = '192.168.1.3';
DELETE FROM `user` WHERE `User` = 'lee129';
```

#### Redis
***
redis文档：https://github.com/MicrosoftArchive/redis/releases/tag/win-3.2.100
***
##### 开启Redis
- 方式1
```text
cd到redis目录
执行：D:\redis>redis-server.exe redis.windows.conf
```
>若仍报以下错误：# Creating Server TCP listening socket 127.0.0.1:6379: bind: No error

> 按顺序输入如下命令就可以连接成功
>- redis-cli.exe
>- shutdown
>- exit
>- redis-server.exe redis.windows.conf

- 方式2，开启redis服务
```text
redis-server --service-install redis.windows-service.conf --loglevel verbose
```
##### 在php安装扩展redis
###### 下载redis扩展
http://pecl.php.net/package/redis
http://pecl.php.net/package/redis/5.1.1/windows
***
- 查看`phpinfo();`的Zend Extension Build	API320170718,TS,VC15
- 去选择日期-> php_redis-5.1.1-7.4-ts-vc15-x64.zip
- 将`php_redis.dll`放入php/ext中
- 修改php7.2的php.ini和apache\bin下的php.ini，增加
```text
[Redis]
extension=php_redis.dll
```

#### Window开启FTP服务
1. 程序和功能 打开或关闭Windows功能 安装 在Inter information service下
- 前置设置
    - 先安装.NET Framework低版本  重启
        - FTP服务
        - FTP扩展性
        - IIS管理控制台
2. 创建FTP隔离用户(文件夹)
- 所有web文件目录全放到 ftp当中(首先创建LocalUser，创建对应的用户例如：project1)
```text
C:\inetpub\LocalUser\project1
C:\inetpub\LocalUser\project2
C:\inetpub\LocalUser\project3
```
3. 计算机管理 系统工具 本地用户和组 用户 添加 新用户
- 用户不能更改密码
- 密码永不过期
4. 创建FTP
- 端口8101 8102
- IP地址设置全部未分配 切记！
5. 点击创建的ftp右键 编辑器权限，给刚创建的用户(找到所在的组)权限

- 如果不是阿里云服务器，则只需要设置防火墙
- 如果是阿里云服务器，关闭防火墙，在阿里云控制台设置防火墙

- 主动模式需要 (自定义端口+20)
    - 命令链路：自定义端口，默认是21
    - 数据链路：服务器的20端口，服务器访问客户端
- 被动模式需要 (自定义端口+1024/65535)
    - 命令链路：自定义端口，默认是21
    - 数据链路：服务器的大范围端口，客户端访问服务器

文档https://xuliangzhan_admin.gitee.io/xe-utils/#/
### 执行cmd的bat文件内容
```text
cmd /k "cd C:\inetpub\LocalUser\XXX&php think AutoLoginCredentials"
```
### 各个端口介绍
```text
MYSQL  3306
sshd   22
Vsftp  21、20
httpd  80
HTTPS/SSL 443
```

### 安装Chromedriver
*** 
https://npm.taobao.org/mirrors/chromedriver/

Composer安装
- php composer.phar require facebook/webdriver
- php composer.phar require qiniu/php-sdk
- php composer.phar require ext-curl
- php composer.phar require ext-json
- php composer.phar require phpmailer/phpmailer
- php composer.phar require sunra/php-simple-html-dom-parser
- php composer.phar require topthink/think-queue^2.0.4
- php composer.phar require composer-plugin-api
- php composer.phar require topthink/think-installer
- php composer.phar require topthink/think-helper ^1.0.4
- php composer.phar composer remove sunra/php-simple-html-dom-parser #这是删除命令，有需要时用

https://simplehtmldom.sourceforge.io/ 文档
https://microphp.us/plugins/public/microphp_res/simple_html_dom/manual.htm 中文文档


自动化命令行：
```cmd
java -Dwebdriver.chrome.driver=chromedriver.exe -jar selenium-server-standalone-4.0.0-alpha-2.jar

php think AutoLoginCredentials --site_name all
```
cmd.exe执行：
```text
cacls %COMSPEC% /E /G %COMPUTERNAME%\IUSR_%COMPUTERNAME%:R
```
```text
java -Dwebdriver.chrome.driver=chromedriver.exe -jar selenium-server-standalone-4.0.0-alpha-2.jar
```
### Thinkphp-queue
```text
php think queue:listen --queue PutFile \
--memory 1024 \
--timeout 300 \
--sleep 3 \
--delay 300
```



### 自定义任务
- 任务计划程序
> 一定要打开“控制面板->管理工具->本地安全策略”，选择“安全设置->本地策略->安全选项”，在右边列表中找到“域控制器：允许服务器操作者计划任务”，将状态改为“已启用”。

    1. 打开自动化文件(chromedriver&selenium) 选择对应bat
        - 延时 30S，系统问题，不设置延时打不开
    2. 打开队列程序PutFile 选择对应bat
        - 延迟45秒，因为有redis
    3. 打开更新登录态程序(updateLoginTai),每隔4小时更新一次
        1. 重复任务间隔4小时一次，持续时间无限期
        2. 热本文由最多延迟时间(随机延迟) 15分钟
    4. 启动wamp
    5. 启动QQ

###
vhost
***
```text
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
```