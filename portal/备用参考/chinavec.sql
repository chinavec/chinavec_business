-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 08 月 07 日 12:18
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `chinavec`
--

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

--
-- 转存表中的数据 `authen`
--


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
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `video`
--


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
-- 限制表 `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `video_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
