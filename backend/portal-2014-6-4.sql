/*
Navicat MySQL Data Transfer

Source Server         : 11
Source Server Version : 50536
Source Host           : localhost:3306
Source Database       : teachingmanagement

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2014-06-04 14:34:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `portal`
-- ----------------------------
DROP TABLE IF EXISTS `portal`;
CREATE TABLE `portal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '门户名',
  `logo` varchar(100) DEFAULT NULL COMMENT '门户LOGO',
  `title_logo` varchar(100) DEFAULT NULL COMMENT '门户标题图',
  `out_url` varchar(200) DEFAULT NULL COMMENT '门户外链域名',
  `city` varchar(50) DEFAULT NULL COMMENT '门户所属城市',
  `open` int(1) DEFAULT NULL COMMENT '是否启用门户',
  `school_id` int(11) DEFAULT NULL COMMENT '学校ID',
  `html_index` varchar(100) DEFAULT NULL COMMENT '编辑后保存的主页',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户信息表';

-- ----------------------------
-- Records of portal
-- ----------------------------
INSERT INTO `portal` VALUES ('1', '教育窗口', null, null, null, '北京-海淀区', '1', '13', '/portal/shool13_index.html');
INSERT INTO `portal` VALUES ('2', '学生窗口', null, null, null, '北京-海淀区', '1', '13', '/portal/shool13_index.html');

-- ----------------------------
-- Table structure for `portal_feature`
-- ----------------------------
DROP TABLE IF EXISTS `portal_feature`;
CREATE TABLE `portal_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT '功能名称',
  `from` varchar(200) DEFAULT NULL COMMENT '功能来源',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户功能信息表';

-- ----------------------------
-- Records of portal_feature
-- ----------------------------
INSERT INTO `portal_feature` VALUES ('1', '企业管理课程', '从零学起', null);
INSERT INTO `portal_feature` VALUES ('2', '集邮趣谈', '从零学起', null);

-- ----------------------------
-- Table structure for `portal_group`
-- ----------------------------
DROP TABLE IF EXISTS `portal_group`;
CREATE TABLE `portal_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT '权限组名称',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户-功能权限表';

-- ----------------------------
-- Records of portal_group
-- ----------------------------
INSERT INTO `portal_group` VALUES ('1', '权限组1', '');
INSERT INTO `portal_group` VALUES ('2', '权限组2', '');

-- ----------------------------
-- Table structure for `portal_groupusers`
-- ----------------------------
DROP TABLE IF EXISTS `portal_groupusers`;
CREATE TABLE `portal_groupusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(200) DEFAULT NULL COMMENT '用户ID',
  `user_name` varchar(200) DEFAULT NULL COMMENT '用户名称',
  `user_account` varchar(200) DEFAULT NULL COMMENT '用户帐号名',
  `group_id` int(11) DEFAULT NULL COMMENT '权限组ID',
  `role` int(1) DEFAULT NULL COMMENT '0|阻止，1| 通过',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户-功能权限表';

-- ----------------------------
-- Records of portal_groupusers
-- ----------------------------
INSERT INTO `portal_groupusers` VALUES ('1', '', '张三', 'user001', '1', '1');
INSERT INTO `portal_groupusers` VALUES ('2', '', '李四', 'user003', '1', '0');

-- ----------------------------
-- Table structure for `portal_portal_groupmap`
-- ----------------------------
DROP TABLE IF EXISTS `portal_portal_groupmap`;
CREATE TABLE `portal_portal_groupmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `portal_id` varchar(200) DEFAULT NULL COMMENT '功能ID',
  `group_id` varchar(200) DEFAULT NULL COMMENT '权限组ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户功能信息表';

-- ----------------------------
-- Records of portal_portal_groupmap
-- ----------------------------
INSERT INTO `portal_portal_groupmap` VALUES ('1', '1', '2');
INSERT INTO `portal_portal_groupmap` VALUES ('2', '1', '2');

-- ----------------------------
-- Table structure for `portal_select_feature`
-- ----------------------------
DROP TABLE IF EXISTS `portal_select_feature`;
CREATE TABLE `portal_select_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT '功能名称',
  `from` varchar(200) DEFAULT NULL COMMENT '功能来源',
  `open` int(1) DEFAULT NULL COMMENT '是否启用',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `portal_id` int(11) DEFAULT NULL COMMENT '门户ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户选择功能表';

-- ----------------------------
-- Records of portal_select_feature
-- ----------------------------
INSERT INTO `portal_select_feature` VALUES ('1', '企业管理课程', '从零学起', '1', null, '2');
INSERT INTO `portal_select_feature` VALUES ('2', '集邮趣谈', '从零学起', '0', null, '2');

-- ----------------------------
-- Table structure for `portal_sfeature_groupmap`
-- ----------------------------
DROP TABLE IF EXISTS `portal_sfeature_groupmap`;
CREATE TABLE `portal_sfeature_groupmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` varchar(200) DEFAULT NULL COMMENT '功能ID',
  `group_id` varchar(200) DEFAULT NULL COMMENT '权限组ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='门户功能信息表';

-- ----------------------------
-- Records of portal_sfeature_groupmap
-- ----------------------------
INSERT INTO `portal_sfeature_groupmap` VALUES ('1', '1', '2');
INSERT INTO `portal_sfeature_groupmap` VALUES ('2', '1', '2');
