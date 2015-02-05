-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 01 月 17 日 10:51
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

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
-- 表的结构 `site_visit_statistics`
--

CREATE TABLE IF NOT EXISTS `site_visit_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_total` int(11) NOT NULL,
  `terminal` tinyint(4) NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `site_visit_statistics`
--

INSERT INTO `site_visit_statistics` (`id`, `visit_total`, `terminal`, `year`, `month`, `day`) VALUES
(1, 4, 1, 2013, 4, 24),
(2, 34, 2, 2013, 5, 6),
(3, 23, 3, 2013, 3, 2),
(4, 4, 1, 2013, 5, 13),
(5, 4, 1, 2013, 5, 13),
(6, 4, 1, 2013, 6, 18);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
