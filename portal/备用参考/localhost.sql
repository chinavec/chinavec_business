-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 01 月 08 日 08:52
-- 服务器版本: 5.5.16
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `chinavec`
--
CREATE DATABASE `chinavec` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chinavec`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `admin_role_id` int(11) NOT NULL,
  `contact` int(50) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `admin_access`
--

CREATE TABLE IF NOT EXISTS `admin_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_role_id` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `admin_role`
--

CREATE TABLE IF NOT EXISTS `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `authen`
--

CREATE TABLE IF NOT EXISTS `authen` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(3) CHARACTER SET utf8 NOT NULL,
  `code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `valid_dt` varchar(10) CHARACTER SET utf8 NOT NULL,
  `porpuse` varchar(200) CHARACTER SET utf8 NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `college`
--

CREATE TABLE IF NOT EXISTS `college` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college_type_id` int(11) DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `picture` varchar(50) CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL,
  `admin_id` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `college_type_id` (`college_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `college`
--

INSERT INTO `college` (`id`, `college_type_id`, `title`, `content`, `picture`, `create_time`, `admin_id`) VALUES
(1, 1, '拍摄教程', 'aaaaa', '1.jpg', 0, 0),
(2, 1, '拍摄教程2', '123456', '2.jpg', 1, 1),
(3, 1, '拍摄教程2', '123456', '2.jpg', 1, 1),
(4, 1, '拍摄教555', '123456', '2.jpg', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `college_type`
--

CREATE TABLE IF NOT EXISTS `college_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `college_type`
--

INSERT INTO `college_type` (`id`, `name`) VALUES
(1, '教程展示'),
(2, '剧本推荐'),
(3, '新闻资讯'),
(4, '微传播计划'),
(5, '客户端宣传页'),
(6, '主题微电影计划'),
(7, '导演培育计划'),
(8, '大型微电影活动');

-- --------------------------------------------------------

--
-- 表的结构 `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `material_type_id` int(11) NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 NOT NULL,
  `abstract` varchar(200) CHARACTER SET utf8 NOT NULL,
  `file_url` varchar(100) CHARACTER SET utf8 NOT NULL,
  `file_size` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `material_type`
--

CREATE TABLE IF NOT EXISTS `material_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_type_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `content` longtext CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL,
  `picture` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact` int(50) NOT NULL COMMENT '发布者公布的线下联系方式',
  `status` tinyint(4) NOT NULL COMMENT '0,1分别代表进行中，已结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `task_type`
--

CREATE TABLE IF NOT EXISTS `task_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `task_type`
--

INSERT INTO `task_type` (`id`, `name`) VALUES
(1, '剧本出售'),
(2, '团队招募'),
(3, '剧本征集'),
(4, '寻求投资');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `real_name` varchar(10) CHARACTER SET utf8 NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '0,1分别代表男，女',
  `address` varchar(100) CHARACTER SET utf8 NOT NULL,
  `contact` varchar(20) CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) NOT NULL,
  `log_off` tinyint(4) NOT NULL COMMENT '0,1分别代表未注销，已注销',
  `login_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username_password` (`username`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title_cn` varchar(50) CHARACTER SET utf8 NOT NULL,
  `title_en` varchar(50) CHARACTER SET utf8 NOT NULL,
  `type_id` int(11) NOT NULL,
  `dscrp` varchar(200) CHARACTER SET utf8 NOT NULL,
  `dur` int(11) NOT NULL,
  `director` varchar(100) CHARACTER SET utf8 NOT NULL,
  `producer` varchar(100) CHARACTER SET utf8 NOT NULL,
  `stars` varchar(100) CHARACTER SET utf8 NOT NULL,
  `tags` varchar(100) CHARACTER SET utf8 NOT NULL,
  `video_url` varchar(100) CHARACTER SET utf8 NOT NULL,
  `poster` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `video`
--

INSERT INTO `video` (`id`, `title_cn`, `title_en`, `type_id`, `dscrp`, `dur`, `director`, `producer`, `stars`, `tags`, `video_url`, `poster`, `user_id`) VALUES
(1, '27岁', '27 Years Old', 1, '这部影片讲述了一个27岁女孩的故事。', 270, '杜美莹', '', '李丹', '情感；青春；女生', '1.mp4', '1.jpg', 0),
(2, 'CUC-NMI新媒体研究院宣传片', 'CUC-NMI New Media Institute promo', 6, '新媒体研究院宣传影片', 187, '', '', '', '媒体；宣传', '2.mp4', '2.jpg', NULL),
(3, '音乐星期五', 'music friday', 3, '该影片是音乐评论类栏目。', 331, '穆捷', '', '', '音乐；评论；流行', '3.mp4', '3.jpg', 0),
(6, '理查德和科瑞', 'Richard+Cory', 1, '该影片讲述了人性的转变故事。', 1220, '韩文文', '', 'Harry Reiner; Callum Stewart', '悬疑；恐怖；惊悚', '4.mp4', '4.jpg', 0),
(8, '蠕动', 'wiggle', 1, '该影片讲述了有关爱情的故事。', 499, '王玲玲；吕欣；刘思思', '张萌', '吕欣；盖鹏', '爱情；矛盾', '5.mp4', '5.jpg', 0),
(10, '阿根达斯', 'Agen Das', 3, '该影片讲述了一个冰淇淋的故事。', 254, '巩雪', '', '谷婉君；沈群淇', '广告；食物', '6.mp4', '6.jpg', NULL),
(11, '爱的画工', 'Love painters', 2, '该影片讲述了一个老艺术家的故事。', 948, '张云鹤', '赵子忠；王薇', '', '艺术；老人', '7.mp4', '7.jpg', NULL),
(12, '爱嘉', 'Love Ka', 1, '该影片讲述了家庭与爱情交织的故事。', 1430, '童谣', '赵子忠', '', '', '8.mp4', '8.jpg', NULL),
(13, '爱情的样子', 'Love the way', 1, '该影片讲述了伤感的爱情故事。', 1123, '王林艳', '', '戚芮；陈献帆；刘欢；赵睿；妍妍', '爱情；伤感', '9.mp4', '9.jpg', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `video_type`
--

CREATE TABLE IF NOT EXISTS `video_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `video_type`
--

INSERT INTO `video_type` (`id`, `name`) VALUES
(1, '微电影'),
(2, '微纪录'),
(3, '微栏目'),
(4, '微动漫'),
(5, '创意视频'),
(6, '信息视频');

--
-- 限制导出的表
--

--
-- 限制表 `authen`
--
ALTER TABLE `authen`
  ADD CONSTRAINT `authen_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `college`
--
ALTER TABLE `college`
  ADD CONSTRAINT `college_ibfk_1` FOREIGN KEY (`college_type_id`) REFERENCES `college_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- 限制表 `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `video_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
