/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : admin

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2017-03-24 10:50:13
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员表';

-- ----------------------------
-- Records of adm_admins
-- ----------------------------
INSERT INTO `adm_admins` VALUES ('1', 'admin', '$2y$10$g4EjKti5CoEgzmDFng.5.OhkjFKzY6mX1V8iPyOOKJOoHalkH8.xS', '超级管理员', 'admin@admin.com', '1', 'Cly0JQfWYB6wYtBYdGxyMSaPsWtSx0bacKF47WQMd6JrfeX8CivnawhUvsy3', null, '2017-03-22 05:21:57');
INSERT INTO `adm_admins` VALUES ('12', 'test', 'test123', '测试账号', 'test@q.com', '0', null, '2017-03-23 07:52:17', '2017-03-23 18:38:14');

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
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态   1可用  0禁用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限表（菜单表）';

-- ----------------------------
-- Records of adm_permissions
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of adm_roles
-- ----------------------------

-- ----------------------------
-- Table structure for adm_role_admin
-- ----------------------------
DROP TABLE IF EXISTS `adm_role_admin`;
CREATE TABLE `adm_role_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='管理员角色表';

-- ----------------------------
-- Records of adm_role_admin
-- ----------------------------

-- ----------------------------
-- Table structure for adm_role_permission
-- ----------------------------
DROP TABLE IF EXISTS `adm_role_permission`;
CREATE TABLE `adm_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `permission_id` int(11) NOT NULL COMMENT '权限id',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表';

-- ----------------------------
-- Records of adm_role_permission
-- ----------------------------

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
