-- MySQL dump 10.13  Distrib 5.5.8, for Win32 (x86)
--
-- Host: localhost    Database: cloudmedia
-- ------------------------------------------------------
-- Server version	5.5.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin_role_id` int(11) DEFAULT NULL,
  `contact` varchar(50) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_role_id` (`admin_role_id`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_role` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_access`
--

DROP TABLE IF EXISTS `admin_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_role_id` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_role_id` (`admin_role_id`),
  CONSTRAINT `admin_access_ibfk_1` FOREIGN KEY (`admin_role_id`) REFERENCES `admin_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_access`
--

LOCK TABLES `admin_access` WRITE;
/*!40000 ALTER TABLE `admin_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role`
--

DROP TABLE IF EXISTS `admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role`
--

LOCK TABLES `admin_role` WRITE;
/*!40000 ALTER TABLE `admin_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `image` varchar(50) NOT NULL,
  `click_to_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner`
--

LOCK TABLES `banner` WRITE;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing`
--

DROP TABLE IF EXISTS `billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `system_coding` tinyint(4) DEFAULT NULL,
  `times` tinyint(4) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `can_modify` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing`
--

LOCK TABLES `billing` WRITE;
/*!40000 ALTER TABLE `billing` DISABLE KEYS */;
INSERT INTO `billing` VALUES (1,'包月','本月之类有效',1,-1,NULL,NULL,0,1365424300),(2,'包周','7天之类有效',2,-1,NULL,NULL,0,1365424300),(3,'包天','24小时内有效',3,-1,NULL,NULL,0,1365424300),(4,'计次','按每次观看一个视频节目单独计费',4,1,NULL,NULL,0,1365424300),(9,'五一优惠3','五一期间优惠3',NULL,-1,1367164800,1367596800,1,1367137474);
/*!40000 ALTER TABLE `billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `system_coding` tinyint(4) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `can_modify` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `business_cat` tinyint(4) NOT NULL DEFAULT '0',
  `label_id` int(11) NOT NULL,
  `is_free` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business`
--

LOCK TABLES `business` WRITE;
/*!40000 ALTER TABLE `business` DISABLE KEYS */;
INSERT INTO `business` VALUES (1,'直播','平台所有直播节目',1,1,0,1365424300,1365424330,0,1,0,0),(2,'时移','平台所有时移节目',2,1,0,1365424300,1365424330,0,2,0,0),(3,'赛车时代11','赛车相关视频集锦',NULL,2,1,1365562410,1368346384,1368346388,0,1,0),(6,'33','33',NULL,0,1,1366900015,NULL,NULL,0,0,0),(7,'44','44',NULL,10,1,1366900096,1366944556,1366944558,0,0,0),(16,'斯诺克321','斯诺克123',NULL,0,1,1367462322,NULL,NULL,0,2,0),(17,'hello','world',NULL,10,1,1367462400,1368086168,1368086210,0,5,1);
/*!40000 ALTER TABLE `business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_billing`
--

DROP TABLE IF EXISTS `business_billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `billing_id` int(11) NOT NULL,
  `cost` float NOT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `business_id` (`business_id`),
  KEY `billing_id` (`billing_id`),
  KEY `discount_id` (`discount_id`),
  CONSTRAINT `business_billing_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `business_billing_ibfk_2` FOREIGN KEY (`billing_id`) REFERENCES `billing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `business_billing_ibfk_3` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_billing`
--

LOCK TABLES `business_billing` WRITE;
/*!40000 ALTER TABLE `business_billing` DISABLE KEYS */;
INSERT INTO `business_billing` VALUES (7,3,1,100,2,1367982045),(8,3,9,100,2,1368087387),(9,16,2,100,2,1368345544);
/*!40000 ALTER TABLE `business_billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_statistics`
--

DROP TABLE IF EXISTS `business_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `order_times` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `year` smallint(4) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `month` (`month`),
  KEY `day` (`day`),
  KEY `business_id` (`business_id`),
  KEY `year` (`year`),
  CONSTRAINT `business_statistics_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_statistics`
--

LOCK TABLES `business_statistics` WRITE;
/*!40000 ALTER TABLE `business_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business_video`
--

DROP TABLE IF EXISTS `business_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `business_id` (`business_id`,`video_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `business_video_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `business_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business_video`
--

LOCK TABLES `business_video` WRITE;
/*!40000 ALTER TABLE `business_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `business_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cloud_manage_group_user`
--

DROP TABLE IF EXISTS `cloud_manage_group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cloud_manage_group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `cloud_manage_group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cloud_manage_group_user`
--

LOCK TABLES `cloud_manage_group_user` WRITE;
/*!40000 ALTER TABLE `cloud_manage_group_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `cloud_manage_group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cloud_manage_service`
--

DROP TABLE IF EXISTS `cloud_manage_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cloud_manage_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cloud_manage_service`
--

LOCK TABLES `cloud_manage_service` WRITE;
/*!40000 ALTER TABLE `cloud_manage_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `cloud_manage_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cloud_manage_service_business`
--

DROP TABLE IF EXISTS `cloud_manage_service_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cloud_manage_service_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `capacity` varchar(100) NOT NULL,
  `cloud_manage_service_id` int(11) DEFAULT NULL,
  `limit_concurrent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cloud_manage_service_id` (`cloud_manage_service_id`),
  CONSTRAINT `cloud_manage_service_business_ibfk_1` FOREIGN KEY (`cloud_manage_service_id`) REFERENCES `cloud_manage_service` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cloud_manage_service_business`
--

LOCK TABLES `cloud_manage_service_business` WRITE;
/*!40000 ALTER TABLE `cloud_manage_service_business` DISABLE KEYS */;
/*!40000 ALTER TABLE `cloud_manage_service_business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content_distribution`
--

DROP TABLE IF EXISTS `content_distribution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content_distribution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `video_type` tinyint(4) NOT NULL,
  `server` varchar(20) NOT NULL,
  `distribution­_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  `is_center` tinyint(4) NOT NULL DEFAULT '1',
  `distribution_status` tinyint(4) NOT NULL,
  `guid` varchar(50) NOT NULL,
  `video_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `content_distribution_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content_distribution`
--

LOCK TABLES `content_distribution` WRITE;
/*!40000 ALTER TABLE `content_distribution` DISABLE KEYS */;
/*!40000 ALTER TABLE `content_distribution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `discount` float NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

LOCK TABLES `discount` WRITE;
/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
INSERT INTO `discount` VALUES (2,'八折优惠','八折优惠',0.8,1365729589);
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_business`
--

DROP TABLE IF EXISTS `epg_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `epg_label_id` tinyint(4) NOT NULL,
  `business_cat` tinyint(4) NOT NULL,
  `is_free` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `release` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_business`
--

LOCK TABLES `epg_business` WRITE;
/*!40000 ALTER TABLE `epg_business` DISABLE KEYS */;
INSERT INTO `epg_business` VALUES (1,1,'包年','呵呵呵',1,1,0,1,1,0);
/*!40000 ALTER TABLE `epg_business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_business_rank`
--

DROP TABLE IF EXISTS `epg_business_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_business_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `view_total` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_business_rank`
--

LOCK TABLES `epg_business_rank` WRITE;
/*!40000 ALTER TABLE `epg_business_rank` DISABLE KEYS */;
INSERT INTO `epg_business_rank` VALUES (1,1,38,1368535213),(2,2,4,1368535213);
/*!40000 ALTER TABLE `epg_business_rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_business_video`
--

DROP TABLE IF EXISTS `epg_business_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_business_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epg_business_id` int(11) NOT NULL,
  `epg_video_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_business_video`
--

LOCK TABLES `epg_business_video` WRITE;
/*!40000 ALTER TABLE `epg_business_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `epg_business_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_group`
--

DROP TABLE IF EXISTS `epg_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  `author` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_group`
--

LOCK TABLES `epg_group` WRITE;
/*!40000 ALTER TABLE `epg_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `epg_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_label`
--

DROP TABLE IF EXISTS `epg_label`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_label`
--

LOCK TABLES `epg_label` WRITE;
/*!40000 ALTER TABLE `epg_label` DISABLE KEYS */;
/*!40000 ALTER TABLE `epg_label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_live_channel`
--

DROP TABLE IF EXISTS `epg_live_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_live_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `guid` varchar(50) NOT NULL,
  `live_url` varchar(200) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `release` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `logo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `epg_live_channel_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_live_channel`
--

LOCK TABLES `epg_live_channel` WRITE;
/*!40000 ALTER TABLE `epg_live_channel` DISABLE KEYS */;
INSERT INTO `epg_live_channel` VALUES (1,'火星卫视','来自火星','123','123',NULL,1,1111111,'11');
/*!40000 ALTER TABLE `epg_live_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_live_programme`
--

DROP TABLE IF EXISTS `epg_live_programme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_live_programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epg_live_channel_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_live_programme`
--

LOCK TABLES `epg_live_programme` WRITE;
/*!40000 ALTER TABLE `epg_live_programme` DISABLE KEYS */;
INSERT INTO `epg_live_programme` VALUES (1,1,'轰炸地球','123',1365424330,1365424360,1365424330,'323'),(12,8,'CCTV8','',1366063200,1366124400,1366041600,'image/picture/movie1'),(13,7,'CCTV7','',1366063200,1366124400,1366041600,'image/picture/movie1'),(14,6,'CCTV6','',1366063200,1366124400,1366041600,'image/picture/movie1'),(15,5,'CCTV5','',1366063200,1366124400,1366041600,'image/picture/movie1'),(16,4,'CCTV4','',1366063200,1366124400,1366041600,'image/picture/movie1'),(17,3,'CCTV3','',1366063200,1366124400,1366041600,'image/picture/movie1'),(18,2,'CCTV2','',1366063200,1366124400,1366041600,'image/picture/movie1'),(19,1,'CCTV1','梁家辉凭寒战第四次封帝',1366063200,1366124400,1366041600,'image/picture/movie1'),(20,1,'CCTV1','梁家辉凭寒战第四次封帝',1366063200,1366066800,1366041600,'image/picture/movie1'),(21,1,'CCTV1aa','梁家辉凭寒战第四次封帝',1366067400,1366070280,1366041600,'image/picture/movie1'),(22,1,'CCTV1bb','梁家辉凭寒战第四次封帝',1366071000,1366080600,1366041600,'image/picture/movie1'),(23,1,'CCTV1ccc','墙来啦游戏全面升级',1366081800,1366098600,1366041600,'image/picture/movie1'),(24,1,'CCTV1ddd','北京雾霾天气有所改善',1366101300,1366109100,1366041600,'image/picture/movie1'),(25,1,'CCTV1wre','嘉宾来访为李嘉诚',1366115700,1366127100,1366041600,'image/picture/movie1'),(26,1,'CCTV117','',1366115700,1366127100,1366128001,'image/picture/movie1'),(27,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(28,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(29,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(30,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(31,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(32,1,'CCTV1wre','',1366029300,1366040700,1365955201,'image/picture/movie1'),(33,1,'CCTV1wre','',1365942900,1365954300,1365868801,'image/picture/movie1'),(34,1,'CCTV1wre','',1365942900,1365954300,1365868801,'image/picture/movie1'),(35,1,'CCTV1wre','',1365942900,1365954300,1365868801,'image/picture/movie1'),(36,1,'CCTV1wre','',1365942900,1365954300,1365868801,'image/picture/movie1'),(37,1,'CCTV1wre','',1365856500,1365867900,1365782401,'image/picture/movie1'),(38,1,'CCTV1wre','',1365856500,1365867900,1365782401,'image/picture/movie1'),(39,1,'CCTV1wre','',1365856500,1365867900,1365782401,'image/picture/movie1'),(40,1,'CCTV1wre','',1365770100,1365781500,1365696001,'image/picture/movie1'),(41,1,'CCTV1wre','',1365770100,1365781500,1365696001,'image/picture/movie1'),(42,1,'CCTV1wre','',1365770100,1365781500,1365696001,'image/picture/movie1'),(43,1,'CCTV1wre','',1365683700,1365695100,1365609601,'image/picture/movie1'),(44,1,'CCTV1wre','',1365683700,1365695100,1365609601,'image/picture/movie1'),(45,1,'CCTV1wre','',1365683700,1365695100,1365609601,'image/picture/movie1'),(46,1,'CCTV1wre','',1365597300,1365608700,1365523201,'image/picture/movie1'),(47,1,'CCTV1wre','',1365597300,1365608700,1365523201,'image/picture/movie1'),(48,1,'CCTV1wre','',1365597300,1365608700,1365523201,'image/picture/movie1');
/*!40000 ALTER TABLE `epg_live_programme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_recording_video`
--

DROP TABLE IF EXISTS `epg_recording_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_recording_video` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) NOT NULL,
  `epg_live_programme_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `release` tinyint(1) NOT NULL,
  `time_shift_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `live_channel_id` (`epg_live_programme_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_recording_video`
--

LOCK TABLES `epg_recording_video` WRITE;
/*!40000 ALTER TABLE `epg_recording_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `epg_recording_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_video`
--

DROP TABLE IF EXISTS `epg_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `actor` varchar(100) NOT NULL,
  `abstract` varchar(500) NOT NULL,
  `poster` varchar(50) NOT NULL,
  `label_id` varchar(20) NOT NULL,
  `episode` int(4) DEFAULT NULL,
  `year` varchar(50) NOT NULL,
  `runtime` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `video_create_time` int(11) NOT NULL,
  `video_url` varchar(100) NOT NULL,
  `release` tinyint(4) NOT NULL DEFAULT '0',
  `video_id` int(11) NOT NULL,
  `recommend` tinyint(4) NOT NULL,
  `business_ids` varchar(100) NOT NULL,
  `group_id` int(11) NOT NULL,
  `is_free` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_video`
--

LOCK TABLES `epg_video` WRITE;
/*!40000 ALTER TABLE `epg_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `epg_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `epg_video_rank`
--

DROP TABLE IF EXISTS `epg_video_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epg_video_rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `label_id` tinyint(4) NOT NULL,
  `view_total` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `epg_video_rank`
--

LOCK TABLES `epg_video_rank` WRITE;
/*!40000 ALTER TABLE `epg_video_rank` DISABLE KEYS */;
INSERT INTO `epg_video_rank` VALUES (13,2,1,60,1365682456),(14,1,1,14,1365682456),(29,2,1,14,1366772428),(30,3,1,6,1366772428),(31,1,5,1,1366772428);
/*!40000 ALTER TABLE `epg_video_rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financial_statistics`
--

DROP TABLE IF EXISTS `financial_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `total_fee` int(11) NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financial_statistics`
--

LOCK TABLES `financial_statistics` WRITE;
/*!40000 ALTER TABLE `financial_statistics` DISABLE KEYS */;
/*!40000 ALTER TABLE `financial_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  `author` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_service_resource`
--

DROP TABLE IF EXISTS `group_service_resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_service_resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `on_demand` int(11) NOT NULL,
  `live_telecast` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_service_resource_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_service_resource`
--

LOCK TABLES `group_service_resource` WRITE;
/*!40000 ALTER TABLE `group_service_resource` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_service_resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `label`
--

DROP TABLE IF EXISTS `label`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `label`
--

LOCK TABLES `label` WRITE;
/*!40000 ALTER TABLE `label` DISABLE KEYS */;
INSERT INTO `label` VALUES (1,'电影'),(2,'电视剧'),(3,'综艺'),(4,'音乐'),(5,'其他');
/*!40000 ALTER TABLE `label` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_channel`
--

DROP TABLE IF EXISTS `live_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `live_url` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `interrupt` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL,
  `logo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `live_channel_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_channel`
--

LOCK TABLES `live_channel` WRITE;
/*!40000 ALTER TABLE `live_channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_programme`
--

DROP TABLE IF EXISTS `live_programme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `live_channel_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `record` tinyint(4) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `live_channel_id` (`live_channel_id`),
  CONSTRAINT `live_programme_ibfk_1` FOREIGN KEY (`live_channel_id`) REFERENCES `live_channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_programme`
--

LOCK TABLES `live_programme` WRITE;
/*!40000 ALTER TABLE `live_programme` DISABLE KEYS */;
/*!40000 ALTER TABLE `live_programme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_type_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `create_time` int(11) NOT NULL,
  `portal_admin_id` int(4) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `news_type_id` (`news_type_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`news_type_id`) REFERENCES `news_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_type`
--

DROP TABLE IF EXISTS `news_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_type`
--

LOCK TABLES `news_type` WRITE;
/*!40000 ALTER TABLE `news_type` DISABLE KEYS */;
INSERT INTO `news_type` VALUES (1,'综合新闻'),(2,'运营商新闻'),(3,'媒体新闻'),(4,'公告');
/*!40000 ALTER TABLE `news_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portal_admin`
--

DROP TABLE IF EXISTS `portal_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portal_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `realname` varchar(5) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portal_admin`
--

LOCK TABLES `portal_admin` WRITE;
/*!40000 ALTER TABLE `portal_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `portal_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recording_video`
--

DROP TABLE IF EXISTS `recording_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recording_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) NOT NULL,
  `live_programme_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `file_size` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `time_shift_url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `live_channel_id` (`live_programme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recording_video`
--

LOCK TABLES `recording_video` WRITE;
/*!40000 ALTER TABLE `recording_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `recording_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource`
--

DROP TABLE IF EXISTS `resource`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `required` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource`
--

LOCK TABLES `resource` WRITE;
/*!40000 ALTER TABLE `resource` DISABLE KEYS */;
/*!40000 ALTER TABLE `resource` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resource_distribute`
--

DROP TABLE IF EXISTS `resource_distribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_distribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `limit_volume` int(11) NOT NULL,
  `distribute_time` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `business_name` varchar(20) NOT NULL,
  `business_type` tinyint(4) NOT NULL,
  `limit_concurrent` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `server_id` (`server_id`),
  CONSTRAINT `resource_distribute_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resource` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `resource_distribute_ibfk_2` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resource_distribute`
--

LOCK TABLES `resource_distribute` WRITE;
/*!40000 ALTER TABLE `resource_distribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `resource_distribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server`
--

DROP TABLE IF EXISTS `server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `volume` float NOT NULL,
  `resource_id` int(11) NOT NULL,
  `register_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server`
--

LOCK TABLES `server` WRITE;
/*!40000 ALTER TABLE `server` DISABLE KEYS */;
INSERT INTO `server` VALUES (1,'222.31.88.15','15服务器','存储服务器',1,1,0),(3,'222.31.73.147','我的服务器','存储服务器',2,1,122325512);
/*!40000 ALTER TABLE `server` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `server_operatioing_info`
--

DROP TABLE IF EXISTS `server_operatioing_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `server_operatioing_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server_id` int(11) NOT NULL,
  `cpu_usage_rate` float NOT NULL,
  `memory_usage_rate` float NOT NULL,
  `operating_state` tinyint(4) NOT NULL,
  `thread` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `server_id` (`server_id`),
  CONSTRAINT `server_operatioing_info_ibfk_1` FOREIGN KEY (`server_id`) REFERENCES `server` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `server_operatioing_info`
--

LOCK TABLES `server_operatioing_info` WRITE;
/*!40000 ALTER TABLE `server_operatioing_info` DISABLE KEYS */;
INSERT INTO `server_operatioing_info` VALUES (8,1,1,6.64,1,24,1364990855),(10,3,5.6,10.2,1,12,2435436),(11,1,0,0,0,0,1368083648),(12,1,0,0,0,0,1368083674),(13,1,0,0,0,0,1368083791),(14,1,0,0,0,0,1368083821),(15,3,0,0,0,0,1368083821),(16,1,0,0,0,0,1368084224),(17,3,0,0,0,0,1368084224),(19,1,0,0,0,0,1368097909),(20,3,30,20,1,300,1368097909);
/*!40000 ALTER TABLE `server_operatioing_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_visit_record`
--

DROP TABLE IF EXISTS `site_visit_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_visit_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(20) NOT NULL,
  `page` varchar(255) NOT NULL,
  `terminal` tinyint(4) NOT NULL COMMENT '1为PC端，2为手机端，3为机顶盒端',
  `video_id` int(11) NOT NULL,
  `visit_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`),
  KEY `visit_time` (`visit_time`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_visit_record`
--

LOCK TABLES `site_visit_record` WRITE;
/*!40000 ALTER TABLE `site_visit_record` DISABLE KEYS */;
INSERT INTO `site_visit_record` VALUES (1,'222.31.73.176','http://222.31.88.15/cloudm/support/dataAnalysis/js/siteTracer.html',0,1,1365392080),(2,'10.128.172.62','http://222.31.88.33/cloudm/support/dataAnalysis/js/siteTracer.html',0,2,1365392203),(3,'222.31.73.147','http://localhost/cloudm_pc/index.php',0,2,1365408895),(4,'127.0.0.1','',0,2,1365408924),(5,'127.0.0.1','',0,2,1365409031),(6,'127.0.0.1','',0,2,1365409032),(7,'127.0.0.1','',0,2,1365409277),(8,'127.0.0.1','',0,2,1365409278),(9,'222.31.73.147','http://222.31.88.15/cloudm/support/dataAnalysis/js/siteTracer.html',0,2,1365409295),(10,'127.0.0.1','',0,2,1365409331),(11,'127.0.0.1','',0,2,1365409516),(12,'222.31.73.147','http://localhost/cloudm_pc/index.php',0,2,1365409523),(13,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,2,1365409614),(14,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,2,1365476109),(15,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,4,1365476181),(16,'222.31.73.147','http://222.31.88.33/cloudm/support/dataAnalysis/js/siteTracer.html',0,3,1365477350),(17,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,5,1365497042),(18,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,3,1365497846),(19,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,3,1365558115),(20,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,3,1365562190),(21,'222.31.73.147','http://localhost/support/dataAnalysis/js/siteTracer.html',0,3,1365562321),(22,'127.0.0.1','http://stb.cloudmedia.com/movie',3,0,1368097505);
/*!40000 ALTER TABLE `site_visit_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_visit_statistics`
--

DROP TABLE IF EXISTS `site_visit_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_visit_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_total` int(11) NOT NULL,
  `terminal` tinyint(4) NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_visit_statistics`
--

LOCK TABLES `site_visit_statistics` WRITE;
/*!40000 ALTER TABLE `site_visit_statistics` DISABLE KEYS */;
INSERT INTO `site_visit_statistics` VALUES (1,4,1,2013,4,24),(2,34,2,2013,5,6),(3,23,3,2013,3,2),(4,4,1,2013,5,13),(5,4,1,2013,5,13);
/*!40000 ALTER TABLE `site_visit_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_log`
--

DROP TABLE IF EXISTS `system_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `level` tinyint(4) NOT NULL COMMENT '1为管理员登陆日志，2为管理员创建、编辑、删除等操作日志，5为错误日志（操作数据库失败等）',
  `messages` varchar(200) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_log`
--

LOCK TABLES `system_log` WRITE;
/*!40000 ALTER TABLE `system_log` DISABLE KEYS */;
INSERT INTO `system_log` VALUES (1,2,NULL,2,'创建业务[33]',1366900015),(2,2,NULL,2,'创建业务[44]',1366900096),(3,2,NULL,1,'创建业务[斯诺克]',1367462322),(4,2,NULL,2,'创建业务[hello]',1367462400),(5,2,NULL,2,'启动业务[hello]',1368086168),(6,2,NULL,2,'停止业务[hello]成功',1368086210),(7,2,NULL,2,'删除业务[hello]成功',1368086218),(8,2,NULL,2,'为业务[赛车时代11]设置计费策略[五一优惠3]成功',1368087387),(9,2,NULL,2,'为业务[斯诺克321]设置计费策略[包周]成功',1368345544),(10,2,NULL,2,'启动业务[赛车时代11]成功',1368346384),(11,2,NULL,2,'停止业务[赛车时代11]成功',1368346388);
/*!40000 ALTER TABLE `system_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
INSERT INTO `test` VALUES (2,'2013-05-06 21:07:16');
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL COMMENT '单位',
  `real_name` varchar(10) DEFAULT NULL,
  `nick_name` varchar(10) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `log_off` tinyint(4) NOT NULL DEFAULT '0',
  `token` varchar(32) NOT NULL,
  `login_time` int(11) DEFAULT NULL,
  `group_status` tinyint(4) NOT NULL,
  `group_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username_password` (`username`,`password`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'liboran','fcea920f7412b5da7be0cf42b8c93759','liboran0727@163.com',NULL,NULL,NULL,0,NULL,NULL,2013,0,'',NULL,0,NULL),(2,'ttt','e10adc3949ba59abbe56e057f20f883e','w@126.com',NULL,NULL,NULL,0,NULL,NULL,2013,0,'',NULL,0,NULL),(3,'122','cdbdeb1fcf8eaadf9d8bb35e6cdd4769','111',NULL,NULL,NULL,0,NULL,NULL,2013,0,'',NULL,0,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_account`
--

DROP TABLE IF EXISTS `user_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `user_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_account`
--

LOCK TABLES `user_account` WRITE;
/*!40000 ALTER TABLE `user_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_business`
--

DROP TABLE IF EXISTS `user_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `times` smallint(6) DEFAULT '0',
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `cost` float NOT NULL DEFAULT '0',
  `discount` float DEFAULT NULL,
  `subscribe_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `business_id` (`business_id`),
  CONSTRAINT `user_business_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_business_ibfk_2` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_business`
--

LOCK TABLES `user_business` WRITE;
/*!40000 ALTER TABLE `user_business` DISABLE KEYS */;
INSERT INTO `user_business` VALUES (1,1,1,0,2013,2013,10,1,1365428300),(2,1,1,0,2013,2013,10,1,1365834300);
/*!40000 ALTER TABLE `user_business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_financial`
--

DROP TABLE IF EXISTS `user_financial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_financial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0为充值，1为消费',
  `fee` float NOT NULL,
  `consumer_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_financial_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_financial`
--

LOCK TABLES `user_financial` WRITE;
/*!40000 ALTER TABLE `user_financial` DISABLE KEYS */;
INSERT INTO `user_financial` VALUES (1,1,1,23,1365428300),(2,2,0,34,1361428300);
/*!40000 ALTER TABLE `user_financial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_statistics`
--

DROP TABLE IF EXISTS `user_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_total` int(11) NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_statistics`
--

LOCK TABLES `user_statistics` WRITE;
/*!40000 ALTER TABLE `user_statistics` DISABLE KEYS */;
INSERT INTO `user_statistics` VALUES (1,13,2013,4,7),(2,6,2013,4,8),(3,111,2013,4,9),(4,12,2013,4,10),(5,34,2013,4,11);
/*!40000 ALTER TABLE `user_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_video`
--

DROP TABLE IF EXISTS `user_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `video_type` tinyint(4) NOT NULL,
  `subscribe_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `user_video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_video`
--

LOCK TABLES `user_video` WRITE;
/*!40000 ALTER TABLE `user_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_view_history`
--

DROP TABLE IF EXISTS `user_view_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_view_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `video_position` smallint(6) NOT NULL,
  `view_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `user_view_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_view_history_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_view_history`
--

LOCK TABLES `user_view_history` WRITE;
/*!40000 ALTER TABLE `user_view_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_view_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) NOT NULL,
  `label_id` int(11) DEFAULT NULL,
  `number` int(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `title` varchar(50) NOT NULL,
  `poster` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `actor` varchar(100) NOT NULL,
  `abstract` varchar(200) NOT NULL,
  `file_url` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `is_free` tinyint(4) NOT NULL DEFAULT '1',
  `business_ids` varchar(100) NOT NULL,
  `insert_complete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '标记是否注入到视频服务器',
  `recommend` tinyint(4) DEFAULT '0',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `year` varchar(50) NOT NULL,
  `runtime` varchar(50) NOT NULL,
  `language` varchar(50) NOT NULL,
  `note` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `label_id` (`label_id`,`is_free`),
  CONSTRAINT `video_ibfk_1` FOREIGN KEY (`label_id`) REFERENCES `label` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
INSERT INTO `video` VALUES (2,'guid',1,0,1,'推手','tuishou.jpeg','李安','朱晓生','中美文化差异','http://localhost/server_monitor/',800,1,'2',0,0,122325512,466233565,NULL,'','','',''),(3,'guid2',1,0,1,'重庆森林','chongqingsenling.jpeg','王家卫','金城武/林青霞/梁朝伟/王菲','讲述的几个年轻人的故事','http://localhost/server_monitor/',800,1,'2',0,0,122325512,466233565,NULL,'','','',''),(4,'刘俊杰',2,0,1,'两个爸爸1','twodad.jpg','刘俊杰','杨一展 林佑威 乐乐 赖雅妍 梁靖','我们不是普通的一家人，但我们却是最快乐的一家人！一个黄金单身汉爸爸、一个顽固老爹、一个天真无邪的小女孩组成的家庭','http://localhost/server_monitor/',800,1,'2',0,0,122325512,466233565,2,'','','',''),(5,'刘俊杰',2,0,1,'两个爸爸','twodad.jpg','刘俊杰','杨一展 林佑威 乐乐 赖雅妍 梁靖','我们不是普通的一家人，但我们却是最快乐的一家人！一个黄金单身汉爸爸、一个顽固老爹、一个天真无邪的小女孩组成的家庭','http://localhost/server_monitor/',800,1,'1',0,0,122325512,466233565,2,'','','','');
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_view_statistics`
--

DROP TABLE IF EXISTS `video_view_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_view_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) NOT NULL,
  `label_id` tinyint(4) NOT NULL,
  `view_total` int(11) NOT NULL,
  `year` smallint(6) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `day` tinyint(4) NOT NULL,
  `s_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_view_statistics`
--

LOCK TABLES `video_view_statistics` WRITE;
/*!40000 ALTER TABLE `video_view_statistics` DISABLE KEYS */;
INSERT INTO `video_view_statistics` VALUES (1,3,5,1,2013,4,24,1366772412),(2,2,1,14,2013,4,24,1366772412),(3,3,1,6,2013,4,24,1366772412),(4,2,5,1,2013,4,24,1366772526),(5,2,1,14,2013,4,24,1366772526),(6,3,1,6,2013,4,24,1366772526),(7,1,5,1,2013,5,13,1368432283),(8,2,1,14,2013,5,13,1368432283),(9,3,1,6,2013,5,13,1368432283),(10,1,5,1,2013,5,13,1368432460),(11,2,1,13,2013,5,13,1368432460),(12,3,1,5,2013,5,13,1368432460),(13,4,2,1,2013,5,13,1368432460),(14,5,2,1,2013,5,13,1368432460);
/*!40000 ALTER TABLE `video_view_statistics` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-22 21:11:27
