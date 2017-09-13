/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : cuoti

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-06-15 15:18:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cuoti_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_auth_group`;
CREATE TABLE `cuoti_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  `desc` varchar(200) DEFAULT '' COMMENT '角色描述',
  `sort` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cuoti_auth_group
-- ----------------------------
INSERT INTO `cuoti_auth_group` VALUES ('35', '管理员', '1', '13,14,15,16,17,18,19,21,22,23,24,25,26,27,28,29,30', '管理员', '2');
INSERT INTO `cuoti_auth_group` VALUES ('36', '超级管理员', '1', '5,11,12,10,6,13,14,15,16,17,18,19,21,22,23,24,39,25,26,27,28,30', '超级管理员', '1');
INSERT INTO `cuoti_auth_group` VALUES ('37', '学生', '1', '25,26,27', '学生', '3');
INSERT INTO `cuoti_auth_group` VALUES ('34', '教师', '1', '22,40,41,25,34,35,44', '教师', '4');

-- ----------------------------
-- Table structure for `cuoti_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_auth_group_access`;
CREATE TABLE `cuoti_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cuoti_auth_group_access
-- ----------------------------
INSERT INTO `cuoti_auth_group_access` VALUES ('1', '36');
INSERT INTO `cuoti_auth_group_access` VALUES ('14', '35');
INSERT INTO `cuoti_auth_group_access` VALUES ('15', '37');
INSERT INTO `cuoti_auth_group_access` VALUES ('16', '36');
INSERT INTO `cuoti_auth_group_access` VALUES ('18', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('19', '35');
INSERT INTO `cuoti_auth_group_access` VALUES ('20', '35');
INSERT INTO `cuoti_auth_group_access` VALUES ('21', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('22', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('22', '36');
INSERT INTO `cuoti_auth_group_access` VALUES ('23', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('24', '37');
INSERT INTO `cuoti_auth_group_access` VALUES ('25', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('26', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('27', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('28', '34');
INSERT INTO `cuoti_auth_group_access` VALUES ('29', '34');

-- ----------------------------
-- Table structure for `cuoti_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_auth_rule`;
CREATE TABLE `cuoti_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` int(8) unsigned NOT NULL DEFAULT '0',
  `index` int(10) unsigned DEFAULT '0' COMMENT '索引',
  `menu` tinyint(1) unsigned DEFAULT '1' COMMENT '是否为菜单',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cuoti_auth_rule
-- ----------------------------
INSERT INTO `cuoti_auth_rule` VALUES ('11', '/admin/menu/menumanage', '菜单管理', '1', '1', '', '5', '3', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('12', '/admin/rizhi/rizhilist', '日志查看', '1', '1', '', '5', '4', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('10', '/admin/users/userlist', '登陆用户', '1', '1', '', '5', '2', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('5', 'Sys/index', '系统管理', '1', '1', '', '0', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('6', '/admin/role/roleManage', '角色管理', '1', '1', '', '5', '1', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('13', '/admin/base/index', '基础档案管理', '1', '1', '', '0', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('14', '/admin/base/baselist', '基础数据管理', '1', '1', '', '13', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('15', '/admin/type/typelist', '类型管理', '1', '1', '', '13', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('16', '/admin/tch/tchlist', '老师管理', '1', '1', '', '13', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('17', '/admin/stu/stulist', '学生管理', '1', '1', '', '13', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('18', '/admin/cou/coulist', '课程管理', '1', '1', '', '13', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('19', '/admin/pay/index', '缴费管理', '1', '0', '', '0', '0', '0');
INSERT INTO `cuoti_auth_rule` VALUES ('21', '/admin/Pay/paylist', '缴费查询', '1', '1', '', '19', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('22', '/admin/rec/index', '上课管理', '1', '1', '', '0', '0', '0');
INSERT INTO `cuoti_auth_rule` VALUES ('23', '/admin/rec/recadd', '添加上课信息', '1', '1', '', '22', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('24', '/admin/rec/reclist', '上课记录', '1', '1', '', '22', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('25', '/admin/error/index', '错题管理', '1', '1', '', '0', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('26', '/admin/error/erroradd', '新增错题', '1', '1', '', '25', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('27', '/admin/error/errorlist', '错题管理', '1', '1', '', '25', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('28', '/admin/tongji/index', '统计查询', '1', '0', '', '0', '0', '0');
INSERT INTO `cuoti_auth_rule` VALUES ('29', '/admin/tongji/stu', '学生错题统计', '1', '1', '', '28', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('30', '/admin/tongji/tch', '教师错题统计', '1', '1', '', '28', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('34', '/admin/error/teaErroradd', '老师新增错题', '1', '1', '', '25', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('35', '/admin/error/teaErrorlist', '老师错题管理', '1', '1', '', '25', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('39', 'delShangke', '删除上课记录', '1', '1', '', '24', '0', '0');
INSERT INTO `cuoti_auth_rule` VALUES ('40', '/admin/rec/teaReclist', '我的上课纪录', '1', '1', '', '22', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('41', '/admin/rec/teaRecadd', '添加上课纪录', '1', '1', '', '22', '0', '1');
INSERT INTO `cuoti_auth_rule` VALUES ('44', '/admin/error/stuTongji', '老师端-学生错题统计', '1', '1', '', '25', '0', '1');

-- ----------------------------
-- Table structure for `cuoti_course_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_course_info`;
CREATE TABLE `cuoti_course_info` (
  `cid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '课程名称',
  `clevel` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '年级id',
  `cprice` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '价钱',
  `cnote` text CHARACTER SET utf8 COMMENT '备注',
  `subject` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_course_info
