/*
Navicat MySQL Data Transfer

Source Server         : 192.168.56.101
Source Server Version : 50173
Source Host           : 192.168.56.101:3306
Source Database       : teachingmanagement

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2014-06-10 12:45:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `test`
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `html` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES ('1', '??');
INSERT INTO `test` VALUES ('2', null);
INSERT INTO `test` VALUES ('3', '111111111');
INSERT INTO `test` VALUES ('4', '&lt;div class=&quot;container-fluid&quot;&gt;\n	&lt;div class=&quot;row-fluid&quot;&gt;\n		&lt;div class=&quot;span12&quot;&gt;\n			&lt;ul&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n			&lt;/ul&gt;\n		&lt;/div&gt;\n	&lt;/div&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('5', '&lt;div class=&quot;container-fluid&quot;&gt;\n	&lt;div class=&quot;row-fluid&quot;&gt;\n		&lt;div class=&quot;span12&quot;&gt;\n			&lt;ul&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n				&lt;li&gt;\n					????\n				&lt;/li&gt;\n			&lt;/ul&gt;\n		&lt;/div&gt;\n	&lt;/div&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('6', '&lt;div class=&quot;container-fluid&quot;&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('7', '&lt;div class=&quot;container-fluid&quot;&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('8', '&lt;div class=&quot;container-fluid&quot;&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('9', '&lt;div class=&quot;container-fluid&quot;&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('10', '&lt;div class=&quot;container-fluid&quot;&gt;\n&lt;/div&gt;');
INSERT INTO `test` VALUES ('11', '&lt;div class=&quot;container-fluid&quot;&gt;\n	&lt;div class=&quot;container-fluid&quot;&gt;\n		&lt;div class=&quot;row-fluid&quot;&gt;\n			&lt;div class=&quot;span2&quot;&gt;\n				&lt;p&gt;\n					留言板\n				&lt;/p&gt;\n				&lt;ul class=&quot;inline&quot;&gt;\n					&lt;li&gt;\n						新闻资讯\n					&lt;/li&gt;\n					&lt;li&gt;\n						体育竞技\n					&lt;/li&gt;\n					&lt;li&gt;\n						娱乐八卦\n					&lt;/li&gt;\n					&lt;li&gt;\n						前沿科技\n					&lt;/li&gt;\n					&lt;li&gt;\n						环球财经\n					&lt;/li&gt;\n					&lt;li&gt;\n						天气预报\n					&lt;/li&gt;\n					&lt;li&gt;\n						房产家居\n					&lt;/li&gt;\n					&lt;li&gt;\n						网络游戏\n					&lt;/li&gt;\n				&lt;/ul&gt;\n				&lt;ol class=&quot;inline&quot;&gt;\n					&lt;li&gt;\n						新闻资讯\n					&lt;/li&gt;\n					&lt;li&gt;\n						体育竞技\n					&lt;/li&gt;\n					&lt;li&gt;\n						娱乐八卦\n					&lt;/li&gt;\n					&lt;li&gt;\n						前沿科技\n					&lt;/li&gt;\n					&lt;li&gt;\n						环球财经\n					&lt;/li&gt;\n					&lt;li&gt;\n						天气预报\n					&lt;/li&gt;\n					&lt;li&gt;\n						房产家居\n					&lt;/li&gt;\n					&lt;li&gt;\n						网络游戏\n					');
INSERT INTO `test` VALUES ('12', '\n			    	\n                &lt;div class=&quot;container-fluid&quot;&gt;\n				\n			    	\n                &lt;div class=&quot;container-fluid&quot;&gt;\n								&lt;/div&gt;\n\n		&lt;div class=&quot;lyrow ui-draggable&quot; style=&quot;display: block; &quot;&gt; &lt;a href=&quot;#close&quot; class=&quot;remove label label-important&quot;&gt;&lt;i class=&quot;icon-remove icon-white&quot;&gt;&lt;/i&gt;删除&lt;/a&gt; &lt;span class=&quot;drag label&quot;&gt;&lt;i class=&quot;icon-move&quot;&gt;&lt;/i&gt;拖动&lt;/span&gt;\n              &lt;div class=&quot;preview&quot;&gt;\n                &lt;input value=&quot;6 6&quot; type=&quot;text&quot;&gt;\n              &lt;/div&gt;\n              &lt;div class=&quot;view&quot;&gt;\n                &lt;div class=&quot;row-fluid clearfix&quot;&gt;\n                  &lt;div class=&quot;span6 column ui-sortable&quot;&gt;&lt;div class=&quot;box box-element ui-draggable&quot; style=&quot;display: block; &quot;&gt; &lt;a href=&quot;#close&quot; class=&quot;remove label label-important&quot;&gt;&lt;i class=&quot;icon-remove icon-white&quot;&gt;&lt;/i&gt;删除&lt;/a&gt; &lt;span class=&quot;drag label&quot;&gt;&lt;i class=&quot;icon-move&quot;&gt;&lt;/i&gt;拖动&lt;/span&gt;\n              &lt;span class=&quot;configuration&quot;&gt;&lt;button type=&quot;button&quot; class=&quot;btn btn-mini&quot; data-target=&quot;#editorModal&quot; role=&quot;button&quot; data-toggle=&quot;modal&quot;&gt;编辑&lt;/button&gt;&lt;/span&gt;\n              &lt;div class=&quot;preview&quot;&gt;院校简介&lt;/div&gt;\n              &lt;div class=&quot;view&quot;&gt;\n                &lt;h2 contenteditable=&quot;true&quot;&gt;北京101中学&lt;/h2&gt;\n                &lt;p contenteditable=&quot;true&quot;&gt;位于北京海淀区，是一所重点中学.&lt;/p&gt;\n                \n              &lt;/div&gt;\n            &lt;/div&gt;&lt;/div&gt;\n                  &lt;div class=&quot;span6 column ui-sortable&quot;&gt;&lt;/div&gt;\n                &lt;/div&gt;\n              &lt;/div&gt;\n            &lt;/div&gt;				&lt;/div&gt;\n\n		');
INSERT INTO `test` VALUES ('13', null);
INSERT INTO `test` VALUES ('14', null);
INSERT INTO `test` VALUES ('15', null);
INSERT INTO `test` VALUES ('16', null);
INSERT INTO `test` VALUES ('17', null);
INSERT INTO `test` VALUES ('18', null);
INSERT INTO `test` VALUES ('19', null);
INSERT INTO `test` VALUES ('20', null);
INSERT INTO `test` VALUES ('21', null);
INSERT INTO `test` VALUES ('22', null);
INSERT INTO `test` VALUES ('23', null);
INSERT INTO `test` VALUES ('24', null);
INSERT INTO `test` VALUES ('25', null);
INSERT INTO `test` VALUES ('26', null);
INSERT INTO `test` VALUES ('27', null);
INSERT INTO `test` VALUES ('28', null);
INSERT INTO `test` VALUES ('29', null);
INSERT INTO `test` VALUES ('30', null);
INSERT INTO `test` VALUES ('31', null);
INSERT INTO `test` VALUES ('32', null);
INSERT INTO `test` VALUES ('33', null);
INSERT INTO `test` VALUES ('34', null);
INSERT INTO `test` VALUES ('35', null);
INSERT INTO `test` VALUES ('36', null);
INSERT INTO `test` VALUES ('37', null);
INSERT INTO `test` VALUES ('38', null);
INSERT INTO `test` VALUES ('39', null);
INSERT INTO `test` VALUES ('40', null);
INSERT INTO `test` VALUES ('41', null);
INSERT INTO `test` VALUES ('42', null);
INSERT INTO `test` VALUES ('43', null);
INSERT INTO `test` VALUES ('44', null);
INSERT INTO `test` VALUES ('45', null);
INSERT INTO `test` VALUES ('46', null);
INSERT INTO `test` VALUES ('47', null);
INSERT INTO `test` VALUES ('48', null);
INSERT INTO `test` VALUES ('49', null);
INSERT INTO `test` VALUES ('50', null);
INSERT INTO `test` VALUES ('51', null);
INSERT INTO `test` VALUES ('52', null);
INSERT INTO `test` VALUES ('53', null);
INSERT INTO `test` VALUES ('54', null);
INSERT INTO `test` VALUES ('55', null);
INSERT INTO `test` VALUES ('56', null);
INSERT INTO `test` VALUES ('57', null);
INSERT INTO `test` VALUES ('58', null);
INSERT INTO `test` VALUES ('59', null);
INSERT INTO `test` VALUES ('60', null);
INSERT INTO `test` VALUES ('61', null);
INSERT INTO `test` VALUES ('62', null);
INSERT INTO `test` VALUES ('63', null);
INSERT INTO `test` VALUES ('64', null);
INSERT INTO `test` VALUES ('65', null);
INSERT INTO `test` VALUES ('66', null);
INSERT INTO `test` VALUES ('67', null);
INSERT INTO `test` VALUES ('68', null);
INSERT INTO `test` VALUES ('69', null);
