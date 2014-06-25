/*
Navicat MySQL Data Transfer

Source Server         : 虚拟机
Source Server Version : 50173
Source Host           : 192.168.0.198:3306
Source Database       : zeroappshop

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2014-06-09 18:36:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `loginname` varchar(64) DEFAULT NULL COMMENT '登录名',
  `password` varchar(64) DEFAULT NULL COMMENT '密码',
  `authority` varchar(64) DEFAULT NULL COMMENT '权限',
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for applog
-- ----------------------------
DROP TABLE IF EXISTS `applog`;
CREATE TABLE `applog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appid` int(11) NOT NULL COMMENT '应用APPID',
  `uid` int(11) NOT NULL COMMENT '修改人/审批人UID',
  `logtype` varchar(255) DEFAULT NULL COMMENT '日志类型',
  `loginfo` varchar(255) DEFAULT NULL COMMENT '日志信息',
  `time` datetime DEFAULT NULL COMMENT '日志时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cloud_app
-- ----------------------------
DROP TABLE IF EXISTS `cloud_app`;
CREATE TABLE `cloud_app` (
  `appid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'APP-ID',
  `appname` varchar(100) DEFAULT NULL COMMENT '应用名称',
  `type` varchar(100) DEFAULT NULL COMMENT '应用类型',
  `domain` varchar(100) DEFAULT NULL COMMENT '应用根域名',
  `introduce` varchar(100) DEFAULT NULL COMMENT '应用介绍',
  `shortintro` varchar(30) DEFAULT NULL COMMENT '应用短描述',
  `keyword` varchar(100) DEFAULT NULL COMMENT '应用关键字',
  `ico16` varchar(100) DEFAULT NULL COMMENT '16x16图标',
  `ico48` varchar(100) DEFAULT NULL COMMENT '48x48图标',
  `ico75` varchar(100) DEFAULT NULL COMMENT '75x75图标',
  `ico100` varchar(100) DEFAULT NULL COMMENT '100x100图标',
  `apikey` varchar(100) DEFAULT NULL COMMENT 'API-KEY',
  `secretkey` varchar(100) DEFAULT NULL COMMENT 'Secret Key',
  `canvasname` varchar(100) DEFAULT NULL COMMENT 'Canvas Page Name',
  `canvasurl` varchar(100) DEFAULT NULL COMMENT 'Canvas URL',
  `callbackurl` varchar(100) DEFAULT NULL COMMENT 'Web Callback URL',
  `appurl` varchar(100) DEFAULT NULL COMMENT '应用访问URL / 下载地址',
  `iframe` varchar(100) DEFAULT NULL COMMENT 'Iframe高度',
  `showimg` varchar(100) DEFAULT NULL COMMENT '未登陆时海报',
  `status` int(4) DEFAULT NULL COMMENT '审核状态',
  `update` datetime DEFAULT NULL COMMENT '最后更新时间',
  `creattime` datetime DEFAULT NULL COMMENT '应用创建时间',
  PRIMARY KEY (`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for cloud_user
-- ----------------------------
DROP TABLE IF EXISTS `cloud_user`;
CREATE TABLE `cloud_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `username` varchar(255) NOT NULL COMMENT '开发者姓名',
  `type` varchar(255) NOT NULL COMMENT '开发者类型',
  `address` varchar(255) DEFAULT NULL COMMENT '所在地区',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `chat` varchar(255) DEFAULT NULL COMMENT '聊天工具',
  `chatid` varchar(255) DEFAULT NULL COMMENT '聊天工具账号',
  `realname` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `certificate` varchar(255) DEFAULT NULL COMMENT '证件类型',
  `certificateid` varchar(255) DEFAULT NULL COMMENT '证件号码',
  `certificateimg` varchar(255) DEFAULT NULL COMMENT '证件图片',
  `mobile` varchar(16) DEFAULT NULL COMMENT '手机号',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
Enter file contents here
