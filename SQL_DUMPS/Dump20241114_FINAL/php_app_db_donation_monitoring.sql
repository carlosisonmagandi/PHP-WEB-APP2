-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: php_app_db
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `donation_monitoring`
--

DROP TABLE IF EXISTS `donation_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donation_monitoring` (
  `id` int NOT NULL AUTO_INCREMENT,
  `incident_reports_id` int NOT NULL,
  `action_description` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `incident_reports_id` (`incident_reports_id`),
  CONSTRAINT `donation_monitoring_ibfk_1` FOREIGN KEY (`incident_reports_id`) REFERENCES `request_form` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donation_monitoring`
--

LOCK TABLES `donation_monitoring` WRITE;
/*!40000 ALTER TABLE `donation_monitoring` DISABLE KEYS */;
INSERT INTO `donation_monitoring` VALUES (12,67,'Donation request Created','kian','kian','2024-11-12 16:13:00','2024-11-12 16:13:00'),(13,67,'Approved by carlo','carlo','carlo','2024-11-12 16:14:41','2024-11-12 16:14:41'),(14,67,'Completed by carlo','carlo','carlo','2024-11-12 16:15:13','2024-11-12 16:15:13'),(15,68,'Donation request Created','kian','kian','2024-11-12 16:23:38','2024-11-12 16:23:38'),(16,68,'Approved by carlo','carlo','carlo','2024-11-13 03:15:26','2024-11-13 03:15:26'),(17,68,'Completed by carlo','carlo','carlo','2024-11-13 03:17:52','2024-11-13 03:17:52'),(18,69,'Donation request Created','kian','kian','2024-11-13 03:27:19','2024-11-13 03:27:19'),(19,69,'Approved by carlo','carlo','carlo','2024-11-13 03:29:34','2024-11-13 03:29:34'),(22,72,'Donation request Created','kian','kian','2024-11-13 16:43:01','2024-11-13 16:43:01'),(24,65,'Donation request Created','John Doe','Jane Smith','2024-11-14 03:31:37','2024-11-14 03:31:37'),(25,65,'Approved by carlo','John Doe','Jane Smith','2024-11-14 03:31:59','2024-11-14 03:31:59'),(27,75,'Donation request Created','kian','kian','2024-11-14 06:21:04','2024-11-14 06:21:04'),(31,79,'Donation request Created','kian','kian','2024-11-14 06:50:12','2024-11-14 06:50:12'),(32,79,'Approved by carlo','carlo','carlo','2024-11-14 07:03:48','2024-11-14 07:03:48'),(33,79,'Completed by carlo','carlo','carlo','2024-11-14 07:04:22','2024-11-14 07:04:22'),(34,69,'Completed by carlo','carlo','carlo','2024-11-14 07:04:35','2024-11-14 07:04:35'),(35,79,'Approved by carlo','carlo','carlo','2024-11-14 07:16:08','2024-11-14 07:16:08'),(36,79,'Completed by carlo','carlo','carlo','2024-11-14 07:16:16','2024-11-14 07:16:16'),(37,79,'Approved by carlo','carlo','carlo','2024-11-14 07:17:22','2024-11-14 07:17:22'),(38,79,'Completed by carlo','carlo','carlo','2024-11-14 07:17:27','2024-11-14 07:17:27'),(39,79,'Approved by carlo','carlo','carlo','2024-11-14 07:20:15','2024-11-14 07:20:15'),(40,79,'Completed by carlo','carlo','carlo','2024-11-14 07:20:21','2024-11-14 07:20:21'),(41,79,'Approved by carlo','carlo','carlo','2024-11-14 07:21:10','2024-11-14 07:21:10'),(42,79,'Completed by carlo','carlo','carlo','2024-11-14 07:21:41','2024-11-14 07:21:41'),(43,79,'Approved by carlo','carlo','carlo','2024-11-14 07:23:09','2024-11-14 07:23:09'),(44,79,'Completed by carlo','carlo','carlo','2024-11-14 07:23:15','2024-11-14 07:23:15'),(45,79,'Approved by carlo','carlo','carlo','2024-11-14 07:26:04','2024-11-14 07:26:04'),(46,79,'Completed by carlo','carlo','carlo','2024-11-14 07:26:11','2024-11-14 07:26:11'),(47,75,'Approved by carlo','carlo','carlo','2024-11-14 07:27:09','2024-11-14 07:27:09'),(48,75,'Completed by carlo','carlo','carlo','2024-11-14 07:27:15','2024-11-14 07:27:15'),(49,79,'Approved by carlo','carlo','carlo','2024-11-14 07:27:53','2024-11-14 07:27:53'),(50,79,'Completed by carlo','carlo','carlo','2024-11-14 07:28:05','2024-11-14 07:28:05'),(51,79,'Approved by carlo','carlo','carlo','2024-11-14 07:34:32','2024-11-14 07:34:32'),(52,79,'Completed by carlo','carlo','carlo','2024-11-14 07:34:38','2024-11-14 07:34:38'),(53,79,'Approved by carlo','carlo','carlo','2024-11-14 07:37:04','2024-11-14 07:37:04'),(54,79,'Completed by carlo','carlo','carlo','2024-11-14 07:37:10','2024-11-14 07:37:10'),(55,79,'Approved by carlo','carlo','carlo','2024-11-14 07:45:14','2024-11-14 07:45:14'),(56,79,'Completed by carlo','carlo','carlo','2024-11-14 07:45:20','2024-11-14 07:45:20'),(57,79,'Approved by carlo','carlo','carlo','2024-11-14 07:47:28','2024-11-14 07:47:28'),(58,75,'Approved by carlo','carlo','carlo','2024-11-14 07:47:35','2024-11-14 07:47:35'),(59,79,'Completed by carlo','carlo','carlo','2024-11-14 07:47:43','2024-11-14 07:47:43'),(60,79,'Approved by carlo','carlo','carlo','2024-11-14 07:51:44','2024-11-14 07:51:44'),(61,79,'Completed by carlo','carlo','carlo','2024-11-14 07:51:49','2024-11-14 07:51:49'),(62,79,'Approved by carlo','carlo','carlo','2024-11-14 07:55:14','2024-11-14 07:55:14'),(63,79,'Completed by carlo','carlo','carlo','2024-11-14 07:55:22','2024-11-14 07:55:22'),(64,75,'Approved by carlo','carlo','carlo','2024-11-14 07:58:06','2024-11-14 07:58:06'),(65,75,'Completed by carlo','carlo','carlo','2024-11-14 07:58:13','2024-11-14 07:58:13'),(66,79,'Approved by carlo','carlo','carlo','2024-11-14 08:00:21','2024-11-14 08:00:21'),(67,79,'Completed by carlo','carlo','carlo','2024-11-14 08:00:29','2024-11-14 08:00:29'),(68,79,'Approved by carlo','carlo','carlo','2024-11-14 08:04:30','2024-11-14 08:04:30'),(69,79,'Completed by carlo','carlo','carlo','2024-11-14 08:04:37','2024-11-14 08:04:37'),(70,79,'Approved by carlo','carlo','carlo','2024-11-14 08:05:55','2024-11-14 08:05:55'),(71,79,'Completed by carlo','carlo','carlo','2024-11-14 08:06:01','2024-11-14 08:06:01'),(72,79,'Approved by carlo','carlo','carlo','2024-11-14 08:06:51','2024-11-14 08:06:51'),(73,79,'Completed by carlo','carlo','carlo','2024-11-14 08:06:56','2024-11-14 08:06:56'),(74,79,'Approved by carlo','carlo','carlo','2024-11-14 08:10:51','2024-11-14 08:10:51'),(75,79,'Completed by carlo','carlo','carlo','2024-11-14 08:10:57','2024-11-14 08:10:57'),(76,79,'Approved by carlo','carlo','carlo','2024-11-14 08:12:44','2024-11-14 08:12:44'),(77,79,'Completed by carlo','carlo','carlo','2024-11-14 08:12:51','2024-11-14 08:12:51'),(78,79,'Approved by carlo','carlo','carlo','2024-11-14 08:23:15','2024-11-14 08:23:15'),(79,79,'Completed by carlo','carlo','carlo','2024-11-14 08:23:21','2024-11-14 08:23:21'),(80,79,'Approved by carlo','carlo','carlo','2024-11-14 08:25:00','2024-11-14 08:25:00'),(81,79,'Completed by carlo','carlo','carlo','2024-11-14 08:25:05','2024-11-14 08:25:05'),(82,79,'Approved by carlo','carlo','carlo','2024-11-14 08:25:56','2024-11-14 08:25:56'),(83,79,'Completed by carlo','carlo','carlo','2024-11-14 08:26:01','2024-11-14 08:26:01'),(84,79,'Approved by carlo','carlo','carlo','2024-11-14 08:30:03','2024-11-14 08:30:03'),(85,79,'Completed by carlo','carlo','carlo','2024-11-14 08:30:09','2024-11-14 08:30:09'),(86,79,'Approved by carlo','carlo','carlo','2024-11-14 08:31:41','2024-11-14 08:31:41'),(87,79,'Completed by carlo','carlo','carlo','2024-11-14 08:31:47','2024-11-14 08:31:47'),(88,79,'Approved by carlo','carlo','carlo','2024-11-14 08:32:26','2024-11-14 08:32:26'),(89,79,'Completed by carlo','carlo','carlo','2024-11-14 08:32:32','2024-11-14 08:32:32');
/*!40000 ALTER TABLE `donation_monitoring` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-14 18:46:06
