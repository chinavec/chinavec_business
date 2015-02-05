-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 08 月 04 日 20:16
-- 服务器版本: 5.1.62
-- PHP 版本: 5.3.9-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `auth`
--

-- --------------------------------------------------------

--
-- 表的结构 `authfile`
--

CREATE TABLE IF NOT EXISTS `authfile` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(3) NOT NULL,
  `code` varchar(20) NOT NULL,
  `valid_dt` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `authfile`
--

INSERT INTO `authfile` (`id`, `type`, `code`, `valid_dt`) VALUES
(1, 'P', 'C0308P00001', '2003-08-15'),
(2, 'F', 'C1308F00002', '2013-08-27'),
(3, 'P', 'C1308P00003', '2013-08-09'),
(4, 'F', 'C1308F00004', '2013-08-28'),
(5, 'F', 'C1309F00005', '2013-09-12'),
(6, 'F', 'C1008F00006', '2010-08-24');

-- --------------------------------------------------------

--
-- 表的结构 `videofile`
--

CREATE TABLE IF NOT EXISTS `videofile` (
  `video_id` int(3) NOT NULL AUTO_INCREMENT,
  `video_path` varchar(1000) NOT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `videofile`
--

INSERT INTO `videofile` (`video_id`, `video_path`) VALUES
(1, '/var/www/ui_auth/video/wi.wmv'),
(2, '/var/www/ui_auth/video/xiaoge.mpg');
