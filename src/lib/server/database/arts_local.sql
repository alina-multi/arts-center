-- MariaDB dump 10.19  Distrib 10.10.3-MariaDB, for osx10.18 (x86_64)
--
-- Host: 127.0.0.1    Database: arts
-- ------------------------------------------------------
-- Server version	10.9.4-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `action_events`
--

DROP TABLE IF EXISTS `action_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` char(36) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `actionable_type` varchar(191) NOT NULL,
  `actionable_id` bigint(20) unsigned NOT NULL,
  `target_type` varchar(191) NOT NULL,
  `target_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `fields` text NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'running',
  `exception` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original` mediumtext DEFAULT NULL,
  `changes` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_events_actionable_type_actionable_id_index` (`actionable_type`,`actionable_id`),
  KEY `action_events_batch_id_model_type_model_id_index` (`batch_id`,`model_type`,`model_id`),
  KEY `action_events_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_events`
--

LOCK TABLES `action_events` WRITE;
/*!40000 ALTER TABLE `action_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blacklists`
--

DROP TABLE IF EXISTS `blacklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blacklists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `blacklist_user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklists`
--

LOCK TABLES `blacklists` WRITE;
/*!40000 ALTER TABLE `blacklists` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_translations`
--

DROP TABLE IF EXISTS `blog_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `language` char(2) NOT NULL,
  `title` varchar(191) NOT NULL,
  `about` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`about`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_translations_blog_id_language_unique` (`blog_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_translations`
--

LOCK TABLES `blog_translations` WRITE;
/*!40000 ALTER TABLE `blog_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `rating` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blogs_featured_index` (`featured`),
  KEY `blogs_rating_index` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commentable_id` bigint(20) NOT NULL,
  `commentable_type` varchar(191) NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`body`)),
  `comment_id` bigint(20) DEFAULT 0,
  `user_id` bigint(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `depth` tinyint(4) NOT NULL DEFAULT 0,
  `rating` smallint(6) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES
(1,1,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(2,2,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(3,3,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(4,4,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(5,5,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(6,6,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(7,7,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(8,8,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(9,9,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(10,10,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(11,11,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(12,12,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(13,13,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(14,14,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(15,15,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(16,16,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(17,17,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(18,18,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(19,19,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(20,20,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(21,21,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(22,22,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(23,23,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(24,24,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(25,25,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(26,26,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(27,27,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(28,28,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(29,29,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(30,30,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(31,31,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(32,32,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(33,33,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(34,34,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(35,35,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(36,36,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(37,37,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(38,38,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(39,39,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(40,40,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(41,41,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(42,42,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(43,43,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(44,44,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(45,45,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(46,46,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(47,47,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(48,48,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(49,49,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(50,50,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(51,51,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(52,52,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(53,53,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(54,54,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(55,55,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(56,56,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(57,57,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(58,58,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(59,59,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(60,60,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(61,61,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(62,62,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(63,63,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(64,64,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(65,65,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(66,66,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(67,67,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(68,68,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(69,69,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(70,70,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(71,71,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(72,72,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(73,73,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(74,74,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(75,75,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(76,76,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(77,77,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(78,78,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(79,79,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(80,80,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(81,81,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(82,82,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(83,83,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(84,84,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(85,85,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(86,86,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(87,87,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(88,88,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(89,89,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(90,90,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(91,91,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(92,92,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(93,93,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(94,94,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(95,95,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(96,96,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(97,97,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(98,98,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(99,99,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1),
(100,100,'work','{\"delta\":[]}',0,1,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50',0,1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rating` smallint(6) NOT NULL DEFAULT 1,
  `comments` smallint(6) NOT NULL DEFAULT 0,
  `user_id` bigint(20) NOT NULL,
  `category` varchar(191) DEFAULT '',
  `body` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `type` varchar(191) NOT NULL,
  `language` varchar(2) NOT NULL,
  `feedbackable_type` varchar(191) DEFAULT NULL,
  `feedbackable_id` varchar(191) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feedback_type_category_index` (`type`,`category`),
  KEY `feedback_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feeds`
--

DROP TABLE IF EXISTS `feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feeds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `feedable_id` bigint(20) NOT NULL,
  `feedable_type` varchar(191) NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `feeds_feedable_id_feedable_type_user_id_index` (`feedable_id`,`feedable_type`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feeds`
--

LOCK TABLES `feeds` WRITE;
/*!40000 ALTER TABLE `feeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `feeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `followable_type` varchar(191) NOT NULL,
  `followable_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imageables`
--

DROP TABLE IF EXISTS `imageables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imageables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` bigint(20) NOT NULL,
  `imageable_id` bigint(20) NOT NULL,
  `imageable_type` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imageables`
--

LOCK TABLES `imageables` WRITE;
/*!40000 ALTER TABLE `imageables` DISABLE KEYS */;
INSERT INTO `imageables` VALUES
(1,1,1,'App\\WorkBlock'),
(2,201,3,'App\\WorkBlock'),
(3,202,3,'App\\WorkBlock'),
(4,203,3,'App\\WorkBlock'),
(5,204,3,'App\\WorkBlock'),
(6,205,3,'App\\WorkBlock'),
(7,206,3,'App\\WorkBlock'),
(8,2,4,'App\\WorkBlock'),
(9,207,6,'App\\WorkBlock'),
(10,208,6,'App\\WorkBlock'),
(11,209,6,'App\\WorkBlock'),
(12,210,6,'App\\WorkBlock'),
(13,211,6,'App\\WorkBlock'),
(14,212,6,'App\\WorkBlock'),
(15,3,7,'App\\WorkBlock'),
(16,213,9,'App\\WorkBlock'),
(17,214,9,'App\\WorkBlock'),
(18,215,9,'App\\WorkBlock'),
(19,216,9,'App\\WorkBlock'),
(20,217,9,'App\\WorkBlock'),
(21,218,9,'App\\WorkBlock'),
(22,4,10,'App\\WorkBlock'),
(23,219,12,'App\\WorkBlock'),
(24,220,12,'App\\WorkBlock'),
(25,221,12,'App\\WorkBlock'),
(26,222,12,'App\\WorkBlock'),
(27,223,12,'App\\WorkBlock'),
(28,224,12,'App\\WorkBlock'),
(29,5,13,'App\\WorkBlock'),
(30,225,15,'App\\WorkBlock'),
(31,226,15,'App\\WorkBlock'),
(32,227,15,'App\\WorkBlock'),
(33,228,15,'App\\WorkBlock'),
(34,229,15,'App\\WorkBlock'),
(35,230,15,'App\\WorkBlock'),
(36,6,16,'App\\WorkBlock'),
(37,231,18,'App\\WorkBlock'),
(38,232,18,'App\\WorkBlock'),
(39,233,18,'App\\WorkBlock'),
(40,234,18,'App\\WorkBlock'),
(41,235,18,'App\\WorkBlock'),
(42,236,18,'App\\WorkBlock'),
(43,7,19,'App\\WorkBlock'),
(44,237,21,'App\\WorkBlock'),
(45,238,21,'App\\WorkBlock'),
(46,239,21,'App\\WorkBlock'),
(47,240,21,'App\\WorkBlock'),
(48,241,21,'App\\WorkBlock'),
(49,242,21,'App\\WorkBlock'),
(50,8,22,'App\\WorkBlock'),
(51,243,24,'App\\WorkBlock'),
(52,244,24,'App\\WorkBlock'),
(53,245,24,'App\\WorkBlock'),
(54,246,24,'App\\WorkBlock'),
(55,247,24,'App\\WorkBlock'),
(56,248,24,'App\\WorkBlock'),
(57,9,25,'App\\WorkBlock'),
(58,249,27,'App\\WorkBlock'),
(59,250,27,'App\\WorkBlock'),
(60,251,27,'App\\WorkBlock'),
(61,252,27,'App\\WorkBlock'),
(62,253,27,'App\\WorkBlock'),
(63,254,27,'App\\WorkBlock'),
(64,10,28,'App\\WorkBlock'),
(65,255,30,'App\\WorkBlock'),
(66,256,30,'App\\WorkBlock'),
(67,257,30,'App\\WorkBlock'),
(68,258,30,'App\\WorkBlock'),
(69,259,30,'App\\WorkBlock'),
(70,260,30,'App\\WorkBlock');
/*!40000 ALTER TABLE `imageables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `work_id` bigint(20) DEFAULT NULL,
  `old_user_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `folder` varchar(191) NOT NULL,
  `w300` tinyint(1) NOT NULL DEFAULT 0,
  `w600` tinyint(1) NOT NULL DEFAULT 0,
  `w1200` tinyint(1) NOT NULL DEFAULT 0,
  `w2400` tinyint(1) NOT NULL DEFAULT 0,
  `extension` char(4) NOT NULL DEFAULT 'jpg',
  PRIMARY KEY (`id`),
  KEY `images_folder_index` (`folder`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES
(1,'Prof. Arielle Becker Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','reiciendis',0,0,0,0,'jpg'),
(2,'Ms. Cathy Hartmann.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','earum',0,0,0,0,'jpg'),
(3,'Kennith O\'Hara.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eum',0,0,0,0,'jpg'),
(4,'Khalid Stokes.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','architecto',0,0,0,0,'jpg'),
(5,'Ransom Toy.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','iusto',0,0,0,0,'jpg'),
(6,'Georgiana Legros.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','natus',0,0,0,0,'jpg'),
(7,'Patsy Huels.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','rerum',0,0,0,0,'jpg'),
(8,'Mr. Alfonzo Johnston V.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sequi',0,0,0,0,'jpg'),
(9,'Casper Cronin.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quo',0,0,0,0,'jpg'),
(10,'Prof. Anissa Crooks.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','dicta',0,0,0,0,'jpg'),
(11,'Dolores Gibson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','neque',0,0,0,0,'jpg'),
(12,'Mrs. Flo Bashirian.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','inventore',0,0,0,0,'jpg'),
(13,'Dr. Alek Runolfsson DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sunt',0,0,0,0,'jpg'),
(14,'Ms. Gladys Brakus Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eveniet',0,0,0,0,'jpg'),
(15,'Agustina Gulgowski.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','deleniti',0,0,0,0,'jpg'),
(16,'Mrs. Hulda Greenfelder.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','aut',0,0,0,0,'jpg'),
(17,'Gavin Collins IV.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','qui',0,0,0,0,'jpg'),
(18,'Dr. Gaylord Pouros DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','voluptatum',0,0,0,0,'jpg'),
(19,'Josiah Pollich.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','enim',0,0,0,0,'jpg'),
(20,'Marques Keeling.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sunt',0,0,0,0,'jpg'),
(21,'Mrs. Margot Lueilwitz MD.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','et',0,0,0,0,'jpg'),
(22,'Betty Borer.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','non',0,0,0,0,'jpg'),
(23,'Anastasia Hackett.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','aut',0,0,0,0,'jpg'),
(24,'Gerard Jacobson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','repellat',0,0,0,0,'jpg'),
(25,'Theodora Bechtelar.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','inventore',0,0,0,0,'jpg'),
(26,'Evangeline Lind.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sequi',0,0,0,0,'jpg'),
(27,'Linda Dickinson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quis',0,0,0,0,'jpg'),
(28,'Ms. Berneice Donnelly.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eveniet',0,0,0,0,'jpg'),
(29,'Herman Lindgren.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','veritatis',0,0,0,0,'jpg'),
(30,'Mohamed Schuster.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','suscipit',0,0,0,0,'jpg'),
(31,'Blaise Cronin V.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','impedit',0,0,0,0,'jpg'),
(32,'Ms. Dixie Bartoletti V.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quo',0,0,0,0,'jpg'),
(33,'Miss Rosanna Wisoky Jr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eaque',0,0,0,0,'jpg'),
(34,'Guadalupe Gleason DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','minima',0,0,0,0,'jpg'),
(35,'Dewitt Jacobs.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','consequatur',0,0,0,0,'jpg'),
(36,'Prof. Arch Schmeler.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','ducimus',0,0,0,0,'jpg'),
(37,'Jensen Wyman.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','ex',0,0,0,0,'jpg'),
(38,'Vivienne Leuschke.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','iure',0,0,0,0,'jpg'),
(39,'Jon Herzog.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','dolor',0,0,0,0,'jpg'),
(40,'Dr. Marlene Maggio IV.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eveniet',0,0,0,0,'jpg'),
(41,'Evert Gaylord.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eligendi',0,0,0,0,'jpg'),
(42,'Erwin Jacobson DDS.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','totam',0,0,0,0,'jpg'),
(43,'Lavern Braun.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','nam',0,0,0,0,'jpg'),
(44,'Prof. Elliott Gerhold.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','nisi',0,0,0,0,'jpg'),
(45,'Winston Wiegand.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sed',0,0,0,0,'jpg'),
(46,'Dr. Cruz Corwin IV.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','autem',0,0,0,0,'jpg'),
(47,'Michelle Lind V.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eum',0,0,0,0,'jpg'),
(48,'Ms. Ramona Kiehn.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','enim',0,0,0,0,'jpg'),
(49,'Mrs. Juana Deckow II.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','maxime',0,0,0,0,'jpg'),
(50,'Shad Beier.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','cupiditate',0,0,0,0,'jpg'),
(51,'Winifred Brakus II.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','voluptatibus',0,0,0,0,'jpg'),
(52,'Abby Huels.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','molestiae',0,0,0,0,'jpg'),
(53,'Kylee Gleichner.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','repellat',0,0,0,0,'jpg'),
(54,'Annabel Bartell.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quidem',0,0,0,0,'jpg'),
(55,'Mr. Javier Fay.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','suscipit',0,0,0,0,'jpg'),
(56,'Ms. Jazmyne Green III.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','repellat',0,0,0,0,'jpg'),
(57,'Jacquelyn Williamson DDS.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sit',0,0,0,0,'jpg'),
(58,'Shanny Jakubowski.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','incidunt',0,0,0,0,'jpg'),
(59,'Dr. Matteo Johnston.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','corrupti',0,0,0,0,'jpg'),
(60,'Gussie Walker Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','excepturi',0,0,0,0,'jpg'),
(61,'Dr. Solon Hilpert.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','delectus',0,0,0,0,'jpg'),
(62,'Arnoldo Dooley.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','doloremque',0,0,0,0,'jpg'),
(63,'Kade Block.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quia',0,0,0,0,'jpg'),
(64,'Jamil Hegmann.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','perspiciatis',0,0,0,0,'jpg'),
(65,'Mrs. Tess Hoeger.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','debitis',0,0,0,0,'jpg'),
(66,'Emerald Rippin.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','voluptatibus',0,0,0,0,'jpg'),
(67,'Eula Langosh II.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','nobis',0,0,0,0,'jpg'),
(68,'Ramiro Roob.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','reiciendis',0,0,0,0,'jpg'),
(69,'Shanelle Fadel.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','qui',0,0,0,0,'jpg'),
(70,'Camren Pacocha Jr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','est',0,0,0,0,'jpg'),
(71,'Arden Ritchie.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','ullam',0,0,0,0,'jpg'),
(72,'Prof. Dangelo Kunze V.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','voluptatem',0,0,0,0,'jpg'),
(73,'Adelbert Padberg III.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','facere',0,0,0,0,'jpg'),
(74,'Kayleigh Crist.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quo',0,0,0,0,'jpg'),
(75,'Mrs. Alfreda Ortiz.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eius',0,0,0,0,'jpg'),
(76,'Mrs. Otilia Connelly III.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','explicabo',0,0,0,0,'jpg'),
(77,'Jeffry Schumm.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','iusto',0,0,0,0,'jpg'),
(78,'Deshaun Goldner IV.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eum',0,0,0,0,'jpg'),
(79,'Mr. Gilberto Botsford IV.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','nemo',0,0,0,0,'jpg'),
(80,'Tillman Schaden.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eius',0,0,0,0,'jpg'),
(81,'Lydia Gibson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','necessitatibus',0,0,0,0,'jpg'),
(82,'Hilbert Macejkovic.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','unde',0,0,0,0,'jpg'),
(83,'Else Langworth.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','vero',0,0,0,0,'jpg'),
(84,'Hobart Bradtke Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','consequatur',0,0,0,0,'jpg'),
(85,'Devyn Hudson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','ea',0,0,0,0,'jpg'),
(86,'D\'angelo Larson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','voluptas',0,0,0,0,'jpg'),
(87,'Dr. Stacy Mosciski.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','a',0,0,0,0,'jpg'),
(88,'Hollie Okuneva.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','et',0,0,0,0,'jpg'),
(89,'Mr. Maximus Bernier.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quia',0,0,0,0,'jpg'),
(90,'Gregg Hackett.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','quisquam',0,0,0,0,'jpg'),
(91,'Mr. Larry Hayes.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','in',0,0,0,0,'jpg'),
(92,'Demarco Nader.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','vitae',0,0,0,0,'jpg'),
(93,'Cheyanne Hayes.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','molestiae',0,0,0,0,'jpg'),
(94,'Hanna Jones.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','deleniti',0,0,0,0,'jpg'),
(95,'Dr. Fern Barrows.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','ad',0,0,0,0,'jpg'),
(96,'Caesar Emmerich.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','reiciendis',0,0,0,0,'jpg'),
(97,'Dejah Casper II.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','veritatis',0,0,0,0,'jpg'),
(98,'Ole Friesen.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','placeat',0,0,0,0,'jpg'),
(99,'Leta King.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','iste',0,0,0,0,'jpg'),
(100,'Lucinda Hoeger.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','deserunt',0,0,0,0,'jpg'),
(101,'Fatima Kuhic.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','sit',0,0,0,0,'jpg'),
(102,'Augusta Hudson.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','et',0,0,0,0,'jpg'),
(103,'Estrella Bernhard.jpg',1,NULL,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','eum',0,0,0,0,'jpg'),
(104,'Mr. Luigi Block.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','labore',0,0,0,0,'jpg'),
(105,'Santina Stamm.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','ratione',0,0,0,0,'jpg'),
(106,'Jovanny Kuvalis.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','qui',0,0,0,0,'jpg'),
(107,'Dr. Pierre Kreiger IV.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','odit',0,0,0,0,'jpg'),
(108,'Arely Carter.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','ut',0,0,0,0,'jpg'),
(109,'Zachariah Lind PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','quod',0,0,0,0,'jpg'),
(110,'Everardo Vandervort.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','expedita',0,0,0,0,'jpg'),
(111,'Dr. Darien Lowe.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','quia',0,0,0,0,'jpg'),
(112,'Prof. Sterling Ferry.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','non',0,0,0,0,'jpg'),
(113,'Augustus Quigley.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','eos',0,0,0,0,'jpg'),
(114,'Orion Johnston.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','sit',0,0,0,0,'jpg'),
(115,'Dr. Karen Connelly.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','neque',0,0,0,0,'jpg'),
(116,'Dr. Damian Grimes.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','distinctio',0,0,0,0,'jpg'),
(117,'Lonnie Daniel.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','cumque',0,0,0,0,'jpg'),
(118,'Adah Kilback.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','fugit',0,0,0,0,'jpg'),
(119,'Al Auer.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','rerum',0,0,0,0,'jpg'),
(120,'Queenie Gutkowski.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','tempore',0,0,0,0,'jpg'),
(121,'Prof. Kiarra Dare.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','tempora',0,0,0,0,'jpg'),
(122,'Rosemary Shanahan Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','iusto',0,0,0,0,'jpg'),
(123,'Prof. Julian Hoeger.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','suscipit',0,0,0,0,'jpg'),
(124,'Travon Will.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','molestiae',0,0,0,0,'jpg'),
(125,'Ressie Moen.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','debitis',0,0,0,0,'jpg'),
(126,'April Koelpin.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','qui',0,0,0,0,'jpg'),
(127,'Fletcher Price V.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','iste',0,0,0,0,'jpg'),
(128,'Avery Gorczany IV.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','minus',0,0,0,0,'jpg'),
(129,'Josianne Nicolas.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','eveniet',0,0,0,0,'jpg'),
(130,'Aletha Hahn I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','rerum',0,0,0,0,'jpg'),
(131,'Avis Fisher MD.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','voluptate',0,0,0,0,'jpg'),
(132,'Ava Johnston PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','iste',0,0,0,0,'jpg'),
(133,'Mr. Vern Stokes I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','reiciendis',0,0,0,0,'jpg'),
(134,'Lily Effertz.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','magni',0,0,0,0,'jpg'),
(135,'Mr. Kiley Wisoky I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','recusandae',0,0,0,0,'jpg'),
(136,'Henry Mann.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','vel',0,0,0,0,'jpg'),
(137,'Cleveland Weimann.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','maxime',0,0,0,0,'jpg'),
(138,'Liam Lubowitz.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','eum',0,0,0,0,'jpg'),
(139,'Mrs. June Volkman.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','voluptatem',0,0,0,0,'jpg'),
(140,'Rolando Mohr.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','eligendi',0,0,0,0,'jpg'),
(141,'Dr. Greyson Lowe Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','ullam',0,0,0,0,'jpg'),
(142,'Dr. Bret McGlynn.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','autem',0,0,0,0,'jpg'),
(143,'Merle Nolan.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','rerum',0,0,0,0,'jpg'),
(144,'Shad Weber.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','minus',0,0,0,0,'jpg'),
(145,'Reymundo Champlin.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','dignissimos',0,0,0,0,'jpg'),
(146,'Mr. Tom Leffler PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','omnis',0,0,0,0,'jpg'),
(147,'Marlen Zulauf.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','et',0,0,0,0,'jpg'),
(148,'Mr. Korey Lynch.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','autem',0,0,0,0,'jpg'),
(149,'Angie Bins.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','omnis',0,0,0,0,'jpg'),
(150,'Dr. Titus Upton.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','repudiandae',0,0,0,0,'jpg'),
(151,'Gaston Hickle.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','molestias',0,0,0,0,'jpg'),
(152,'Anika Bashirian.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','impedit',0,0,0,0,'jpg'),
(153,'Rey Mayer.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','nobis',0,0,0,0,'jpg'),
(154,'Herminia Braun.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','architecto',0,0,0,0,'jpg'),
(155,'Marcos Bogisich.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','sint',0,0,0,0,'jpg'),
(156,'Dr. Macey Beer DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','cupiditate',0,0,0,0,'jpg'),
(157,'Dr. Bernard Considine.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','blanditiis',0,0,0,0,'jpg'),
(158,'Prof. Leopoldo Kuhlman I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','nisi',0,0,0,0,'jpg'),
(159,'Percy Koelpin.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','repudiandae',0,0,0,0,'jpg'),
(160,'Jeffery Collier.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','animi',0,0,0,0,'jpg'),
(161,'Alvera Altenwerth I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','numquam',0,0,0,0,'jpg'),
(162,'Tommie Ebert.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','ipsa',0,0,0,0,'jpg'),
(163,'Ayana VonRueden.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','repellendus',0,0,0,0,'jpg'),
(164,'Loyce Paucek.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','incidunt',0,0,0,0,'jpg'),
(165,'Prof. Georgette Jaskolski Jr..jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','atque',0,0,0,0,'jpg'),
(166,'Magnolia McClure MD.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','odit',0,0,0,0,'jpg'),
(167,'Timmy Ullrich V.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','autem',0,0,0,0,'jpg'),
(168,'Victor Wilderman.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','soluta',0,0,0,0,'jpg'),
(169,'Mr. Ryley Dicki DDS.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','dolore',0,0,0,0,'jpg'),
(170,'Donato Williamson.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','odit',0,0,0,0,'jpg'),
(171,'Torrance Schumm.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','temporibus',0,0,0,0,'jpg'),
(172,'Sylvia Kerluke I.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','et',0,0,0,0,'jpg'),
(173,'Lucy Rice.jpg',1,NULL,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','unde',0,0,0,0,'jpg'),
(174,'Frank Graham IV.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','facilis',0,0,0,0,'jpg'),
(175,'Miss Olga Strosin III.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','dolorem',0,0,0,0,'jpg'),
(176,'Coby Reichert.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','voluptas',0,0,0,0,'jpg'),
(177,'Rhianna Kuhlman.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','quaerat',0,0,0,0,'jpg'),
(178,'Wilfrid Vandervort I.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','odio',0,0,0,0,'jpg'),
(179,'Dr. Meda Hickle PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','eum',0,0,0,0,'jpg'),
(180,'Dominic Hermann DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','velit',0,0,0,0,'jpg'),
(181,'Mr. Nat Senger DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','a',0,0,0,0,'jpg'),
(182,'Georgiana Eichmann III.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','voluptas',0,0,0,0,'jpg'),
(183,'Lonny Kihn.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','dolorem',0,0,0,0,'jpg'),
(184,'Marietta Adams.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','provident',0,0,0,0,'jpg'),
(185,'Zita Renner.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','esse',0,0,0,0,'jpg'),
(186,'Bernhard Lynch V.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','ipsum',0,0,0,0,'jpg'),
(187,'Dagmar Davis.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','quod',0,0,0,0,'jpg'),
(188,'Milton Will.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','rerum',0,0,0,0,'jpg'),
(189,'Dr. Dessie Purdy I.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','maxime',0,0,0,0,'jpg'),
(190,'Mikayla Weber.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','repudiandae',0,0,0,0,'jpg'),
(191,'Autumn Veum.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','itaque',0,0,0,0,'jpg'),
(192,'Prof. Itzel Gusikowski.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','iusto',0,0,0,0,'jpg'),
(193,'Kamron Ernser.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','nihil',0,0,0,0,'jpg'),
(194,'Prof. Sarah Price Sr..jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','est',0,0,0,0,'jpg'),
(195,'Brandi Ferry.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','autem',0,0,0,0,'jpg'),
(196,'Prof. Alysa Von III.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','quam',0,0,0,0,'jpg'),
(197,'Barton Kreiger.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','natus',0,0,0,0,'jpg'),
(198,'Sven Kuphal.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','quidem',0,0,0,0,'jpg'),
(199,'Jeremie Murphy.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','quod',0,0,0,0,'jpg'),
(200,'Mable Block.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','cum',0,0,0,0,'jpg'),
(201,'Zora Lowe.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','officia',0,0,0,0,'jpg'),
(202,'Esteban Brown.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','aspernatur',0,0,0,0,'jpg'),
(203,'Brandi O\'Conner.jpg',1,NULL,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','aut',0,0,0,0,'jpg'),
(204,'Mr. Carmine Hermiston V.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','commodi',0,0,0,0,'jpg'),
(205,'Ms. Salma Watsica.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','et',0,0,0,0,'jpg'),
(206,'Sarai Kovacek.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','consectetur',0,0,0,0,'jpg'),
(207,'Carmine Hickle.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','mollitia',0,0,0,0,'jpg'),
(208,'Ms. Jena Smith.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quo',0,0,0,0,'jpg'),
(209,'Dr. Rita Bauch I.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','qui',0,0,0,0,'jpg'),
(210,'Aliza Lockman.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','consectetur',0,0,0,0,'jpg'),
(211,'Jayne Huels.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','numquam',0,0,0,0,'jpg'),
(212,'Dr. Lilliana Sawayn DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quam',0,0,0,0,'jpg'),
(213,'Lela Paucek.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','molestiae',0,0,0,0,'jpg'),
(214,'Buford Champlin V.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','sint',0,0,0,0,'jpg'),
(215,'Rodolfo Lakin.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','dolor',0,0,0,0,'jpg'),
(216,'Adaline Fahey.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quo',0,0,0,0,'jpg'),
(217,'Dr. Liliana Marks.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','eum',0,0,0,0,'jpg'),
(218,'Celestino Frami.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','laudantium',0,0,0,0,'jpg'),
(219,'Scarlett Bradtke.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','asperiores',0,0,0,0,'jpg'),
(220,'Shanel Wyman.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','earum',0,0,0,0,'jpg'),
(221,'Jazmyn Treutel IV.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','numquam',0,0,0,0,'jpg'),
(222,'Prof. Ariel Rowe.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','sit',0,0,0,0,'jpg'),
(223,'Aric Bailey.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','nostrum',0,0,0,0,'jpg'),
(224,'Mrs. Deanna Marquardt DVM.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','eveniet',0,0,0,0,'jpg'),
(225,'Maggie Wilkinson.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','possimus',0,0,0,0,'jpg'),
(226,'Verda Hand PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','eos',0,0,0,0,'jpg'),
(227,'Cleveland Carroll.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','incidunt',0,0,0,0,'jpg'),
(228,'Jovany Nitzsche.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','voluptas',0,0,0,0,'jpg'),
(229,'Shakira Rice II.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','incidunt',0,0,0,0,'jpg'),
(230,'Chad Lang.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quibusdam',0,0,0,0,'jpg'),
(231,'Dr. Elza Goyette V.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','rem',0,0,0,0,'jpg'),
(232,'Prof. Clinton Hoeger.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','odio',0,0,0,0,'jpg'),
(233,'Janiya Gutmann.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','magnam',0,0,0,0,'jpg'),
(234,'Lauryn Harris.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','deserunt',0,0,0,0,'jpg'),
(235,'Mrs. Evalyn Dooley.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','iure',0,0,0,0,'jpg'),
(236,'Karina Bednar.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','eius',0,0,0,0,'jpg'),
(237,'Zachary Bosco.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','natus',0,0,0,0,'jpg'),
(238,'Erica Kling.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quam',0,0,0,0,'jpg'),
(239,'Clay Johnston.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','itaque',0,0,0,0,'jpg'),
(240,'Prof. Madeline Mann.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','sed',0,0,0,0,'jpg'),
(241,'Rosalia Zulauf.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','esse',0,0,0,0,'jpg'),
(242,'Zita Shanahan.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quos',0,0,0,0,'jpg'),
(243,'Mr. Royce Spinka.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','eos',0,0,0,0,'jpg'),
(244,'Dr. Elmer Wolff II.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quam',0,0,0,0,'jpg'),
(245,'Rodger Durgan DDS.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','itaque',0,0,0,0,'jpg'),
(246,'Hilda Leuschke.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','tenetur',0,0,0,0,'jpg'),
(247,'Arlie Lindgren Jr..jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','tempore',0,0,0,0,'jpg'),
(248,'Rigoberto Jacobs.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','est',0,0,0,0,'jpg'),
(249,'Kailee Koss.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quo',0,0,0,0,'jpg'),
(250,'Mr. John Jast.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','necessitatibus',0,0,0,0,'jpg'),
(251,'Madie Trantow.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','nemo',0,0,0,0,'jpg'),
(252,'Lucious Kuvalis.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','impedit',0,0,0,0,'jpg'),
(253,'Verla Yost.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','facere',0,0,0,0,'jpg'),
(254,'Miss Carolyn Stokes III.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','laborum',0,0,0,0,'jpg'),
(255,'Gayle Corkery.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','deserunt',0,0,0,0,'jpg'),
(256,'Devin Brekke.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','quod',0,0,0,0,'jpg'),
(257,'Prof. Christian Ledner.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','sunt',0,0,0,0,'jpg'),
(258,'Elmo Pouros PhD.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','fugiat',0,0,0,0,'jpg'),
(259,'Bertrand Mante.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','deserunt',0,0,0,0,'jpg'),
(260,'Mr. Santa Kirlin.jpg',1,NULL,NULL,'2023-02-23 22:17:51','2023-02-23 22:17:51','dignissimos',0,0,0,0,'jpg');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2018_01_01_000000_create_action_events_table',1),
(4,'2019_05_03_000001_create_customer_columns',1),
(5,'2019_05_03_000002_create_subscriptions_table',1),
(6,'2019_05_03_000003_create_subscription_items_table',1),
(7,'2019_05_10_000000_add_fields_to_action_events_table',1),
(8,'2019_08_19_000000_create_failed_jobs_table',1),
(9,'2019_12_14_000001_create_personal_access_tokens_table',1),
(10,'2020_02_21_100000_create_images_table',1),
(11,'2020_02_21_135541_create_works_table',1),
(12,'2020_02_21_135551_create_work_details_table',1),
(13,'2020_02_21_145531_create_work_titles_table',1),
(14,'2020_02_21_145715_create_languages_table',1),
(15,'2020_04_17_100814_create_tags_table',1),
(16,'2020_04_17_102354_create_taggables_table',1),
(17,'2020_04_17_141824_create_tag_groups_table',1),
(18,'2020_04_17_141835_create_tag_types_table',1),
(19,'2020_04_20_133037_create_tag_titles_table',1),
(20,'2020_05_01_121437_create_ownables_table',1),
(21,'2020_07_03_114251_create_work_blocks_table',1),
(22,'2020_09_27_094509_create_imageables_table',1),
(23,'2020_09_27_103219_add_image_id_to_users_table',1),
(24,'2020_09_27_134049_add_folder_to_images_table',1),
(25,'2020_11_15_144200_add_draft_to_works_table',1),
(26,'2020_11_15_152246_add_defaults_to_works_table',1),
(27,'2021_01_24_150939_create_comments_table',1),
(28,'2021_05_04_202823_add_depth_to_comments_table',1),
(29,'2021_06_11_184950_add_published_at_to_works_table_remove_draft',1),
(30,'2021_07_08_172847_create_votes_table',1),
(31,'2021_07_10_212045_add_rating_to_comments_table',1),
(32,'2021_07_10_212637_add_default_to_rating_in_comments_table',1),
(33,'2021_08_01_170655_create_follows_table',1),
(34,'2021_08_15_142819_create_blacklists_table',1),
(35,'2021_08_16_160148_create_feedback_table',1),
(36,'2021_08_21_173316_alter_feedback_table',1),
(37,'2021_08_30_203107_make_category_null_in_feedback_table',1),
(38,'2021_08_31_134541_add_relations_to_feedback_table',1),
(39,'2021_09_06_185354_add_approved_at_to_feedback_table',1),
(40,'2021_10_16_145136_add_country_to_users_table',1),
(41,'2021_10_16_154232_create_user_ratings_table',1),
(42,'2021_10_30_123652_add_language_to_user_ratings_table',1),
(43,'2021_11_25_100000_create_telescope_entries_table',1),
(44,'2021_11_30_160328_add_show_per_language_to_works_table',1),
(45,'2021_12_01_135833_add_sizes_to_images_table',1),
(46,'2021_12_06_140804_create_feeds_table',1),
(47,'2021_12_10_114728_soft_deletes_works_table',1),
(48,'2022_01_05_163713_create_blogs_table',1),
(49,'2022_01_05_164257_create_posts_table',1),
(50,'2022_01_05_175814_create_post_translations',1),
(51,'2022_01_05_175824_create_blog_translations',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ownables`
--

DROP TABLE IF EXISTS `ownables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ownables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `ownable_id` bigint(20) NOT NULL,
  `ownable_type` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ownables_ownable_id_ownable_type_index` (`ownable_id`,`ownable_type`),
  KEY `ownables_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ownables`
--

LOCK TABLES `ownables` WRITE;
/*!40000 ALTER TABLE `ownables` DISABLE KEYS */;
INSERT INTO `ownables` VALUES
(1,1,1,'work'),
(2,2,2,'work'),
(3,3,3,'work'),
(4,4,4,'work'),
(5,5,5,'work'),
(6,6,6,'work'),
(7,7,7,'work'),
(8,8,8,'work'),
(9,9,9,'work'),
(10,10,10,'work'),
(11,11,11,'work'),
(12,12,12,'work'),
(13,13,13,'work'),
(14,14,14,'work'),
(15,15,15,'work'),
(16,16,16,'work'),
(17,17,17,'work'),
(18,18,18,'work'),
(19,19,19,'work'),
(20,20,20,'work'),
(21,21,21,'work'),
(22,22,22,'work'),
(23,23,23,'work'),
(24,24,24,'work'),
(25,25,25,'work'),
(26,26,26,'work'),
(27,27,27,'work'),
(28,28,28,'work'),
(29,29,29,'work'),
(30,30,30,'work'),
(31,31,31,'work'),
(32,32,32,'work'),
(33,33,33,'work'),
(34,34,34,'work'),
(35,35,35,'work'),
(36,36,36,'work'),
(37,37,37,'work'),
(38,38,38,'work'),
(39,39,39,'work'),
(40,40,40,'work'),
(41,41,41,'work'),
(42,42,42,'work'),
(43,43,43,'work'),
(44,44,44,'work'),
(45,45,45,'work'),
(46,46,46,'work'),
(47,47,47,'work'),
(48,48,48,'work'),
(49,49,49,'work'),
(50,50,50,'work'),
(51,51,51,'work'),
(52,52,52,'work'),
(53,53,53,'work'),
(54,54,54,'work'),
(55,55,55,'work'),
(56,56,56,'work'),
(57,57,57,'work'),
(58,58,58,'work'),
(59,59,59,'work'),
(60,60,60,'work'),
(61,61,61,'work'),
(62,62,62,'work'),
(63,63,63,'work'),
(64,64,64,'work'),
(65,65,65,'work'),
(66,66,66,'work'),
(67,67,67,'work'),
(68,68,68,'work'),
(69,69,69,'work'),
(70,70,70,'work'),
(71,71,71,'work'),
(72,72,72,'work'),
(73,73,73,'work'),
(74,74,74,'work'),
(75,75,75,'work'),
(76,76,76,'work'),
(77,77,77,'work'),
(78,78,78,'work'),
(79,79,79,'work'),
(80,80,80,'work'),
(81,81,81,'work'),
(82,82,82,'work'),
(83,83,83,'work'),
(84,84,84,'work'),
(85,85,85,'work'),
(86,86,86,'work'),
(87,87,87,'work'),
(88,88,88,'work'),
(89,89,89,'work'),
(90,90,90,'work'),
(91,91,91,'work'),
(92,92,92,'work'),
(93,93,93,'work'),
(94,94,94,'work'),
(95,95,95,'work'),
(96,96,96,'work'),
(97,97,97,'work'),
(98,98,98,'work'),
(99,99,99,'work'),
(100,100,100,'work');
/*!40000 ALTER TABLE `ownables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_translations`
--

DROP TABLE IF EXISTS `post_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `language` char(2) NOT NULL,
  `title` varchar(191) NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`body`)),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_translations_post_id_language_unique` (`post_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_translations`
--

LOCK TABLES `post_translations` WRITE;
/*!40000 ALTER TABLE `post_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_blog_id_index` (`blog_id`),
  KEY `posts_rating_index` (`rating`),
  KEY `posts_comments_index` (`comments`),
  KEY `posts_published_at_index` (`published_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_items`
--

DROP TABLE IF EXISTS `subscription_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint(20) unsigned NOT NULL,
  `stripe_id` varchar(191) NOT NULL,
  `stripe_product` varchar(191) NOT NULL,
  `stripe_price` varchar(191) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_subscription_id_stripe_price_unique` (`subscription_id`,`stripe_price`),
  UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_items`
--

LOCK TABLES `subscription_items` WRITE;
/*!40000 ALTER TABLE `subscription_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `stripe_id` varchar(191) NOT NULL,
  `stripe_status` varchar(191) NOT NULL,
  `stripe_price` varchar(191) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_groups`
--

DROP TABLE IF EXISTS `tag_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_groups`
--

LOCK TABLES `tag_groups` WRITE;
/*!40000 ALTER TABLE `tag_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_titles`
--

DROP TABLE IF EXISTS `tag_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_titles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) NOT NULL,
  `language` char(2) NOT NULL,
  `title` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag_titles_tag_id_language_index` (`tag_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_titles`
--

LOCK TABLES `tag_titles` WRITE;
/*!40000 ALTER TABLE `tag_titles` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_types`
--

DROP TABLE IF EXISTS `tag_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) DEFAULT NULL,
  `max_tags` smallint(6) DEFAULT NULL,
  `allow_user_input` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_types`
--

LOCK TABLES `tag_types` WRITE;
/*!40000 ALTER TABLE `tag_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taggables`
--

DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taggables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint(20) NOT NULL,
  `taggable_id` bigint(20) NOT NULL,
  `taggable_type` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `taggables_taggable_type_index` (`taggable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taggables`
--

LOCK TABLES `taggables` WRITE;
/*!40000 ALTER TABLE `taggables` DISABLE KEYS */;
/*!40000 ALTER TABLE `taggables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned DEFAULT NULL,
  `group_id` bigint(20) unsigned DEFAULT NULL,
  `groups_main` tinyint(1) NOT NULL DEFAULT 0,
  `type_id` bigint(20) unsigned NOT NULL,
  `old_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(191) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_family_hash_index` (`family_hash`),
  KEY `telescope_entries_created_at_index` (`created_at`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(191) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`,`tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(191) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_ratings`
--

DROP TABLE IF EXISTS `user_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ratable_type` varchar(191) NOT NULL,
  `ratable_id` bigint(20) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `language` char(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_ratings_ratable_type_ratable_id_user_id_language_unique` (`ratable_type`,`ratable_id`,`user_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_ratings`
--

LOCK TABLES `user_ratings` WRITE;
/*!40000 ALTER TABLE `user_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `old_id` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) DEFAULT NULL,
  `pm_type` varchar(191) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `image_id` bigint(20) DEFAULT NULL,
  `country` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_stripe_id_index` (`stripe_id`),
  KEY `users_country_index` (`country`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Everette Wolff','sparker@example.com','2023-02-23 22:17:48','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','okreiger',NULL,'VqaeU5JcDg','2023-02-23 22:17:48','2023-02-23 22:17:48',NULL,NULL,NULL,NULL,101,'MS'),
(2,'Dr. Dallin Cassin Sr.','kcarter@example.org','2023-02-23 22:17:48','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jace.legros',NULL,'UjEJHqxmlo','2023-02-23 22:17:48','2023-02-23 22:17:48',NULL,NULL,NULL,NULL,102,'MA'),
(3,'Maynard Koepp','retha86@example.net','2023-02-23 22:17:48','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','pokon',NULL,'cHWf9ZpGZg','2023-02-23 22:17:48','2023-02-23 22:17:48',NULL,NULL,NULL,NULL,103,'BY'),
(4,'Daniela Hilpert','alison96@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','zrutherford',NULL,'3cBxxmhpAp','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,104,'SH'),
(5,'Maximilian Prosacco','robin.hartmann@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bfritsch',NULL,'iwFHsJg6FO','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,105,'MT'),
(6,'Emely Goldner','lurline59@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rquigley',NULL,'c3odekYozi','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,106,'NP'),
(7,'Cruz Lemke','domenic.prohaska@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','onie.dickinson',NULL,'VCPObFj39H','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,107,'CH'),
(8,'Milford Cremin','brittany60@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','issac33',NULL,'0HW16D0vpe','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,108,'AX'),
(9,'Laurel Koch','fhickle@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','fbahringer',NULL,'toQS4CJyG7','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,109,'TC'),
(10,'Lafayette Schultz','zschaden@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','arturo.murazik',NULL,'6mrbxaZ2dp','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,110,'SA'),
(11,'Madie Muller DVM','fahey.verna@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jennings.cruickshank',NULL,'cztOZFUQXs','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,111,'RE'),
(12,'Maryam Gutkowski','pfannerstill.gene@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','wisozk.kolby',NULL,'VRiB96XyOU','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,112,'NA'),
(13,'Lambert Moen','nola73@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','francisca.parker',NULL,'CEJKUyriVQ','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,113,'BJ'),
(14,'Prof. Dedrick Runolfsdottir Jr.','mnolan@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','destini.gerlach',NULL,'EApOCFywjc','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,114,'CY'),
(15,'Dr. Giovanni Rowe III','louvenia80@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','dietrich.kole',NULL,'65Qk6wf0rF','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,115,'BF'),
(16,'Justen Davis','bruen.jaeden@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','wschultz',NULL,'FYQRL1mePU','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,116,'SX'),
(17,'Mr. Angus Wolff II','claire.bernhard@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rbechtelar',NULL,'Ol2JVEFizW','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,117,'AO'),
(18,'Prof. Fidel DuBuque','trent.schmeler@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rodriguez.shania',NULL,'0kpkVMJk6t','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,118,'TT'),
(19,'Dr. Janie Aufderhar','jacobi.anna@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ytremblay',NULL,'8zblyY3YND','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,119,'PW'),
(20,'Annamae Skiles PhD','narciso48@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ekoch',NULL,'phmgaUB8yV','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,120,'TG'),
(21,'Glenda Hudson DDS','collier.tom@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jfeil',NULL,'wAI2lqEaPx','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,121,'BT'),
(22,'Sedrick Lakin','randi70@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','delores.hane',NULL,'JMcLmhGQnN','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,122,'TJ'),
(23,'Torrance Wisozk','ramona11@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ilittel',NULL,'FhW93stbOf','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,123,'PY'),
(24,'Prof. Jovanny O\'Reilly II','vida55@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','moen.keenan',NULL,'y6dNK0oQMf','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,124,'EG'),
(25,'Lindsay Carter','eulalia53@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','igaylord',NULL,'67yuoPFaZL','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,125,'SA'),
(26,'Adonis Leuschke','shyanne.gislason@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ritchie.einar',NULL,'1LziiqHHYZ','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,126,'RS'),
(27,'Isai Runolfsson','buford34@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','leannon.ayden',NULL,'sTMD0a4Nke','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,127,'TZ'),
(28,'Louvenia Williamson','colleen24@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','angie.moore',NULL,'szwA45Y5hY','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,128,'NU'),
(29,'Miss Hildegard Marquardt','madie83@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','huels.dale',NULL,'XUhSklBzaC','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,129,'DE'),
(30,'Garrick Haley','veum.rosemarie@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','fcremin',NULL,'Y5kmNc8uVY','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,130,'DE'),
(31,'Yessenia Huels IV','whitney.hirthe@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','schmeler.weston',NULL,'x4Qw56go3w','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,131,'MC'),
(32,'Filomena Corwin','jmitchell@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','taurean75',NULL,'n7uuoJ5ocl','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,132,'HK'),
(33,'Ahmad Casper','mpadberg@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','russ.becker',NULL,'s4CZhA7Q3a','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,133,'AX'),
(34,'Marques Thompson','weimann.roselyn@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','lgutkowski',NULL,'gbjda7JNPM','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,134,'VI'),
(35,'Dr. Camylle Crist DVM','vwatsica@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','waelchi.santiago',NULL,'WLpTKEclpL','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,135,'IQ'),
(36,'Coleman Labadie','pkihn@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','mmurray',NULL,'O7RAVHZu1T','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,136,'TN'),
(37,'Orrin Kulas IV','kassulke.joy@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','white.aniya',NULL,'QzXASe1G6Y','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,137,'PH'),
(38,'Prof. Marquis Kassulke','dolores57@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','lang.alanis',NULL,'A7GBRDImKj','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,138,'PL'),
(39,'Marcella Beatty','jeremy.wisozk@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','nat26',NULL,'jJnKnR8ub3','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,139,'VI'),
(40,'Nico Auer Jr.','marisol.ullrich@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rdoyle',NULL,'8Z661iIhtz','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,140,'CX'),
(41,'Landen Gulgowski PhD','garrett07@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bosco.alda',NULL,'1Y8iN8aetQ','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,141,'UA'),
(42,'Patricia Zboncak','gleason.sadye@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bjerde',NULL,'2Yd60YAVLM','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,142,'VU'),
(43,'Harmon Hoeger','tiana88@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bkihn',NULL,'57niwLtavK','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,143,'UY'),
(44,'Roosevelt Dickinson','tkiehn@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','daija78',NULL,'GUM4NS64bW','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,144,'SV'),
(45,'Dr. Walker Boyer I','angelita.ferry@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','carlie95',NULL,'bwXhTElTYr','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,145,'AD'),
(46,'Pierre Renner','carlee.wilderman@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','hansen.raheem',NULL,'nvS6SSxqc9','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,146,'ES'),
(47,'Dr. Vernie Wintheiser','jevon.schulist@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','schroeder.otilia',NULL,'tbLl3Y8HLB','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,147,'WS'),
(48,'Dr. Ricky Toy III','baylee.gerhold@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rahul08',NULL,'xRkUy15ooh','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,148,'GD'),
(49,'Mossie Aufderhar','wisozk.myrtle@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','oabshire',NULL,'ZkasyOKAcv','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,149,'TW'),
(50,'Rubye Kemmer','fwisoky@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','brobel',NULL,'Kjc9kAcSoL','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,150,'MC'),
(51,'Mariah Barrows II','ckessler@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ciara08',NULL,'JkbqOFiBfX','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,151,'GU'),
(52,'Name McCullough','kjast@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','adolphus42',NULL,'BfqjxFT3Sf','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,152,'OM'),
(53,'Wayne Feeney','handerson@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','dmayer',NULL,'EtM0bDR0oF','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,153,'TK'),
(54,'Ona Grimes','ullrich.ansel@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','camden.mohr',NULL,'kbIAEt2noq','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,154,'PG'),
(55,'Prof. Nicolas Pacocha DVM','kassandra.emard@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','brook85',NULL,'sfgvH1gjjT','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,155,'IO'),
(56,'Davon Ebert','ellen.funk@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','schmitt.kasey',NULL,'pnm6uOYXOo','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,156,'BR'),
(57,'Mr. Oliver Parker Sr.','mmosciski@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','hluettgen',NULL,'k4AoPRM84E','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,157,'CN'),
(58,'Brenna Fahey','schowalter.jade@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','mohammed.hahn',NULL,'GOXm3YtpLV','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,158,'GW'),
(59,'Lou Corwin Jr.','white.reece@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','uupton',NULL,'STUPUwNlvx','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,159,'CF'),
(60,'Dovie Feest','pedro.oconner@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','daugherty.trisha',NULL,'T5NUdJuwQy','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,160,'JE'),
(61,'Mr. Gerardo Blick V','wfritsch@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','mwalker',NULL,'oejCrfvmRa','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,161,'ER'),
(62,'Mrs. Madisyn Lindgren','laurie57@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ellie.wuckert',NULL,'ha2LZTEeme','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,162,'CX'),
(63,'Kimberly Gusikowski','elise80@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','violet54',NULL,'qeiUSF4U6W','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,163,'SY'),
(64,'Deborah Halvorson PhD','grover64@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','linnea.bruen',NULL,'xGyaIfLBwf','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,164,'CX'),
(65,'Miss Nellie Lakin DDS','marvin.lane@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','arnaldo36',NULL,'MKJ9SLBlOL','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,165,'BN'),
(66,'Dr. Hester Klocko','cartwright.ola@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','zoey.streich',NULL,'oZeRpSi9Nb','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,166,'CH'),
(67,'Kelsi Welch','alva.ullrich@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','imogene.gerlach',NULL,'Ox5JvxSyBy','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,167,'SZ'),
(68,'Miss Virgie Willms V','chauncey18@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','wprice',NULL,'0vFJ9NlgRY','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,168,'MQ'),
(69,'Christelle D\'Amore','hermann.roger@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','brandyn.thompson',NULL,'hkVSxw1jyC','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,169,'ES'),
(70,'Mr. Luciano Jaskolski II','jjacobson@example.org','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','enola.mcglynn',NULL,'PiP9M2FrQA','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,170,'CX'),
(71,'Earnestine Lind','ardith.glover@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','lamar.stoltenberg',NULL,'Z3FOnrO1Qj','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,171,'TN'),
(72,'Katlyn Bogan','gregorio88@example.com','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jamil06',NULL,'Vxvo6yg1xb','2023-02-23 22:17:49','2023-02-23 22:17:49',NULL,NULL,NULL,NULL,172,'CL'),
(73,'Marcellus Johnson','anya48@example.net','2023-02-23 22:17:49','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','darius05',NULL,'89CFTFsBgH','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,173,'DM'),
(74,'Prof. Darrell Grimes IV','christiansen.clarissa@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','maddison.stiedemann',NULL,'vzs9pY3BYk','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,174,'VI'),
(75,'Jameson Casper II','charlotte31@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ignatius.hilll',NULL,'ML8YIqFrfU','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,175,'MF'),
(76,'Maymie Franecki','emmerich.demetris@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','khilll',NULL,'BeiVbb0P2y','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,176,'ET'),
(77,'Ernestine McLaughlin','tromp.sonya@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','rpagac',NULL,'gdmpvqoZTl','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,177,'ZM'),
(78,'Madie Stroman','bpfeffer@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','abigayle67',NULL,'ffX1YzYD2e','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,178,'GQ'),
(79,'Landen Wyman','kemmer.elda@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','elenor38',NULL,'GPdwV982vs','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,179,'TH'),
(80,'Jimmie Schuster Sr.','jude63@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','nitzsche.edd',NULL,'KMWqD1Mly9','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,180,'KM'),
(81,'Patience Senger','bridie.nader@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','nienow.gregoria',NULL,'UXTs9Je4wv','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,181,'MO'),
(82,'Reese Turner','kasandra06@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','yoshiko04',NULL,'5IGNtxyJ69','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,182,'LU'),
(83,'Matilda Bosco Sr.','theodora44@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','scassin',NULL,'ifIOhJVQf1','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,183,'EE'),
(84,'Miss Marlene Schoen','garth33@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bartell.crystel',NULL,'nxyzwJDanP','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,184,'TR'),
(85,'Mr. Solon Thiel','jan.bayer@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','xlakin',NULL,'vRtX4RPqEH','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,185,'GW'),
(86,'Carmela Halvorson Jr.','horace.kessler@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','von.collin',NULL,'YNrE2O9JzR','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,186,'MY'),
(87,'Horacio Mosciski Sr.','marcella.heidenreich@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','harber.arianna',NULL,'WMyVHQlsLY','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,187,'AS'),
(88,'Prof. Libby Langworth','schmitt.kamron@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jace87',NULL,'dMdghYbQXC','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,188,'TJ'),
(89,'Rowland Beatty II','houston98@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','gussie.cremin',NULL,'2TyXdxnCuZ','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,189,'RE'),
(90,'Camren Zieme','hudson17@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','presley.mcdermott',NULL,'xGHd8qubAd','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,190,'CC'),
(91,'Dr. Jade Marquardt','dcasper@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','eliza.schneider',NULL,'rOc0bbQpqD','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,191,'FO'),
(92,'Reyna Grimes IV','durgan.gilberto@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jayson55',NULL,'d8Ck6YNsI2','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,192,'PS'),
(93,'Dr. Kennith Zboncak','ihudson@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','lcrona',NULL,'q5ZPHBezyb','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,193,'NO'),
(94,'Myrl Torp','dkshlerin@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','qluettgen',NULL,'8ovOAYorc3','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,194,'TC'),
(95,'Vicenta Schuster PhD','mitchell.sammy@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jadyn19',NULL,'4nn1JyXNIh','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,195,'PT'),
(96,'Tremaine Hills','hauck.karley@example.org','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','xlueilwitz',NULL,'rGcul3dUUG','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,196,'IE'),
(97,'Mr. Leland Jacobson III','caroline.rutherford@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ydaniel',NULL,'YxlTqqs1sR','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,197,'AE'),
(98,'Taryn Goodwin','dach.scarlett@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','nader.guy',NULL,'HNm1AKbiBt','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,198,'GY'),
(99,'Stella Beer','sonia.kling@example.com','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','lfritsch',NULL,'co5M6eTiFd','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,199,'TV'),
(100,'Ms. Pauline Kerluke','abdul.gleichner@example.net','2023-02-23 22:17:50','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','wendy46',NULL,'Yqc7fE4PXi','2023-02-23 22:17:50','2023-02-23 22:17:50',NULL,NULL,NULL,NULL,200,'TW');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `votes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `votable_type` varchar(191) NOT NULL,
  `votable_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `vote` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_blocks`
--

DROP TABLE IF EXISTS `work_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_blocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` bigint(20) NOT NULL,
  `language` char(2) NOT NULL,
  `type` varchar(191) NOT NULL,
  `order` int(11) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_blocks_work_id_language_index` (`work_id`,`language`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_blocks`
--

LOCK TABLES `work_blocks` WRITE;
/*!40000 ALTER TABLE `work_blocks` DISABLE KEYS */;
INSERT INTO `work_blocks` VALUES
(1,1,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(2,1,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0421\\u0442\\u0438\\u0448\\u0438\\u043b\\u043e\\u0441\\u044c \\u0434\\u043e\\u0432\\u043a\\u043e\\u043b\\u0430 \\u0431\\u043e\\u044f\\u0440\\u0441\\u044c\\u043a\\u043e\\u0433\\u043e \\u0434\\u043e\\u043c\\u0443, \\u0432\\u0441\\u0435 \\u0437 \\u0437\\u0430\\u0446\\u0456\\u043a\\u0430\\u0432\\u043b\\u0435\\u043d\\u043d\\u044f\\u043c \\u043e\\u0433\\u043b\\u044f\\u0434\\u0430\\u044e\\u0447\\u0438, \\u0445\\u043e\\u0447 \\u043d\\u0456\\u0447\\u043e\\u0433\\u043e \\u043d\\u0435 \\u0442\\u0438\\u043a\\u0430\\u044e\\u0447\\u0438. \\u0417 \\u0441\\u0435\\u0440\\u0434\\u0435\\u0447\\u043d\\u0438\\u043c \\u0442\\u0440\\u0435\\u043f\\u0435\\u0442\\u043e\\u043c \\u043d\\u0430\\u0431\\u043b\\u0438\\u0436\\u0430\\u0432\\u0441\\u044f \\u041c\\u0430\\u043a\\u0441\\u0438\\u043c \\u0434\\u043e \\u0441\\u0432\\u0456\\u0442\\u043b\\u0438\\u0446\\u0456 \\u041c\\u0438\\u0440\\u043e\\u0441\\u043b\\u0430\\u0432\\u0438, \\u043d\\u0430\\u0434\\u0456\\u044e\\u0447\\u0438\\u0441\\u044c \\u0442\\u0443\\u0442 \\u0441\\u0442\\u0440\\u0456\\u0442\\u0438\\u0442\\u0438 \\u0457\\u0457 \\u0432 \\u0441\\u043b\\u044c\\u043e\\u0437\\u0430\\u0445 \\u0430\\u0431\\u043e \\u0432.\"}]}','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(3,1,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(4,2,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(5,2,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0427\\u0456\\u043d\\u0433\\u0456\\u0441\\u0445\\u0430\\u043d, \\u0432\\u0438\\u043f\\u0440\\u0430\\u0432\\u043b\\u044f\\u044e\\u0447\\u0438 \\u043d\\u0430\\u0441 \\u043d\\u0430 \\u0437\\u0430\\u0445\\u0456\\u0434, \\u0434\\u043e \\u043a\\u0440\\u0430\\u044e \\u0440\\u0430\\u0431\\u0456\\u0432 \\u0441\\u0432\\u043e\\u0457\\u0445 \\u0410\\u0440\\u043f\\u0430\\u0434\\u0456\\u0432, \\u043d\\u0430\\u043a\\u0430\\u0437\\u0443\\u0432\\u0430\\u0432 \\u043d\\u0430\\u043c \\u0434\\u043e\\u0432\\u0448\\u0435 \\u0442\\u0440\\u044c\\u043e\\u0445 \\u0434\\u0435\\u043d\\u044c \\u0431\\u0435\\u0437 \\u043f\\u043e\\u0442\\u0440\\u0435\\u0431\\u0438 \\u043d\\u0456\\u0434\\u0435 \\u043d\\u0435 \\u0437\\u0430\\u0434\\u0435\\u0440\\u0436\\u0443\\u0432\\u0430\\u0442\\u0438\\u0441\\u044c. \\u0411\\u0440\\u0430\\u0442 \\u043d\\u0430\\u0448, \\u041a\\u0430\\u0439\\u0434\\u0430\\u043d-\\u0431\\u0435\\u0433\\u0430\\u0434\\u0438\\u0440, \\u0449\\u043e \\u043f\\u0456\\u0448\\u043e\\u0432 \\u0447\\u0435\\u0440\\u0435\\u0437 \\u043a\\u0440\\u0430\\u0439 \\u0432\\u043e\\u043b\\u043e\\u0445\\u0456\\u0432, \\u0431\\u0443\\u0434\\u0435 \\u043f\\u0435\\u0440\\u0435\\u0434.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(6,2,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(7,3,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(8,3,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0410 \\u0445\\u0442\\u043e \\u0432\\u0435\\u043b\\u0456\\u0432 \\u0442\\u043e\\u0431\\u0456 \\u0439\\u0442\\u0438 \\u0441\\u044e\\u0434\\u0438? - \\u041c\\u0456\\u0439 \\u0456 \\u0432\\u0430\\u0448 \\u043f\\u0430\\u043d \\u043a\\u043d\\u044f\\u0437\\u044c \\u0414\\u0430\\u043d\\u0438\\u043b\\u043e \\u043f\\u0440\\u043e\\u043f\\u0430\\u0432 \\u0434\\u0435\\u0441\\u044c \\u0431\\u0435\\u0437\\u0432\\u0456\\u0441\\u0442\\u0438. \\u0417\\u0430\\u043c\\u0456\\u0441\\u0442\\u044c \\u043e\\u0431\\u0435\\u0440\\u043d\\u0443\\u0442\\u0438\\u0441\\u044f \\u0434\\u043e \\u0441\\u0432\\u043e\\u0433\\u043e \\u0448\\u0430\\u0442\\u0440\\u0430 \\u043d\\u0430 \\u0432\\u043e\\u0454\\u043d\\u043d\\u0443 \\u0440\\u0430\\u0434\\u0443. \\u041f\\u0435\\u0440\\u0448\\u0438\\u0439 \\u0437\\u0430\\u0431\\u0440\\u0430\\u0432 \\u0433\\u043e\\u043b\\u043e\\u0441 \\u041f\\u0435\\u0442\\u0430, \\u0433\\u043e\\u043b\\u043e\\u0432\\u043d\\u0438\\u0439 \\u043d\\u0430\\u0447\\u0430\\u043b\\u044c\\u043d\\u0438\\u043a \\u0441\\u044c\\u043e\\u0433\\u043e \\u0432\\u0456\\u0434\\u0434\\u0456\\u043b\\u0443, \\u0447\\u043e\\u043b\\u043e\\u0432\\u0456\\u0447\\u043e\\u043a.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(9,3,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(10,4,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(11,4,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0422\\u0443\\u0445\\u043e\\u043b\\u044c\\u0449\\u0438\\u043d\\u0438 \\u0443\\u0434\\u0430\\u0432\\u0430\\u0442\\u0438\\u0441\\u044f \\u043d\\u0435 \\u043c\\u043e\\u0436\\u043d\\u0430. \\u0428\\u043b\\u044f\\u0445 \\u043d\\u0430\\u0448 \\u043f\\u0440\\u0438 \\u0432\\u0430\\u0448\\u0456\\u0439 \\u043f\\u043e\\u043c\\u043e\\u0447\\u0456, - \\u0447\\u0435\\u0441\\u043d\\u0456 \\u0437\\u0430\\u0433\\u0456\\u0440\\u043d\\u0456 \\u0433\\u0440\\u043e\\u043c\\u0430\\u0434\\u044f\\u043d\\u0438, \\u043c\\u0438 \\u0447\\u0435\\u043d\\u044c \\u043e\\u0431\\u043e\\u0440\\u043e\\u043d\\u0438\\u043c\\u043e. \\u0410\\u043b\\u0435 \\u0456\\u043d\\u0448\\u0438\\u0445 \\u0448\\u043b\\u044f\\u0445\\u0456\\u0432 \\u043c\\u0438 - \\u043d\\u0435\\u0449\\u0430\\u0441\\u043b\\u0438\\u0432\\u0456,\\u0430 \\u0447\\u0438 \\u0434\\u043b\\u044f \\u0442\\u043e\\u0433\\u043e \\u043d\\u0435 \\u0432\\u0438\\u0445\\u043e\\u0434\\u0438\\u0442\\u044c, - \\u0449\\u043e\\u0431 \\u043f\\u043e\\u0437\\u0433\\u0430\\u043d\\u044f\\u0442\\u0438 \\u0457\\u0445 \\u0456\\u0437 \\u043d\\u0430\\u0439\\u043a\\u0440\\u0430\\u0449\\u043e\\u0457.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(12,4,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(13,5,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(14,5,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0422\\u043e \\u0441\\u0435 \\u0442\\u0432\\u0456\\u0439 \\u0431\\u0430\\u0442\\u044c\\u043a\\u043e \\u0431\\u0443\\u043d\\u0442\\u0443\\u0454 \\u0442\\u0443\\u0445\\u043e\\u043b\\u044c\\u0446\\u0456\\u0432 \\u043f\\u0440\\u043e\\u0442\\u0438\\u0432 \\u043c\\u0435\\u043d\\u0435 \\u0456 \\u0432\\u0435\\u043b\\u0438\\u043a\\u043e\\u0433\\u043e \\u0427\\u0456\\u043d\\u0433\\u0456\\u0441\\u0445\\u0430\\u043d\\u0430, \\u0431\\u0430\\u0447\\u0438\\u0442\\u044c\\u0441\\u044f, - \\u0437\\u0430\\u044f\\u0447\\u0435 \\u0441\\u0435\\u0440\\u0446\\u0435 \\u043c\\u0430\\u0454: \\u0440\\u043e\\u0437\\u0436\\u0435\\u043d\\u0435\\u0442\\u044c\\u0441\\u044f \\u0456 \\u0432\\u0456\\u0434\\u0441\\u0442\\u0443\\u043f\\u0438\\u0442\\u044c! \\u0425\\u0456\\u0431\\u0430 \\u0436 \\u0442\\u0438 \\u0442\\u0430\\u043a \\u0447\\u0430\\u0441\\u0442\\u043e \\u0441\\u0432\\u043e\\u0457\\u043c \\u044f\\u0441\\u043d\\u0438\\u043c - \\u0443\\u0441\\u043c\\u0456\\u0445\\u043e\\u043c \\u0432\\u0456\\u0442\\u0430\\u043b\\u043e \\u0434\\u043d\\u0456 \\u043c\\u043e\\u0454\\u0457 \\u0440\\u0430\\u0434\\u043e\\u0441\\u0442\\u0456 \\u043d\\u0430 \\u0442\\u0435.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(15,5,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(16,6,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(17,6,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0421\\u0442\\u0440\\u0438\\u044e \\u0432 \\u043d\\u0430\\u0448\\u0456 \\u0441\\u0442\\u043e\\u0440\\u043e\\u043d\\u0438. \\u041f\\u0440\\u0430\\u0432\\u0434\\u0430, \\u0431\\u043e\\u044f\\u0440\\u0438\\u043d\\u0435, \\u0449\\u043e \\u0441\\u0435 - \\u0437\\u043d\\u0430\\u043c\\u0435\\u043d\\u043e \\u043d\\u0430\\u0448\\u0435! \\u0417 \\u043e\\u0434\\u043d\\u043e\\u0433\\u043e \\u0437\\u0434\\u043e\\u0440\\u043e\\u0432\\u043e\\u0433\\u043e \\u043f\\u043d\\u044f \\u0432\\u0438\\u0440\\u043e\\u0431\\u043b\\u0435\\u043d\\u0438\\u0439 \\u0432\\u0435\\u0441\\u044c \\u0442\\u043e\\u0439 \\u0441\\u0443\\u0446\\u0456\\u043b\\u044c\\u043d\\u0438\\u0439 - \\u043b\\u0430\\u043d\\u0446\\u044e\\u0433, \\u0441\\u0438\\u043b\\u044c\\u043d\\u0438\\u0439 \\u0456 \\u043a\\u0440\\u0435\\u043c\\u0435\\u0437\\u043d\\u0438\\u0439. \\u041f\\u0440\\u0430\\u0432\\u0434\\u0430, \\u0432\\u0456\\u043d \\u0442\\u0432\\u0435\\u0440\\u0434\\u043e \\u0440\\u0456\\u0448\\u0438\\u0432\\u0441\\u044f \\u0437\\u0440\\u043e\\u0431\\u0438\\u0442\\u0438 \\u0441\\u0432\\u043e\\u0454 \\u0434\\u0456\\u043b\\u043e \\u044f\\u043a \\u043c\\u043e\\u0436\\u043d\\u0430.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(18,6,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(19,7,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(20,7,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0406 \\u0441\\u0435 \\u0434\\u043e\\u0431\\u0440\\u0435! \\u041d\\u0435\\u0445\\u0430\\u0439 \\u0457\\u0445 \\u0434\\u0443\\u0448\\u0430\\u0442\\u044c, \\u0442\\u0438\\u0445 \\u0445\\u0438\\u0442\\u0440\\u0438\\u0445 \\u043a\\u0440\\u0443\\u043a\\u0456\\u0432! \\u0410\\u043b\\u0435 \\u0431\\u043e\\u044f\\u0440\\u0438\\u043d\\u0430 \\u043d\\u0435 - \\u0434\\u043e\\u0432\\u0456\\u0440\\u044f\\u044e\\u0447\\u0438 \\u0457\\u0445 \\u0449\\u0438\\u0440\\u043e\\u0441\\u0442\\u0456, \\u043f\\u043e\\u0441\\u0442\\u0430\\u0432\\u0438\\u0432 \\u0443 \\u0440\\u044f\\u0434\\u0438 \\u0432\\u0441\\u0443\\u043c\\u0456\\u0448 \\u0456\\u0437 \\u0442\\u0443\\u0445\\u043e\\u043b\\u044c\\u0446\\u044f\\u043c\\u0438. - \\u0422\\u0430\\u043a, \\u043a\\u0430\\u0436\\u0435\\u0448, \\u043c\\u043e\\u043d\\u0433\\u043e\\u043b\\u0438 \\u0433\\u0440\\u043e\\u0437\\u044f\\u0442\\u044c \\u043d\\u0430\\u043f\\u0430\\u0434\\u043e\\u043c \\u0456 \\u043e\\u0442\\u0441\\u0438\\u043c \\u0433\\u043e\\u0440\\u0430\\u043c? \\u0417\\u0430\\u0445\\u0430\\u0440 \\u044f\\u043a\\u043e\\u0441\\u044c \\u0437\\u043d\\u0430\\u0447\\u0443\\u0447\\u043e.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(21,7,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(22,8,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(23,8,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0422\\u0443\\u0442, \\u044f\\u043a \\u0442\\u0432\\u0435\\u0440\\u0434\\u0438\\u0432 \\u0442\\u0443\\u0445\\u043e\\u043b\\u044c\\u0441\\u044c\\u043a\\u0438\\u0439 \\u043f\\u0440\\u043e\\u0432\\u0456\\u0434\\u043d\\u0438\\u043a, \\u043c\\u043e\\u043b\\u043e\\u0434\\u0438\\u0439 \\u0433\\u0456\\u0440\\u043d\\u044f\\u043a \\u041c\\u0430\\u043a\\u0441\\u0438\\u043c \\u0411\\u0435\\u0440\\u043a\\u0443\\u0442, \\u0430 \\u0437\\u0430 \\u043d\\u0438\\u043c \\u0442\\u0440\\u0435\\u0431\\u0430 \\u043d\\u0430\\u0434\\u0456\\u044f\\u0442\\u0438\\u0441\\u044c \\u0456\\u043d\\u0448\\u0438\\u0445. \\u0406 \\u0441\\u043f\\u0440\\u0430\\u0432\\u0434\\u0456, \\u043c\\u0456\\u0441\\u0446\\u0435 \\u0431\\u0443\\u043b\\u043e \\u043d\\u0435\\u0437\\u0432\\u0438\\u0447\\u0430\\u0439\\u043d\\u0435, \\u0434\\u0438\\u043a\\u0435. - \\u041f\\u043e\\u0442\\u0456\\u043a \\u0431\\u0443\\u0432 \\u0432\\u0443\\u0437\\u044c\\u043a\\u0438\\u0439, \\u043c\\u043e\\u0436\\u0435, \\u043d\\u0430 \\u0430\\u0440\\u043f\\u0430\\u0434\\u0441\\u044c\\u043a\\u0456\\u0439 \\u0441\\u0442\\u043e\\u0440\\u043e\\u043d\\u0456 \\u0442\\u0456 \\u0448\\u043b\\u044f\\u0445\\u0438.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(24,8,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(25,9,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(26,9,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0411\\u0438\\u0441\\u0442\\u0440\\u0438\\u043c \\u043e\\u043a\\u043e\\u043c \\u043e\\u043a\\u0438\\u043d\\u0443\\u043b\\u0430 \\u0432\\u043e\\u043d\\u0430 \\u043f\\u043e\\u043e\\u0432\\u043e\\u0434\\u0436\\u0430\\u044e\\u0447\\u0438\\u0445 \\u0457\\u0457 \\u0432\\u0430\\u0440\\u0442\\u043e\\u0432\\u0438\\u0445. \\u041d\\u0438\\u0437\\u044c\\u043a\\u0456, \\u043f\\u0456\\u0434\\u0441\\u0430\\u0434\\u043a\\u0443\\u0432\\u0430\\u0442\\u0456 \\u0457\\u0445 \\u043f\\u043e\\u0441\\u0442\\u0430\\u0432\\u0438, \\u043f\\u043e\\u0432\\u0431\\u0438\\u0440\\u0430\\u043d\\u0456 \\u0432 \\u043e\\u0432\\u0435\\u0447\\u0456 \\u043a\\u043e\\u0436\\u0443\\u0445\\u0438, \\u0447\\u0435\\u0440\\u0435\\u0437 \\u044f\\u043a\\u0456 \\u043f\\u0435\\u0440\\u0435\\u0432\\u0456\\u0448\\u0435\\u043d\\u0438\\u0439 \\u0431\\u0443\\u0432 \\u043b\\u0443\\u043a \\u0456 \\u0441\\u0430\\u0433\\u0430\\u0439\\u0434\\u0430\\u043a \\u0437\\u0456 \\u0441\\u0442\\u0440\\u0456\\u043b\\u0430\\u043c\\u0438, \\u0430 \\u0437\\u0430 \\u0433\\u0430\\u0440\\u043d\\u0438\\u043c \\u0448\\u043a\\u0456\\u0440\\u044f\\u043d\\u0438\\u043c \\u043f\\u043e\\u044f\\u0441\\u043e\\u043c, \\u0449\\u043e.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(27,9,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(28,10,'uk','image',1,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(29,10,'uk','text',2,'{\"ops\":[{\"insert\":\"\\u0417 \\u0437\\u0430\\u043b\\u043e\\u043c\\u0430\\u043d\\u0438\\u043c\\u0438 \\u0440\\u0443\\u043a\\u0430\\u043c\\u0438, \\u043e\\u0431\\u0440\\u0430\\u0437 \\u043d\\u0430\\u0439\\u0442\\u044f\\u0436\\u0447\\u043e\\u0433\\u043e \\u0433\\u043e\\u0440\\u044f \\u0456 \\u043d\\u0430\\u0439\\u0441\\u0442\\u0440\\u0430\\u0448\\u043d\\u0456\\u0448\\u043e\\u0457 \\u0442\\u0440\\u0438\\u0432\\u043e\\u0433\\u0438, \\u0441\\u0442\\u043e\\u044f\\u043b\\u0430 \\u041c\\u0438\\u0440\\u043e\\u0441\\u043b\\u0430\\u0432\\u0430 \\u043d\\u0430\\u0441\\u0435\\u0440\\u0435\\u0434 \\u0448\\u0430\\u0442\\u0440\\u0430 \\u043d\\u0456\\u043c\\u0430, \\u043f\\u0435\\u0440\\u0435\\u0445\\u0438\\u043b\\u0435\\u043d\\u0430 \\u043d\\u0430\\u043f\\u0435\\u0440\\u0435\\u0434, \\u0437 \\u043d\\u0435\\u0432\\u0435\\u043b\\u0438\\u0447\\u043a\\u0438\\u043c \\u0432\\u0456\\u0434\\u0434\\u0456\\u043b\\u043e\\u043c \\u0456 \\u0437\\u0430\\u0439\\u043d\\u044f\\u0442\\u0438 \\u0432\\u0445\\u0456\\u0434 \\u0442\\u043e\\u0433\\u043e \\u0448\\u043b\\u044f\\u0445\\u0443, \\u0437\\u0430\\u043a\\u0438\\u043c \\u0456\\u0449\\u0435 - \\u0442\\u0443\\u0445\\u043e\\u043b\\u044c-\\u0441\\u044c\\u043a\\u0456.\"}]}','2023-02-23 22:17:51','2023-02-23 22:17:51'),
(30,10,'uk','grid',2,'{\"margin\":0}','2023-02-23 22:17:51','2023-02-23 22:17:51');
/*!40000 ALTER TABLE `work_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_details`
--

DROP TABLE IF EXISTS `work_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` bigint(20) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `work_details_work_id_unique` (`work_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_details`
--

LOCK TABLES `work_details` WRITE;
/*!40000 ALTER TABLE `work_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_titles`
--

DROP TABLE IF EXISTS `work_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_titles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` bigint(20) NOT NULL,
  `language` char(2) NOT NULL,
  `title` char(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `work_titles_work_id_language_unique` (`work_id`,`language`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_titles`
--

LOCK TABLES `work_titles` WRITE;
/*!40000 ALTER TABLE `work_titles` DISABLE KEYS */;
INSERT INTO `work_titles` VALUES
(1,1,'uk','I used to read fairy-tales,.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(2,1,'en','Let me see: that would.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(3,2,'uk','King: \'however, it may kiss.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(4,2,'en','Caterpillar. \'I\'m afraid.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(5,3,'uk','Bill, I fancy--Who\'s to go.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(6,3,'en','Magpie began wrapping itself.','2023-02-23 22:17:48','2023-02-23 22:17:48'),
(7,4,'uk','March Hare was said to the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(8,4,'en','Pigeon in a low, trembling.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(9,5,'uk','I was a little way forwards.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(10,5,'en','Alice quietly said, just as.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(11,6,'uk','Who ever saw in my kitchen.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(12,6,'en','Mock Turtle would be quite.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(13,7,'uk','Owl, as a boon, Was kindly.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(14,7,'en','I mentioned before, And have.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(15,8,'uk','Hatter replied. \'Of course.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(16,8,'en','I shall think nothing of.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(17,9,'uk','Conqueror.\' (For, with all.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(18,9,'en','And how odd the directions.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(19,10,'uk','Cheshire Cat: now I shall.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(20,10,'en','At last the Dodo solemnly,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(21,11,'uk','I\'ll eat it,\' said the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(22,11,'en','Alice, a little of her.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(23,12,'uk','Alice went timidly up to the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(24,12,'en','Classics master, though. He.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(25,13,'uk','As soon as there was nothing.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(26,13,'en','The Dormouse had closed its.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(27,14,'uk','I THINK; or is it I can\'t.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(28,14,'en','I\'m sure she\'s the best cat.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(29,15,'uk','By the time they had any.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(30,15,'en','Caterpillar angrily, rearing.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(31,16,'uk','Let me think: was I the same.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(32,16,'en','Queen\'s ears--\' the Rabbit.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(33,17,'uk','Alice began telling them her.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(34,17,'en','I can\'t take more.\' \'You.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(35,18,'uk','Presently the Rabbit just.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(36,18,'en','It means much the most.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(37,19,'uk','Alice could only see her..','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(38,19,'en','Caterpillar called after.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(39,20,'uk','Come on!\' So they got thrown.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(40,20,'en','Mock Turtle replied in an.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(41,21,'uk','ALICE\'S RIGHT FOOT, ESQ..','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(42,21,'en','On various pretexts they all.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(43,22,'uk','The great question is,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(44,22,'en','Mock Turtle. \'Very much.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(45,23,'uk','Please, Ma\'am, is this New.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(46,23,'en','Rome, and Rome--no, THAT\'S.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(47,24,'uk','King said to the porpoise,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(48,24,'en','And welcome little fishes in.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(49,25,'uk','They had a wink of sleep.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(50,25,'en','I like being that person,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(51,26,'uk','Alice, rather alarmed at the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(52,26,'en','And the moral of that is,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(53,27,'uk','Mock Turtle, \'but if you\'ve.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(54,27,'en','Bill,\' thought Alice,).','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(55,28,'uk','Alice gently remarked;.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(56,28,'en','Queen, who were lying on the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(57,29,'uk','Number One,\' said Alice..','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(58,29,'en','XI. Who Stole the Tarts? The.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(59,30,'uk','Caterpillar. Alice thought.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(60,30,'en','White Rabbit cried out,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(61,31,'uk','Turtle.\' These words were.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(62,31,'en','Duchess said after a.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(63,32,'uk','This speech caused a.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(64,32,'en','King added in an encouraging.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(65,33,'uk','COULD grin.\' \'They all can,\'.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(66,33,'en','Alice like the wind, and the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(67,34,'uk','After a while she was now.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(68,34,'en','However, everything is queer.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(69,35,'uk','Alice sharply, for she felt.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(70,35,'en','Five and Seven said nothing,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(71,36,'uk','Wonderland, though she knew.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(72,36,'en','And she\'s such a dreadful.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(73,37,'uk','Alice. \'Then it ought to eat.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(74,37,'en','So they got thrown out to.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(75,38,'uk','I eat one of the month, and.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(76,38,'en','Come on!\' So they had to.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(77,39,'uk','Alice, and tried to fancy.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(78,39,'en','Alice thoughtfully: \'but.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(79,40,'uk','The Mouse did not quite like.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(80,40,'en','CHAPTER III. A Caucus-Race.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(81,41,'uk','She was a large dish of.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(82,41,'en','He moved on as he spoke. \'A.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(83,42,'uk','ME\' beautifully printed on.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(84,42,'en','The adventures first,\' said.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(85,43,'uk','Bill\'s got to grow larger.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(86,43,'en','King said to Alice. \'Only a.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(87,44,'uk','Alice, and she put it. She.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(88,44,'en','Will you, won\'t you, will.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(89,45,'uk','Alice had been wandering,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(90,45,'en','I never knew whether it.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(91,46,'uk','Mouse\'s tail; \'but why do.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(92,46,'en','What happened to you? Tell.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(93,47,'uk','And the muscular strength,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(94,47,'en','I believe.\' \'Boots and shoes.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(95,48,'uk','Latitude was, or Longitude.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(96,48,'en','Knave of Hearts, he stole.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(97,49,'uk','Alice, (she had grown so.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(98,49,'en','They\'re dreadfully fond of.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(99,50,'uk','Queen had never done such a.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(100,50,'en','Queen, who was peeping.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(101,51,'uk','Alice an excellent plan, no.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(102,51,'en','Latin Grammar, \'A mouse--of.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(103,52,'uk','Alice could not help.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(104,52,'en','I could not be denied, so.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(105,53,'uk','White Rabbit hurried by--the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(106,53,'en','She said the King. On this.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(107,54,'uk','PLEASE mind what you\'re at!\".','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(108,54,'en','March Hare interrupted,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(109,55,'uk','While the Owl had the door.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(110,55,'en','However, everything is.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(111,56,'uk','WILL do next! If they had to.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(112,56,'en','KNOW IT TO BE TRUE--\" that\'s.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(113,57,'uk','Alice replied, so eagerly.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(114,57,'en','Gryphon. \'It all came.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(115,58,'uk','ONE.\' \'One, indeed!\' said.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(116,58,'en','THAT direction,\' waving the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(117,59,'uk','THAT\'S the great question.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(118,59,'en','THIS size: why, I should be.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(119,60,'uk','Alice put down the middle,.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(120,60,'en','Tortoise--\' \'Why did you.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(121,61,'uk','March Hare moved into the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(122,61,'en','Hearts were seated on their.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(123,62,'uk','And the Gryphon at the end.\'.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(124,62,'en','I\'m perfectly sure I have.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(125,63,'uk','And mentioned me to.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(126,63,'en','But I\'ve got to the seaside.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(127,64,'uk','Mock Turtle, and to her.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(128,64,'en','King, \'and don\'t look at.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(129,65,'uk','Cat; and this was the Cat in.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(130,65,'en','By the use of a water-well,\'.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(131,66,'uk','I almost think I can listen.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(132,66,'en','Mock Turtle, \'they--you\'ve.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(133,67,'uk','However, she soon found an.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(134,67,'en','I don\'t believe it,\' said.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(135,68,'uk','I\'ll never go THERE again!\'.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(136,68,'en','Suddenly she came in sight.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(137,69,'uk','Her chin was pressed hard.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(138,69,'en','And here Alice began to.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(139,70,'uk','I can\'t put it in with the.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(140,70,'en','Gryphon. \'How the creatures.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(141,71,'uk','Mock Turtle. \'She can\'t.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(142,71,'en','Alice was very.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(143,72,'uk','Heads below!\' (a loud.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(144,72,'en','I\'ve finished.\' So they.','2023-02-23 22:17:49','2023-02-23 22:17:49'),
(145,73,'uk','Alice: \'--where\'s the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(146,73,'en','Hatter, and, just as well.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(147,74,'uk','Alice; \'and I do wonder what.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(148,74,'en','All the time they had any.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(149,75,'uk','I think?\' \'I had NOT!\' cried.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(150,75,'en','And she began nursing her.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(151,76,'uk','Alice. \'I\'ve read that in.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(152,76,'en','Alice, who was beginning.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(153,77,'uk','Dodo suddenly called out.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(154,77,'en','Cat\'s head with great.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(155,78,'uk','As they walked off together..','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(156,78,'en','Duchess, it had finished.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(157,79,'uk','I shall think nothing of the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(158,79,'en','Dormouse is asleep again,\'.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(159,80,'uk','Then she went out, but it.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(160,80,'en','Queen said severely \'Who is.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(161,81,'uk','Bill!\' then the other,.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(162,81,'en','Alice. \'You did,\' said the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(163,82,'uk','Alice very politely; but she.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(164,82,'en','She waited for a minute or.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(165,83,'uk','I hadn\'t gone down that.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(166,83,'en','Alice. \'I\'m glad they don\'t.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(167,84,'uk','For instance, suppose it.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(168,84,'en','I\'LL soon make you grow.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(169,85,'uk','The other side of the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(170,85,'en','Dormouse denied nothing,.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(171,86,'uk','Alice, and tried to open her.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(172,86,'en','I suppose you\'ll be telling.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(173,87,'uk','Dormouse was sitting on the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(174,87,'en','So she set the little magic.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(175,88,'uk','I was sent for.\' \'You ought.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(176,88,'en','Alice took up the chimney,.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(177,89,'uk','Hatter, with an M--\' \'Why.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(178,89,'en','All the time they were.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(179,90,'uk','At this the whole pack rose.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(180,90,'en','Alice. \'I mean what I was a.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(181,91,'uk','Gryphon, sighing in his.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(182,91,'en','The first thing she heard.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(183,92,'uk','Dormouse! Turn that Dormouse.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(184,92,'en','How queer everything is.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(185,93,'uk','Cheshire Cat sitting on a.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(186,93,'en','GAVE HER ONE, THEY GAVE HIM.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(187,94,'uk','Alice. \'Well, then,\' the.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(188,94,'en','Hatter: \'it\'s very rude.\'.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(189,95,'uk','SOMETHING interesting is.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(190,95,'en','Alice, as she leant against.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(191,96,'uk','She gave me a good deal.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(192,96,'en','Forty-two. ALL PERSONS MORE.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(193,97,'uk','Heads below!\' (a loud.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(194,97,'en','King, who had been.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(195,98,'uk','CHAPTER IX. The Mock Turtle.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(196,98,'en','Eaglet, and several other.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(197,99,'uk','T!\' said the Pigeon had.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(198,99,'en','She had quite a new idea to.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(199,100,'uk','There ought to be sure; but.','2023-02-23 22:17:50','2023-02-23 22:17:50'),
(200,100,'en','English); \'now I\'m opening.','2023-02-23 22:17:50','2023-02-23 22:17:50');
/*!40000 ALTER TABLE `work_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` bigint(20) NOT NULL DEFAULT 0,
  `rating` smallint(6) NOT NULL DEFAULT 0,
  `comments` smallint(6) NOT NULL DEFAULT 0,
  `hosts` int(11) NOT NULL DEFAULT 0,
  `price` int(10) unsigned NOT NULL DEFAULT 0,
  `old_id` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `show_en` tinyint(1) NOT NULL DEFAULT 0,
  `show_ru` tinyint(1) NOT NULL DEFAULT 0,
  `show_uk` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `works_show_en_index` (`show_en`),
  KEY `works_show_ru_index` (`show_ru`),
  KEY `works_show_uk_index` (`show_uk`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES
(1,1,5,23,0,9628,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','2022-03-20 15:10:48',1,0,1,NULL),
(2,2,22,464,0,7018,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','2022-10-17 11:38:48',1,0,1,NULL),
(3,3,34,81,0,8620,NULL,'2023-02-23 22:17:48','2023-02-23 22:17:48','2022-01-08 19:20:48',1,0,1,NULL),
(4,4,16,309,0,6187,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-02-14 07:45:48',1,0,1,NULL),
(5,5,30,381,0,6346,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-10-10 23:53:48',1,0,1,NULL),
(6,6,11,454,0,4754,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-05-24 23:19:48',1,0,1,NULL),
(7,7,21,293,0,9235,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-02-12 16:17:48',1,0,1,NULL),
(8,8,5,192,0,2713,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-04-05 17:10:48',1,0,1,NULL),
(9,9,17,158,0,4606,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-01-18 06:49:48',1,0,1,NULL),
(10,10,39,58,0,2038,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-01-03 18:59:48',1,0,1,NULL),
(11,11,2,482,0,5937,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-12-05 21:14:48',1,0,1,NULL),
(12,12,6,152,0,7088,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-09-04 18:41:48',1,0,1,NULL),
(13,13,23,121,0,9612,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-04-27 02:28:48',1,0,1,NULL),
(14,14,8,451,0,9032,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-03-07 06:34:48',1,0,1,NULL),
(15,15,40,442,0,660,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-08-10 11:09:48',1,0,1,NULL),
(16,16,31,43,0,6299,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-07-20 21:32:48',1,0,1,NULL),
(17,17,39,262,0,5163,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-06-03 17:48:48',1,0,1,NULL),
(18,18,33,224,0,8820,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-03-17 01:28:48',1,0,1,NULL),
(19,19,39,209,0,5611,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-07-23 09:22:48',1,0,1,NULL),
(20,20,10,195,0,7326,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-12 09:25:48',1,0,1,NULL),
(21,21,13,110,0,7546,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-10-11 04:43:48',1,0,1,NULL),
(22,22,24,345,0,5213,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-07-10 20:02:48',1,0,1,NULL),
(23,23,6,61,0,835,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-11-20 22:31:48',1,0,1,NULL),
(24,24,7,425,0,4314,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-11-12 02:09:48',1,0,1,NULL),
(25,25,37,61,0,6656,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-21 18:35:48',1,0,1,NULL),
(26,26,2,107,0,8573,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-03 05:21:48',1,0,1,NULL),
(27,27,40,5,0,1950,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-10 07:22:48',1,0,1,NULL),
(28,28,29,153,0,6678,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-08-07 20:07:48',1,0,1,NULL),
(29,29,10,456,0,2197,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-08-30 22:27:48',1,0,1,NULL),
(30,30,15,259,0,9393,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2023-01-06 02:57:48',1,0,1,NULL),
(31,31,17,464,0,9100,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2023-01-04 09:54:48',1,0,1,NULL),
(32,32,9,14,0,1751,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-11-07 08:39:48',1,0,1,NULL),
(33,33,0,381,0,4784,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-12-18 07:57:48',1,0,1,NULL),
(34,34,32,205,0,6091,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-05-10 06:33:48',1,0,1,NULL),
(35,35,18,409,0,7521,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-03 12:27:48',1,0,1,NULL),
(36,36,23,31,0,1695,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-10-02 20:46:48',1,0,1,NULL),
(37,37,27,273,0,6030,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-09-30 18:22:48',1,0,1,NULL),
(38,38,10,381,0,2785,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-23 02:29:48',1,0,1,NULL),
(39,39,14,261,0,4944,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-12-20 19:11:48',1,0,1,NULL),
(40,40,2,269,0,4641,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-01-28 12:43:48',1,0,1,NULL),
(41,41,23,349,0,851,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-10-25 06:21:48',1,0,1,NULL),
(42,42,23,113,0,7291,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-08-11 08:53:48',1,0,1,NULL),
(43,43,9,344,0,103,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-07-13 07:47:48',1,0,1,NULL),
(44,44,29,392,0,3916,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-08-30 01:29:48',1,0,1,NULL),
(45,45,36,300,0,6146,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-06-05 15:37:48',1,0,1,NULL),
(46,46,11,310,0,7780,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-02-08 13:58:48',1,0,1,NULL),
(47,47,22,332,0,2855,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-03-02 02:10:48',1,0,1,NULL),
(48,48,40,373,0,2328,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-08-07 00:39:48',1,0,1,NULL),
(49,49,25,491,0,3079,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-06-19 23:56:48',1,0,1,NULL),
(50,50,19,22,0,7065,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-08-01 00:00:48',1,0,1,NULL),
(51,51,29,336,0,7369,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-11-18 10:38:48',1,0,1,NULL),
(52,52,27,480,0,9069,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-10-13 18:11:48',1,0,1,NULL),
(53,53,30,77,0,6084,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-02-25 14:48:48',1,0,1,NULL),
(54,54,16,37,0,2136,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-10-14 12:14:48',1,0,1,NULL),
(55,55,24,445,0,6816,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-11-29 13:57:48',1,0,1,NULL),
(56,56,16,383,0,377,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-10-21 11:38:48',1,0,1,NULL),
(57,57,3,113,0,1808,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-07-25 11:01:48',1,0,1,NULL),
(58,58,37,87,0,7655,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-05-25 09:07:48',1,0,1,NULL),
(59,59,19,418,0,2171,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-11-28 03:22:48',1,0,1,NULL),
(60,60,39,472,0,7203,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-11 03:41:48',1,0,1,NULL),
(61,61,23,384,0,183,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-03-30 08:07:48',1,0,1,NULL),
(62,62,23,72,0,6278,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-04-18 18:52:48',1,0,1,NULL),
(63,63,14,202,0,310,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-04-24 11:10:48',1,0,1,NULL),
(64,64,29,292,0,7240,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-09-07 03:25:48',1,0,1,NULL),
(65,65,18,473,0,3968,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2023-02-19 15:53:48',1,0,1,NULL),
(66,66,35,104,0,2290,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-08 22:32:48',1,0,1,NULL),
(67,67,20,35,0,5370,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-11-18 04:19:48',1,0,1,NULL),
(68,68,6,93,0,9356,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-25 23:25:48',1,0,1,NULL),
(69,69,26,21,0,8165,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-07-31 18:02:48',1,0,1,NULL),
(70,70,28,495,0,2718,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2022-06-10 06:24:48',1,0,1,NULL),
(71,71,13,262,0,7750,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2023-01-08 06:44:48',1,0,1,NULL),
(72,72,25,451,0,7396,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-08 12:46:48',1,0,1,NULL),
(73,73,1,462,0,2135,NULL,'2023-02-23 22:17:49','2023-02-23 22:17:49','2021-12-07 00:21:48',1,0,1,NULL),
(74,74,36,246,0,2143,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-11-23 02:39:48',1,0,1,NULL),
(75,75,15,109,0,6727,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-12-31 22:10:48',1,0,1,NULL),
(76,76,40,446,0,2540,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-06-08 20:53:48',1,0,1,NULL),
(77,77,19,276,0,1287,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-06-28 12:41:48',1,0,1,NULL),
(78,78,34,472,0,2297,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-09-27 02:59:48',1,0,1,NULL),
(79,79,5,313,0,2505,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-02-01 09:42:48',1,0,1,NULL),
(80,80,30,215,0,7265,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-04-04 04:16:48',1,0,1,NULL),
(81,81,5,44,0,7149,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-11-15 16:11:48',1,0,1,NULL),
(82,82,38,369,0,9610,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-09-22 03:04:48',1,0,1,NULL),
(83,83,21,100,0,8400,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-09-18 18:36:48',1,0,1,NULL),
(84,84,27,18,0,6326,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2023-02-19 17:01:48',1,0,1,NULL),
(85,85,23,488,0,2425,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-07-27 19:20:48',1,0,1,NULL),
(86,86,13,271,0,2249,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-08-01 23:58:48',1,0,1,NULL),
(87,87,6,210,0,3845,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-06-22 05:50:48',1,0,1,NULL),
(88,88,39,382,0,2948,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-02-01 23:22:48',1,0,1,NULL),
(89,89,2,354,0,4047,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-12-23 07:45:48',1,0,1,NULL),
(90,90,26,479,0,2872,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-11-17 01:58:48',1,0,1,NULL),
(91,91,29,355,0,8020,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-06-05 09:45:48',1,0,1,NULL),
(92,92,3,491,0,1374,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-05-19 16:13:48',1,0,1,NULL),
(93,93,10,187,0,5254,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-11-20 03:30:48',1,0,1,NULL),
(94,94,26,376,0,3809,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-05-31 03:31:48',1,0,1,NULL),
(95,95,34,116,0,2488,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-03-29 18:27:48',1,0,1,NULL),
(96,96,31,9,0,537,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-08-29 02:35:48',1,0,1,NULL),
(97,97,31,142,0,1463,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-08-21 15:44:48',1,0,1,NULL),
(98,98,7,111,0,1027,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2021-11-16 06:40:48',1,0,1,NULL),
(99,99,38,137,0,9612,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-06-30 04:46:48',1,0,1,NULL),
(100,100,1,204,0,5483,NULL,'2023-02-23 22:17:50','2023-02-23 22:17:50','2022-09-20 03:29:48',1,0,1,NULL);
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-27 15:18:00
