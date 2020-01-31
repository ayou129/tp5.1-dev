

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`          INT(11)      NOT NULL AUTO_INCREMENT,
    `username`    VARCHAR(45)  NOT NULL,
    `password`    VARCHAR(45)  NOT NULL,
    `token`       VARCHAR(100) NULL,
    `expire_time` INT(11)      NULL COMMENT 'token过期时间',
    `login_time`  INT(11)     DEFAULT NULL COMMENT '本次登录的时间',
    `login_ip`    VARCHAR(25) DEFAULT NULL COMMENT '本次登录的ip',
    `identity`    TINYINT(4)  DEFAULT 1 COMMENT '1普通用户,9管理员',
    `status`      TINYINT(4)  default 1 COMMENT '1正常,0禁用',
    `create_time` INT(11)     DEFAULT NULL COMMENT '创建时间',
    `update_time` INT(11)     DEFAULT NULL COMMENT '更新时间',
    `delete_time` INT(11)     DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;


#id 箱号 尺寸 箱型 空重 箱主代码 进场类型(装|拆) 动态类型(提吉|还吉) (进场|出场)车牌号 (进场|出场)时间 (进场|出场)提单号 堆位 备注


DROP TABLE IF EXISTS `caryard`;
CREATE TABLE `caryard`
(
    `id`                    INT(11)      NOT NULL AUTO_INCREMENT,
    `case_number`           VARCHAR(60)  NOT NULL COMMENT '箱号',
    `size`                  VARCHAR(60) NOT NULL COMMENT '尺寸',
    `box_type`              VARCHAR(60) NOT NULL COMMENT '箱型',
    `empty_weight`          VARCHAR(20) NOT NULL COMMENT '空重',
    `box_owner_code`        VARCHAR(60) NOT NULL COMMENT '箱主代码',
    `entry_type`            VARCHAR(60) NOT NULL COMMENT '进场类型',
    `dynamic_type`          VARCHAR(60) NOT NULL COMMENT '动态类型',
    `number_plate`          VARCHAR(60) NOT NULL COMMENT '车牌号',
    `bill_of_lading_number` VARCHAR(60) NOT NULL COMMENT '提单号',
    `stack_location`        VARCHAR(60) NOT NULL COMMENT '堆位',
    `Note`                  VARCHAR(255) DEFAULT NULL COMMENT '备注',
    `create_time`           INT(11)      DEFAULT NULL COMMENT '创建时间',
    `update_time`           INT(11)      DEFAULT NULL COMMENT '更新时间',
    `delete_time`           INT(11)      DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`)
) ENGINE = INNODB;
insert into caryard values('1','WSDU2121640','20','GP','空','ZGS','拆','提吉','粤G41375','JZCU5221548','好箱区',null,1580457655,null,null);
insert into caryard values('2','WSDU2121640','20','GP','重','ZGS','装','提吉','粤G41375','JZCU5221548','好箱区',null,1580457671,null,null);


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
