/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : admin

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2017-04-05 18:32:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for adm_admins
-- ----------------------------
DROP TABLE IF EXISTS `adm_admins`;
CREATE TABLE `adm_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `nickname` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '昵称',
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态   1可用  0禁用',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员表';

-- ----------------------------
-- Records of adm_admins
-- ----------------------------
INSERT INTO `adm_admins` VALUES ('1', 'admin', '$2y$10$g4EjKti5CoEgzmDFng.5.OhkjFKzY6mX1V8iPyOOKJOoHalkH8.xS', '超级管理员', 'admin@admin.com', '1', 'LPKBDtMlnVIJ5uDbakbk4GUEo1d4v35uMPrDK2trEaVJXEnyH9ldxVDiAafg', null, '2017-04-05 15:20:58');
INSERT INTO `adm_admins` VALUES ('12', 'test', 'test123', '测试账号', 'test@q.com', '1', null, '2017-03-23 07:52:17', '2017-03-24 10:58:02');
INSERT INTO `adm_admins` VALUES ('13', 'content', '$2y$10$k4P0WdkTKFIkywvrMfQHA.r8K79KX9UjyxFQ8pU414ggN8HRnG76S', '内容管理1', '1@q.com', '1', 'nld3xxbOSLElCQBl4wCMldV7doHzy9S5lYJ56QoMYF9G3aAIUgz3AUm3Jt4C', '2017-03-30 17:49:52', '2017-04-05 15:25:55');

-- ----------------------------
-- Table structure for adm_permissions
-- ----------------------------
DROP TABLE IF EXISTS `adm_permissions`;
CREATE TABLE `adm_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL COMMENT '权限资源路径',
  `title` varchar(50) NOT NULL COMMENT '权限标题',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '权限父级id',
  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否在菜单栏展示',
  `sort` int(11) DEFAULT '0' COMMENT '排序  倒序排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态   1可用  0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='权限表（菜单表）';

-- ----------------------------
-- Records of adm_permissions
-- ----------------------------
INSERT INTO `adm_permissions` VALUES ('1', 'adm/index', '管理员列表', '2', '1', '3', '1', '2017-03-28 17:00:31', '2017-03-29 12:07:08');
INSERT INTO `adm_permissions` VALUES ('2', 'adm', '管理员管理', '0', '1', '0', '1', '2017-03-28 17:02:20', '2017-03-30 10:56:45');
INSERT INTO `adm_permissions` VALUES ('3', 'permission/index', '权限管理', '2', '1', '1', '1', '2017-03-29 11:45:03', '2017-03-30 10:57:47');
INSERT INTO `adm_permissions` VALUES ('4', 'role/index', '角色管理', '2', '1', '2', '1', '2017-03-29 11:50:45', '2017-03-29 16:51:54');
INSERT INTO `adm_permissions` VALUES ('9', 'article', '文章管理', '0', '1', '1', '1', '2017-03-29 16:58:29', '2017-03-29 17:03:33');
INSERT INTO `adm_permissions` VALUES ('10', 'article/index', '文章列表', '9', '1', '1', '1', '2017-03-29 16:59:54', '2017-03-29 17:00:08');
INSERT INTO `adm_permissions` VALUES ('11', 'user', '用户管理', '0', '1', '0', '1', '2017-03-29 17:02:49', '2017-03-29 17:02:49');

-- ----------------------------
-- Table structure for adm_roles
-- ----------------------------
DROP TABLE IF EXISTS `adm_roles`;
CREATE TABLE `adm_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态  1可用  0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of adm_roles
-- ----------------------------
INSERT INTO `adm_roles` VALUES ('1', '超级管理员', '1', '2017-03-27 14:54:57', '2017-03-27 14:54:57');
INSERT INTO `adm_roles` VALUES ('22', '内容管理员', '1', '2017-03-30 11:20:28', '2017-03-30 11:20:28');

-- ----------------------------
-- Table structure for adm_role_admin
-- ----------------------------
DROP TABLE IF EXISTS `adm_role_admin`;
CREATE TABLE `adm_role_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

-- ----------------------------
-- Records of adm_role_admin
-- ----------------------------
INSERT INTO `adm_role_admin` VALUES ('8', '22', '13', '2017-03-30 17:50:22');
INSERT INTO `adm_role_admin` VALUES ('9', '1', '12', '2017-03-31 11:00:41');

-- ----------------------------
-- Table structure for adm_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `adm_role_permission`;
CREATE TABLE `adm_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `permission_id` int(11) NOT NULL COMMENT '权限id',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表';

-- ----------------------------
-- Records of adm_role_permission
-- ----------------------------
INSERT INTO `adm_role_permission` VALUES ('8', '22', '9', '2017-03-31 14:32:58');
INSERT INTO `adm_role_permission` VALUES ('9', '22', '10', '2017-03-31 14:32:58');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_username_index` (`username`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