-- ----------------------------
INSERT INTO `cuoti_course_info` VALUES ('00000000009', '班课', '初三', '100', '备注', '英语');
INSERT INTO `cuoti_course_info` VALUES ('00000000010', '一对一', '初三', '400', '备注怎么没有呢', '数学');
INSERT INTO `cuoti_course_info` VALUES ('00000000011', '班课', '初二', '80', '123', '语文');
INSERT INTO `cuoti_course_info` VALUES ('00000000012', '一对一', '初一', '300', '', '语文');

-- ----------------------------
-- Table structure for `cuoti_errortest_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_errortest_info`;
CREATE TABLE `cuoti_errortest_info` (
  `etid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `etstu` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '学生id',
  `stuid` int(11) DEFAULT NULL,
  `ettime` date DEFAULT NULL COMMENT '错题时间',
  `ettitle` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '错题标题',
  `ettype` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '错题原因id',
  `etteacher` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '解答老师id',
  `teaid` int(11) DEFAULT NULL,
  `etnote` text CHARACTER SET utf8 COMMENT '备注',
  `subject_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `nianji` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tu_ids` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片编号合集',
  PRIMARY KEY (`etid`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_errortest_info
-- ----------------------------
INSERT INTO `cuoti_errortest_info` VALUES ('00000000022', '王樱翰', null, '2017-05-25', 'timu', null, null, null, '123<img src=\"/uploads/20170526\\fd7516e8ead22af4af0996514f92a902.jpg\" alt=\"undefined\">', '语文', '初一', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000023', '王樱翰', null, '2017-05-19', '123', null, null, null, '123', '语文', '初一', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000025', '李泽时', '21', '2017-05-24', '取唱', null, '姬燕燕', '24', '解答', '化学', '初一', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000026', '曲畅', '19', '2017-05-09', '题目', null, '谷群', '22', '你好', '语文', '高一', '63,64');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000040', '曲畅', null, '2017-06-08', '123213123213', null, '张旭', null, '法第三方第三方斯蒂芬稍等', '数学', '初二', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000041', '曲畅', null, '2017-06-08', '个回复该回复过很反感好', null, '姬燕燕', null, '错题选择内容1111', '物理', '初三', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000042', '侯文明', null, '2017-06-10', '111111111', null, '谷群', null, '1111111111', '英语', '初二', '48,49');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000043', '李文畅', null, '2017-06-15', '2313123123', null, '卢庆娜', null, '3213123123123123', '英语', '初二', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000044', '王樱翰', null, '2017-06-08', '三角形', null, '张恒权', null, '<img src=\"http://cuoti.juyingschool.com/static/plugins/layui/images/face/52.gif\" alt=\"[ok]\"><img src=\"http://cuoti.juyingschool.com/static/plugins/layui/images/face/50.gif\" alt=\"[熊猫]\">技巧掌握不熟练。', '数学', '初二', null);
INSERT INTO `cuoti_errortest_info` VALUES ('00000000045', '李文畅', null, '2017-06-27', '范德萨发第三方凡事都', null, '卢庆娜', null, '我是内容部分', '化学', '初二', '2,3,4,5,6');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000046', '李文畅', null, '2017-06-08', '颠三倒四打底衫', null, '谷群', null, '我是内容部分', '物理', '初二', '7,8,9');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000047', '李文畅', null, '2017-06-15', '11231312313', null, '谷群', null, '2131231231233', '数学', '初二', '44');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000048', '李文畅', null, '2017-06-15', '12122313123', null, '张吉雯', null, '测试使用111', '物理', '初二', '36,37,38,42,47');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000050', '学生（演示）', '39', '2017-06-15', '你好吗呵呵呵呵', null, '张吉雯', '25', '呵呵很好啊11', '语文', '初一', '59');
INSERT INTO `cuoti_errortest_info` VALUES ('00000000051', '曲畅', '19', '2017-06-28', '凡事都凡事都发生的', null, '张吉雯', '25', '测试内容123。', '语文', '初三', '58,60');

-- ----------------------------
-- Table structure for `cuoti_logs`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_logs`;
CREATE TABLE `cuoti_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login_people` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `login_time` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `login_ip` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `login_auth` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_logs
-- ----------------------------
INSERT INTO `cuoti_logs` VALUES ('1', null, '1495787810', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('2', null, '1495789545', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('3', null, '1495847685', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('4', null, '1495847849', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('5', null, '1495847866', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('6', null, '1495849087', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('7', '张吉雯', '1495849180', '1885794707', '教师');
INSERT INTO `cuoti_logs` VALUES ('8', null, '1495851956', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('9', null, '1495852019', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('10', null, '1495852957', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('11', null, '1495854877', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('12', null, '1495854939', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('13', null, '1495855089', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('14', null, '1495861934', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('15', null, '1495862122', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('16', null, '1495862171', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('17', null, '1495863833', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('18', null, '1495866268', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('19', null, '1495870486', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('20', '张吉雯', '1495870644', '1885794707', '教师');
INSERT INTO `cuoti_logs` VALUES ('21', null, '1495870682', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('22', null, '1495873029', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('23', null, '1496210905', '1852703688', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('24', null, '1496211001', '3721394795', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('25', null, '1496378517', '2073528932', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('26', null, '1496458297', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('27', null, '1496459191', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('28', '张吉雯', '1496459616', '1885794707', '教师');
INSERT INTO `cuoti_logs` VALUES ('29', '', '1496468482', '1885794707', '学生');
INSERT INTO `cuoti_logs` VALUES ('30', null, '1496468673', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('31', null, '1496473756', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('32', null, '1496473860', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('33', null, '1496474287', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('34', null, '1496475849', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('35', null, '1496475871', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('36', null, '1496476162', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('37', null, '1496476298', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('38', null, '1496633094', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('39', null, '1496643078', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('40', null, '1496645975', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('41', null, '1496646747', '1885794707', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('42', null, '1496713200', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('43', null, '1496733771', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('44', null, '1496800658', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('45', '演示', '1496885425', '1865002256', '学生');
INSERT INTO `cuoti_logs` VALUES ('46', null, '1496885942', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('47', null, '1496901934', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('48', null, '1496906140', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('49', null, '1496906343', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('50', null, '1496907163', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('51', null, '1496911638', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('52', null, '1496978295', '1895851934', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('53', null, '1497060488', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('54', null, '1497061974', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('55', null, '1497063830', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('56', '张吉雯', '1497063851', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('57', null, '1497064606', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('58', null, '1497064677', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('59', 'andrewjm', '1497319339', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('60', 'andrewjm', '1497403753', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('61', 'andrewjm', '1497405003', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('62', 'andrewjm', '1497405091', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('63', 'andrewjm', '1497406218', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('64', 'andrewjm', '1497415403', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('65', '张吉雯', '1497415474', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('66', 'andrewjm', '1497417168', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('67', 'andrewjm', '1497417185', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('68', '张吉雯', '1497417195', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('69', 'andrewjm', '1497425976', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('70', 'andrewjm', '1497426006', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('71', '张吉雯', '1497426026', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('72', 'andrewjm', '1497427581', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('73', 'andrewjm', '1497427942', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('74', '张吉雯', '1497428097', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('75', 'andrewjm', '1497429658', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('76', '张吉雯', '1497429669', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('77', 'andrewjm', '1497433570', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('78', 'andrewjm', '1497490064', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('79', 'andrewjm', '1497490486', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('80', 'andrewjm', '1497492007', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('81', 'andrewjm', '1497500860', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('82', 'andrewjm', '1497501029', '2130706433', '超级管理员');
INSERT INTO `cuoti_logs` VALUES ('83', '谷群', '1497501048', '2130706433', '教师');
INSERT INTO `cuoti_logs` VALUES ('84', 'andrewjm', '1497509282', '2130706433', '超级管理员');

-- ----------------------------
-- Table structure for `cuoti_parent_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_parent_info`;
CREATE TABLE `cuoti_parent_info` (
  `pid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pname` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '家长姓名',
  `pphone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pnote` text CHARACTER SET utf8,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_parent_info
-- ----------------------------

-- ----------------------------
-- Table structure for `cuoti_pay_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_pay_info`;
CREATE TABLE `cuoti_pay_info` (
  `payid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `paystu` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '学生id',
  `stuid` int(11) DEFAULT NULL,
  `paytime` date DEFAULT NULL COMMENT '交费时间',
  `payamount` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '金额',
  `payee` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '收款人id',
  `payrecorder` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '添加纪录的人',
  `payclock` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加纪录的时间',
  `paynote` text CHARACTER SET utf8 COMMENT '备注',
  `payyu` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`payid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_pay_info
-- ----------------------------
INSERT INTO `cuoti_pay_info` VALUES ('00000000013', '学生一', null, '2017-05-30', '8000', '窦老师', '记录人', '2017-05-22 16:09:25', '备注', '6200');
INSERT INTO `cuoti_pay_info` VALUES ('00000000014', '学生三', null, '2017-05-24', '8000', '窦老师', '记录人二', '2017-05-19 14:52:26', '备注', '6000');
INSERT INTO `cuoti_pay_info` VALUES ('00000000017', '学生二', null, '2017-05-25', '800', '窦老师', '记录人', '2017-05-23 16:25:47', '备注', '-90');
INSERT INTO `cuoti_pay_info` VALUES ('00000000018', '学生一', null, '2017-05-22', '1212', '窦老师', '11111', '2017-05-22 17:41:01', '<p style=\"text-align: left;\">你好吗？</p>', '1212');
INSERT INTO `cuoti_pay_info` VALUES ('00000000019', '学生二', null, '2017-05-23', '500', '窦老师', '111', '2017-05-23 16:25:47', '12321313', '-90');
INSERT INTO `cuoti_pay_info` VALUES ('00000000020', '王樱翰', '17', '2017-05-23', '123', '窦老师', '123', '2017-05-25 11:35:14', '123', '-237');
INSERT INTO `cuoti_pay_info` VALUES ('00000000021', '曲畅', null, '2017-05-08', '1000', '窦老师', 'liu', '2017-05-25 11:40:25', '', '400');

-- ----------------------------
-- Table structure for `cuoti_record_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_record_info`;
CREATE TABLE `cuoti_record_info` (
  `rid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `rstu` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '学生id',
  `stuid` int(11) DEFAULT NULL,
  `rteacher` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '考试id',
  `rtid` int(11) DEFAULT NULL,
  `lessontime` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '上课时间',
  `rsubject` varchar(50) DEFAULT NULL COMMENT '科目id',
  `rcid` varchar(50) DEFAULT NULL COMMENT '课程id',
  `rclass` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '课节',
  `rprice` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '费用',
  `rincome` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '实收',
  `rdiscount` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '折扣',
  `rnote` text CHARACTER SET utf8 COMMENT '备注',
  `rtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加纪录时间',
  `recorder` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '添加纪录的人',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_record_info
-- ----------------------------
INSERT INTO `cuoti_record_info` VALUES ('00000000011', '学生一', null, '教师五', null, '2017-05-24 12:02:39', null, '9', '9', '1500', '1000', '67%', '备注', '2017-05-15 12:05:32', '记录人');
INSERT INTO `cuoti_record_info` VALUES ('00000000012', '学生三', null, '教师五', null, '2017-05-25 12:04:24', null, '9', '8', '1500', '2000', '133%', '备注', '2017-05-15 12:07:19', '记录人');
INSERT INTO `cuoti_record_info` VALUES ('00000000023', '学生一', null, '教师五', null, '2017-05-24 16:06:30', null, '9', '9', '1500', '800', '53%', '', '2017-05-22 16:09:25', '记录人');
INSERT INTO `cuoti_record_info` VALUES ('00000000024', '学生二', null, '张恒权', null, '2017-05-23 16:19:48', null, '9', '1', '100', '90', '90%', '', '2017-05-23 16:20:08', '111');
INSERT INTO `cuoti_record_info` VALUES ('00000000025', '学生二', null, '张恒权', null, '2017-05-23 16:25:40', null, '10', '2', '400', '800', '200%', '', '2017-05-23 16:25:47', '123');
INSERT INTO `cuoti_record_info` VALUES ('00000000027', '李文畅', '18', '张恒权', null, '2017-05-27 11:11:59', null, '9', '123', '100', '80', '80%', '', '2017-05-25 11:16:30', '123');
INSERT INTO `cuoti_record_info` VALUES ('00000000029', '王樱翰', null, '张旭', null, '2017-05-02 11:35:29', null, '9', '2', '100', '0', '0%', '', '2017-05-25 11:35:14', 'liu');
INSERT INTO `cuoti_record_info` VALUES ('00000000030', '曲畅', null, '谷群', null, '2017-05-01 11:39:15', null, '12', '2', '600', '600', '100%', '121221', '2017-05-25 11:40:25', 'liu');
INSERT INTO `cuoti_record_info` VALUES ('00000000034', '王樱翰', '17', '姬燕燕', '24', '2017-05-31 17:13:55', null, '9', '9', '100', '70', '70%', '', '2017-05-26 17:16:49', '123');
INSERT INTO `cuoti_record_info` VALUES ('00000000035', '李泽时', '21', '姬燕燕', '24', '2017-05-31 17:14:53', null, '9', '8', '100', '100', '100%', '123', '2017-05-26 17:18:01', '456');

-- ----------------------------
-- Table structure for `cuoti_stu_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_stu_info`;
CREATE TABLE `cuoti_stu_info` (
  `stuid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `stuname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `stusex` varchar(10) CHARACTER SET utf8 DEFAULT '0',
  `stubirth` date DEFAULT NULL,
  `stustate` varchar(50) CHARACTER SET utf8 DEFAULT '0',
  `stuphone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stuaddress` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `stuschool` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `stugrade` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stuclass` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stuparent` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `relation` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stufrom` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '招生渠道id',
  `balance` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '余额',
  `stunote` text CHARACTER SET utf8 COMMENT '备注',
  PRIMARY KEY (`stuid`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_stu_info
-- ----------------------------
INSERT INTO `cuoti_stu_info` VALUES ('00000000017', '王樱翰', '男', '2005-05-05', '0', '53627549', '邮政街', '萧红中学', '2015级', null, null, null, '校口招生', null, '5+3 &nbsp;数学、语文、英语');
INSERT INTO `cuoti_stu_info` VALUES ('00000000018', '李文畅', '女', '2004-05-01', '0', '15210387161', '邮政街', '萧红中学', '2014级', null, null, null, '校口招生', null, '<br>');
INSERT INTO `cuoti_stu_info` VALUES ('00000000019', '曲畅', '女', '2007-05-23', '0', '13796099387', '民益街和海城街交叉口', '团结小学', '2014级', null, null, null, '校口招生', null, '5+3 数学、语文、英语');
INSERT INTO `cuoti_stu_info` VALUES ('00000000020', '侯文明', '男', '2017-05-23', '0', '15245126568', '邮政街', '萧红中学', '2015级', null, null, null, '校口招生', null, '5+3 &nbsp;数学、语文、英语');
INSERT INTO `cuoti_stu_info` VALUES ('00000000021', '李泽时', '男', '2017-05-23', '0', '13212811199', '邮政街', '萧红中学', '2015级', null, null, null, '校口招生', null, '5+3 &nbsp;数学、语文、英语');
INSERT INTO `cuoti_stu_info` VALUES ('00000000022', '潘世琦', '男', '2005-06-12', '0', '18346261677', '南岗区海关街81号2单元402', '萧红中学', '2016级', null, null, null, '校口招生', null, '5+3 &nbsp;数学、语文、英语');
INSERT INTO `cuoti_stu_info` VALUES ('00000000023', '刘璐畅', '女', '2017-05-23', '0', '13946004269', '邮政街', '萧红中学', '2016级', null, null, null, '校口招生', null, '托班');
INSERT INTO `cuoti_stu_info` VALUES ('00000000024', '李靖泽', '女', '2017-05-23', '0', '13613676051', '邮政街', '萧红中学', '2016级', null, null, null, '校口招生', null, '托班');
INSERT INTO `cuoti_stu_info` VALUES ('00000000025', '常菲', '女', '2017-05-23', '0', '18686815588', '邮政街', '萧红中学', '2016级', null, null, null, '校口招生', null, '托班');
INSERT INTO `cuoti_stu_info` VALUES ('00000000026', '孟鑫', '女', '2017-05-23', '0', '18545103539', '邮政街', '萧红中学', '2015级', null, null, null, '校口招生', null, '托班（天）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000027', '王雨浓', '女', '2017-05-23', '0', '13895784444', '邮政街', '萧红中学', '2016级', null, null, null, '校口招生', null, '托班（天）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000028', '张育恺', '男', '2005-05-23', '0', '13945057755', '邮政街', '萧红中学', '2016级', null, null, null, '校口招生', null, '班课（语文）11');
INSERT INTO `cuoti_stu_info` VALUES ('00000000029', '孟庆涵', '男', '2001-05-23', '0', '13836087287', '邮政街', '哈73中', '2015级', null, null, null, '校口招生', null, '一对一 （数学、物理、化学、生物）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000030', '代洺嘉', '男', '2003-05-23', '0', '13903636991', '邮政街', '团结小学', '2013级', null, null, null, '校口招生', null, '班课（外语）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000031', '王丽锦', '女', '2003-05-23', '0', '13804608406', '邮政街', '工大附中', '2014级', null, null, null, '校口招生', null, '班课（物理、化学）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000032', '王艺霏', '女', '2003-05-23', '0', '13845152451', '邮政街', '萧红中学', '2014级', null, null, null, '校口招生', null, '一对一（物理）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000033', '王樱翰', '男', '2004-03-25', '0', '13613648578', '道外太古12道街正大小区', '萧红中学', '2015级', null, null, null, '校口招生', null, '5+3 （数学、语文、英语）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000034', '赵禹翔', '男', '2005-05-23', '0', '15244601957', '邮政街', '156中学', '2016级', null, null, null, '校口招生', null, '一对一（语文）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000035', '张帅', '男', '2002-05-23', '0', '15045167004', '邮政街', '永源中学', '2013级', null, null, null, '校口招生', null, '<p>一对一（数学、语文、英语、物理、化学、生物）</p><p>仲伟国 18746465333</p>');
INSERT INTO `cuoti_stu_info` VALUES ('00000000036', '裴轩玮', '男', '2004-05-23', '0', '18004515757', '邮政街', '萧红中学', '2015级', null, null, null, '校口招生', null, '托班');
INSERT INTO `cuoti_stu_info` VALUES ('00000000037', '于泽洋', '男', '2017-05-23', '0', '11111', '邮政街', '萧红中学', '2013级', null, null, null, '校口招生', null, '班课（数学、物理）');
INSERT INTO `cuoti_stu_info` VALUES ('00000000039', '学生（演示）', '女', '2005-06-03', '0', '13206552833', '西大直街19号海韵酒店217室', '萧红中学', '2015级', null, null, null, '校口招生', null, '<p><img src=\"http://www.hljtuanke.com/bdimages/upload1/20160622/1466575434498222.jpg\" title=\"1459994207301963.jpg\"></p>');

-- ----------------------------
-- Table structure for `cuoti_teacher_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_teacher_info`;
CREATE TABLE `cuoti_teacher_info` (
  `tid` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tsex` varchar(20) CHARACTER SET utf8 DEFAULT '0',
  `tbirth` date DEFAULT NULL,
  `tphone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tidcard` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `tnation` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '民族',
  `taddress` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `teducation` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '学历状态',
  `tstate` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '状态 转正 实习',
  `tdepartment` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '部门',
  `position` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '职位',
  `entrytime` date DEFAULT NULL,
  `formaltime` date DEFAULT NULL COMMENT '转正时间',
  `salary` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '基本工资',
  `ratio` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '工资系数',
  `college` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '毕业院校',
  `major` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '专业',
  `residence` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '户口性质',
  `contact` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '紧急联系人',
  `cphone` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '紧急联系人电话',
  `crelation` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '紧急联系人关系id',
  `tnote` text CHARACTER SET utf8 COMMENT '备注',
  `auth` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `passwd` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `sort` int(10) unsigned DEFAULT '0' COMMENT '排序',
  `is_sign` tinyint(1) unsigned DEFAULT '0' COMMENT '是否有登陆权限',
  `kemu` varchar(20) CHARACTER SET utf8 DEFAULT '' COMMENT '科目',
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_teacher_info
-- ----------------------------
INSERT INTO `cuoti_teacher_info` VALUES ('00000000020', '张恒权', '男', '1988-06-05', '13633662341', '230125198806050739', '汉族', '邮政街321号', '本科', '正式', '部门1', '职位1', '2014-01-01', null, '2000', '1.0', '衡水学院', '数学', '性质1', '萨达', '13304509639', '其他亲属', '他人很好听<img src=\"http://cuoti.bjsyedu.com/static/plugins/layui/images/face/2.gif\" alt=\"[哈哈]\">', '34', '111111', '8', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000021', '卢庆娜', '女', '1995-01-09', '18846195279', '231026199501192943', '汉族', '哈尔滨商业大学', '本科', '正式', '部门1', '职位1', '2017-01-06', null, '2000', '1.0', '哈尔滨商业大学', '数学与应用数学', '性质1', '卢春江', '18846195279', '父亲', '<br>', '34', '111111', '5', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000022', '谷群', '女', '2017-05-23', '18249098091', '230802197809010926', '汉族', '哈尔滨', '本科', '正式', '部门1', '职位1', '2017-02-14', null, '2000', '1.0', '东北农业大学', '园林设计', '性质1', '李国栋', '15045686475', '其他亲属', '<p>是是是掬英文化培训学校托管班订餐管理办法</p>', null, null, '2', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000023', '张旭', '女', '2017-05-23', '15045098232', '230621198403291249', '汉族', '', '本科', '正式', '部门1', '职位1', '2016-12-28', null, '', '', '', '', '性质1', '', '', '其他亲属', '', null, null, '1', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000024', '姬燕燕', '女', '1990-04-12', '15764500412', '230103000000000000', '汉族', '西大直街19号', '本科', '离职', '部门1', '职位1', '2016-12-12', null, '2000', '1.0', '哈尔滨商业大学', '化学', '性质1', '123456', '123456', '父亲', '23123213', null, null, '6', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000025', '张吉雯', '女', '1992-04-18', '15004652779', '230103199204183629', '汉族', '南岗区汉广街', '本科', '正式', '部门1', '职位1', '2017-04-20', null, '', '', '', '', '性质1', '', '', '母亲', '', null, null, '1', '1', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000027', '测试1', '男', '2017-06-10', '13352516135', '230230198502140010', '其他', '21312312', '本科', '正式', null, null, '2017-06-10', null, null, null, '哈尔滨英语学校', '英语', null, null, null, null, '', null, null, '9', '0', '语文');
INSERT INTO `cuoti_teacher_info` VALUES ('00000000028', '测试22', '女', '2017-06-15', '13352516138', '230230198502140010', '汉族', '哈尔滨市', '本科', '正式', null, null, '2017-06-14', null, null, null, '大连外国语大学', '英语', null, null, null, null, '', null, null, '8', '0', '语文');

-- ----------------------------
-- Table structure for `cuoti_tu`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_tu`;
CREATE TABLE `cuoti_tu` (
  `tu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `tu_name` varchar(200) DEFAULT NULL COMMENT '图片名称',
  `tu_type` varchar(50) DEFAULT NULL COMMENT '图片类型',
  `tu_size` int(10) DEFAULT NULL COMMENT '图片大小',
  `tu_url` varchar(200) DEFAULT NULL COMMENT '图片地址',
  `tu_user` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '隶属于用户',
  PRIMARY KEY (`tu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_tu
-- ----------------------------
INSERT INTO `cuoti_tu` VALUES ('7', '11.jpg', 'image/jpeg', '34739', '/uploads/20170608\\429fcfb23f9752b2261c68d144202134.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('8', '22.jpg', 'image/jpeg', '56613', '/uploads/20170608\\429fcfb23f9752b2261c68d144202134.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('9', '33.jpg', 'image/jpeg', '54026', '/uploads/20170608\\7ffe981addc42a28b3fddc963478366d.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('10', '22.jpg', 'image/jpeg', '56613', '/uploads/20170610\\67b2178486fdae53581832534b0e41cd.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('11', '11.jpg', 'image/jpeg', '34739', '/uploads/20170610\\67efad30ce1a1e92ba9e3f50a95edb78.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('12', '33.jpg', 'image/jpeg', '54026', '/uploads/20170610\\968146480def7c259e6431fec3032965.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('13', '??.jpg', 'image/jpeg', '192685', '/uploads/20170610\\14b034abd7951be335639a2222c21e1f.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('14', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\ac50321a0ddec95eccc2e369a48cc8e7.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('15', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\0c3f1e74d224a341f6b5aa8853bd19d5.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('16', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\b2c430b968db2c174b5a3b492bed2532.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('17', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\f50919b95bb6e16ed464b6d24d6bb488.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('18', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\7169dfe05c5bc840bb80cfba469ab331.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('19', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\438cb41cd83b3f3fa2de276cd7b57d05.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('20', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\5f6bb79bb298bddc04e5c4fb93e641bd.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('21', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\d4003d9664ac08c1bd01977d9d72e8cd.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('22', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\96cf9a1b404c08c3fe6f5341a5342ba2.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('23', 'login_1.gif', 'image/gif', '17350', '/uploads/20170614\\d2e05144e5aaf7a8db96477b14289f3f.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('24', 'login_1.gif', 'image/gif', '17350', '/uploads/20170614\\f36eedd3aa0a927f4ce04d6ee785575c.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('25', 'default_2.gif', 'image/gif', '212', '/uploads/20170614\\893cd71a738aa88a7d1a3d0fcf545445.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('26', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\bfb47086548bb4a3dc7d5f0248b58b57.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('27', 'login_1.gif', 'image/gif', '17350', '/uploads/20170614\\4047bfe191d247aa06ff9214d9dd7e3f.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('28', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\b8675a64418131cbeb490efcd4503b57.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('29', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\9ceb3252c892b063f2d10d5e2e15202f.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('30', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\433b054646e49a50c96189d653a43626.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('31', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\5b8dc489a836a1fca9a247369291ec30.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('32', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\4ecfe8d87e7bc418ca97a78ab8f7c4cc.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('33', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\e43a4b90b9ab2d310db359ce8fa0a7fd.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('34', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\5b1ba231850fbadaae61e1a7390dfb3a.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('35', 'bg.jpg', 'image/jpeg', '37694', '/uploads/20170614\\ba57f67fb82814683e4df08d3bc4cac2.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('36', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\d44ce1f0f237b48d997a35bee0d8ef97.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('37', 'default_2.gif', 'image/gif', '212', '/uploads/20170614\\8b6a48bb0c2e3efb5420c920bea5339a.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('38', 'default_3.gif', 'image/gif', '194', '/uploads/20170614\\e10a8fe90d1723d6c4cb64246bedb61e.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('39', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\48d3acb730860574c0c0fd90268e4cf2.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('40', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\9a29de6acab53852f66aabd75642b36d.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('41', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\f1c3be7c1d632814663e664589d6d6a3.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('42', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\8a02167285f8cb65b084435c536af545.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('43', '???-1 ??.jpg', 'image/jpeg', '16295', '/uploads/20170614\\9c8203484534df9ce66956b7ff1b24db.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('44', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\cab5675e977f7ce7eabd0d82353b7aaa.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('45', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\94fba89e1fffcf2bebe80e0abcde34a1.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('46', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\20bdb25af48cde072fc0493c512ba15e.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('47', '???-1 ??.jpg', 'image/jpeg', '16295', '/uploads/20170614\\037ab3b44aa29e45f663af9b8ee3bac8.jpg', '1');
INSERT INTO `cuoti_tu` VALUES ('48', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\b5cd534fefb49560c35e299495749659.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('49', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\1af9000b130bed617d96f87b7a210785.gif', '1');
INSERT INTO `cuoti_tu` VALUES ('50', 'bg.jpg', 'image/jpeg', '37694', '/uploads/20170614\\f9ad2beea4fc9704514c2292e2293c13.jpg', '23');
INSERT INTO `cuoti_tu` VALUES ('51', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\b99e1fcd6f4b70d06070267f20ff5e92.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('52', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\374ab184a6c6cf4a85d9689735651f02.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('53', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\f016d0ee02b93ebf9ee4389240f42d8f.jpg', '23');
INSERT INTO `cuoti_tu` VALUES ('54', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\feb72ffc9f3e08ddb2be2b355de90def.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('55', 'default_11.gif', 'image/gif', '49650', '/uploads/20170614\\f8377bd5e7e986c73a3fde07c0dc716c.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('56', 'default_3.gif', 'image/gif', '194', '/uploads/20170614\\8a089717e7fd43cc87c6aff01bf544e6.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('57', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\1fdf2e51e375d0a587ba58d61d9a3f1f.jpg', '23');
INSERT INTO `cuoti_tu` VALUES ('58', 'main.jpg', 'image/jpeg', '37694', '/uploads/20170614\\15dbc950c11dc239a68b60fafa53b079.jpg', '23');
INSERT INTO `cuoti_tu` VALUES ('59', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\c4e01fa10e2794ad602db954444ea3fa.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('60', 'default_1.gif', 'image/gif', '49650', '/uploads/20170614\\5311106a882c96b0b2f3a46243989195.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('61', 'login_2.gif', 'image/gif', '8991', '/uploads/20170614\\c0bde0610da1507d050da204899677ac.gif', '23');
INSERT INTO `cuoti_tu` VALUES ('62', 'login.jpg', 'image/jpeg', '31412', '/uploads/20170614\\b49230e7e41dda2e81c012485e7ac5a6.jpg', '23');
INSERT INTO `cuoti_tu` VALUES ('63', 'bg.jpg', 'image/jpeg', '37694', '/uploads/20170615\\a3d3282658b687a3db3add0406bbdb5a.jpg', '21');
INSERT INTO `cuoti_tu` VALUES ('64', 'default_1.gif', 'image/gif', '49650', '/uploads/20170615\\e9870ba047b01b22d414f5a954d6f5bc.gif', '21');

-- ----------------------------
-- Table structure for `cuoti_type_info`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_type_info`;
CREATE TABLE `cuoti_type_info` (
  `ti_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `type_content` text CHARACTER SET utf8,
  PRIMARY KEY (`ti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_type_info
-- ----------------------------
INSERT INTO `cuoti_type_info` VALUES ('00000000005', '科目', '数学、语文、英语、物理、化学、其他');
INSERT INTO `cuoti_type_info` VALUES ('00000000006', '招生渠道', '<p>校口招生、转介绍、前台接待<br></p>');
INSERT INTO `cuoti_type_info` VALUES ('00000000007', '年级', '<p>2007级、2008级、2009级、2010级、初一<br></p>');
INSERT INTO `cuoti_type_info` VALUES ('00000000008', '收款人', '收款');
INSERT INTO `cuoti_type_info` VALUES ('00000000009', '课程类型', '班课、看护、一对一');
INSERT INTO `cuoti_type_info` VALUES ('00000000010', '学年', '');
INSERT INTO `cuoti_type_info` VALUES ('00000000011', '学校', '<p><br></p>');

-- ----------------------------
-- Table structure for `cuoti_type_val`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_type_val`;
CREATE TABLE `cuoti_type_val` (
  `tv_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `type_val` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `ti_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`tv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_type_val
-- ----------------------------
INSERT INTO `cuoti_type_val` VALUES ('00000000006', '语文', '5');
INSERT INTO `cuoti_type_val` VALUES ('00000000007', '数学', '5');
INSERT INTO `cuoti_type_val` VALUES ('00000000008', '英语', '5');
INSERT INTO `cuoti_type_val` VALUES ('00000000009', '物理', '5');
INSERT INTO `cuoti_type_val` VALUES ('00000000010', '化学', '5');
INSERT INTO `cuoti_type_val` VALUES ('00000000014', '校口招生', '6');
INSERT INTO `cuoti_type_val` VALUES ('00000000015', '转介绍', '6');
INSERT INTO `cuoti_type_val` VALUES ('00000000016', '前台接待', '6');
INSERT INTO `cuoti_type_val` VALUES ('00000000017', '初一', '7');
INSERT INTO `cuoti_type_val` VALUES ('00000000018', '初二', '7');
INSERT INTO `cuoti_type_val` VALUES ('00000000019', '初三', '7');
INSERT INTO `cuoti_type_val` VALUES ('00000000020', '高一', '7');
INSERT INTO `cuoti_type_val` VALUES ('00000000021', '窦老师', '8');
INSERT INTO `cuoti_type_val` VALUES ('00000000022', '刘老师', '8');
INSERT INTO `cuoti_type_val` VALUES ('00000000023', '班课', '9');
INSERT INTO `cuoti_type_val` VALUES ('00000000024', '看护', '9');
INSERT INTO `cuoti_type_val` VALUES ('00000000025', '一对一', '9');
INSERT INTO `cuoti_type_val` VALUES ('00000000026', '高二', '7');
INSERT INTO `cuoti_type_val` VALUES ('00000000028', '', '0');
INSERT INTO `cuoti_type_val` VALUES ('00000000029', '', '0');
INSERT INTO `cuoti_type_val` VALUES ('00000000030', '2013级', '10');
INSERT INTO `cuoti_type_val` VALUES ('00000000031', '2014级', '10');
INSERT INTO `cuoti_type_val` VALUES ('00000000032', '2015级', '10');
INSERT INTO `cuoti_type_val` VALUES ('00000000033', '2016级', '10');
INSERT INTO `cuoti_type_val` VALUES ('00000000034', '2017级', '10');

-- ----------------------------
-- Table structure for `cuoti_user`
-- ----------------------------
DROP TABLE IF EXISTS `cuoti_user`;
CREATE TABLE `cuoti_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(255) CHARACTER SET utf8 NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 NOT NULL,
  `rule_id` int(10) unsigned NOT NULL,
  `lock` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '是否锁定',
  `teacher_id` int(10) unsigned DEFAULT NULL,
  `last_login_time` int(10) DEFAULT NULL,
  `last_login_ip` bigint(20) DEFAULT NULL,
  `teacher_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `login` int(10) unsigned DEFAULT NULL COMMENT '登陆次数',
  `rule_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `nick` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `stus` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cuoti_user
-- ----------------------------
INSERT INTO `cuoti_user` VALUES ('1', '13352516135', '65b84c849e918a97b0a8c4522e503924', '36', '1', '0', '1497509282', '2130706433', '', null, '超级管理员', 'andrewjm', '');
INSERT INTO `cuoti_user` VALUES ('17', '18345486919', '801dc5a898002c35408859adf2ef6fbd', '34', '1', '20', '1495692065', '2074540558', '', null, '教师', '张恒权', '17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,39');
INSERT INTO `cuoti_user` VALUES ('18', '18846195279', '801dc5a898002c35408859adf2ef6fbd', '34', '1', '21', '1495529470', '2074540558', '卢庆娜', null, '教师', '卢庆娜', '17,18,23,28,39');
INSERT INTO `cuoti_user` VALUES ('19', '15004652779', '801dc5a898002c35408859adf2ef6fbd', '35', '1', '0', '1495784862', '29201486', '', null, '管理员', '张吉雯', '');
INSERT INTO `cuoti_user` VALUES ('20', '13009709097', '801dc5a898002c35408859adf2ef6fbd', '35', '1', '0', '1495537977', '1021041865', '', null, '管理员', '窦彦秋', '');
INSERT INTO `cuoti_user` VALUES ('21', '15124522222', '801dc5a898002c35408859adf2ef6fbd', '34', '1', '22', '1497501048', '2130706433', '谷群', null, '教师', '谷群', '17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,39');
INSERT INTO `cuoti_user` VALUES ('23', '13352518888', '801dc5a898002c35408859adf2ef6fbd', '34', '1', '25', '1497429669', '2130706433', '姬燕燕', null, '教师', '张吉雯', '17,19,21,26,39');
INSERT INTO `cuoti_user` VALUES ('24', '13206552833', '801dc5a898002c35408859adf2ef6fbd', '37', '1', '0', '1496885425', '1865002256', null, null, '学生', '演示', '');
INSERT INTO `cuoti_user` VALUES ('28', '13352516138', 'dac93718a565d975f23241ea7b255e50', '34', '1', '23', null, null, null, null, '教师', '张旭', '17,22,27');
