DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`                 INT(11)      NOT NULL AUTO_INCREMENT,
    `username`           VARCHAR(45)  NOT NULL,
    `password`           VARCHAR(45)  NOT NULL,
    `token`              VARCHAR(100) NULL,
    `expire_time`        INT(11)      NULL COMMENT 'token过期时间',
    `login_time`         INT(11)     DEFAULT NULL COMMENT '本次登录的时间',
    `login_ip`           VARCHAR(25) DEFAULT NULL COMMENT '本次登录的ip',
    `identity`           TINYINT(4)  DEFAULT 1 COMMENT '1普通用户,2代理,9管理员',
    `status`             TINYINT(4)  default 1 COMMENT '1正常,0禁用',
    `create_time`        INT(11)     DEFAULT NULL COMMENT '创建时间',
    `update_time`        INT(11)     DEFAULT NULL COMMENT '更新时间',
    `delete_time`        INT(11)     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;


DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource`
(
    `id`          INT(11)      NOT NULL AUTO_INCREMENT,
    `type`        VARCHAR(60) DEFAULT NULL COMMENT '文件类型',
    `site_url`    VARCHAR(255) NOT NULL COMMENT '请求的资源链接',
    `site_id`     INT(11)      NOT NULL,
    `create_time` INT(11)     DEFAULT NULL COMMENT '创建时间',
    `update_time` INT(11)     DEFAULT NULL COMMENT '更新时间',
    `delete_time` INT(11)     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;

DROP TABLE IF EXISTS `resource_types`;
CREATE TABLE `resource_types`
(
    `id`                       INT(11)      NOT NULL AUTO_INCREMENT,
    `name`                     VARCHAR(255) DEFAULT NULL,
    `sign`                     VARCHAR(255) NOT NULL,
    `resource_id`              INT(11)      DEFAULT NULL,
    `download_url`             TEXT         DEFAULT NULL,
    `download_url_expire_time` INT(11)      DEFAULT NULL,
    `hash`                     VARCHAR(100) default NULL COMMENT '第三方Hash',
    `key`                      VARCHAR(100) default NULL COMMENT '第三方Key',
    `create_time`              INT(11)      DEFAULT NULL COMMENT '创建时间',
    `update_time`              INT(11)      DEFAULT NULL COMMENT '更新时间',
    `delete_time`              INT(11)      DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;

DROP TABLE IF EXISTS `download`;
CREATE TABLE `download`
(
    `id`               INT(11)     NOT NULL AUTO_INCREMENT,
    `resource_id`      INT(11)     NOT NULL,
    `resource_type_id` INT(11)     NOT NULL,
    `site_id`          INT(11)     NOT NULL,
    `user_id`          INT(11) default NULL COMMENT '下载的用户',
    `ip`               varchar(20) NOT NULL COMMENT '下载时的ip',
    `create_time`      INT(11) DEFAULT NULL COMMENT '创建时间',
    `update_time`      INT(11) DEFAULT NULL COMMENT '更新时间',
    `delete_time`      INT(11) DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;



DROP TABLE IF EXISTS `site`;
CREATE TABLE `site`
(
    `id`                                INT(11)      NOT NULL AUTO_INCREMENT,
    `name`                              varchar(100) NOT NULL COMMENT '网站名',
    `domain`                            varchar(100) NOT NULL COMMENT '网站domain',
    `login_url`                         varchar(255) NOT NULL COMMENT '网站登录凭证',
    `login_credentials`                 text       default NULL COMMENT '网站登录凭证',
    `login_qq_type`                     tinyint(4) default 2 COMMENT '1输入账号密码登陆，2直接点击头像登陆',
    `driver_wait_time`                  INT(11)    default 15 COMMENT '驱动等待时间',
    `resource_download_url_expire_time` INT(11)      NOT NULL COMMENT '秒数',
    `create_time`                       INT(11)    DEFAULT NULL COMMENT '创建时间',
    `update_time`                       INT(11)    DEFAULT NULL COMMENT '更新时间',
    `delete_time`                       INT(11)    DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;

insert into `site`(`id`, `name`, `domain`, `login_url`, `resource_download_url_expire_time`, `create_time`)
values (1, '千库网', '588ku.com', 'https://588ku.com/',3000, unix_timestamp());

insert into `site`(`id`, `name`, `domain`, `login_url`, `resource_download_url_expire_time`, `create_time`)
values (2, '90设计网', '90sheji.com', 'http://90sheji.com/',480, unix_timestamp());

insert into `site`(`id`, `name`, `domain`, `login_url`, `resource_download_url_expire_time`, `create_time`)
values (3, '千图网', 'www.58pic.com', 'https://www.58pic.com/login', 3000, unix_timestamp());

insert into `site`(`id`, `name`, `domain`, `login_url`, `resource_download_url_expire_time`, `create_time`)
values (4, '觅知网', 'www.51miz.com', 'https://www.51miz.com/', 1800, unix_timestamp());

DROP TABLE IF EXISTS `system`;
CREATE TABLE `system`
(
    `id`      INT(11) NOT NULL AUTO_INCREMENT,
    `note`    INT(11)      default null,
    `qq_info` varchar(255) default null,
    PRIMARY KEY (`id`)
) ENGINE = INNODB;
insert into `system`(`id`, `qq_info`)
values (1, 'a:2:{s:8:"username";s:10:"1422476675";s:8:"password";s:9:"wdbbtong~";}');
