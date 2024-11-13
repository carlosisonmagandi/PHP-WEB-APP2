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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donation_monitoring`
--

LOCK TABLES `donation_monitoring` WRITE;
/*!40000 ALTER TABLE `donation_monitoring` DISABLE KEYS */;
INSERT INTO `donation_monitoring` VALUES (4,65,'Donated items verified and logged.','John Doe','Jane Smith','2024-11-12 13:18:29','2024-11-12 13:18:29'),(5,65,'Ticket Created.','John Doe','Jane Smith','2024-11-12 14:12:09','2024-11-12 14:12:09'),(6,66,'Donation request Created','kian','kian','2024-11-12 15:11:29','2024-11-12 15:11:29'),(10,66,'Approved by carlo','carlo','carlo','2024-11-12 15:44:53','2024-11-12 15:44:53'),(11,66,'Completed by carlo','carlo','carlo','2024-11-12 15:58:26','2024-11-12 15:58:26'),(12,67,'Donation request Created','kian','kian','2024-11-12 16:13:00','2024-11-12 16:13:00'),(13,67,'Approved by carlo','carlo','carlo','2024-11-12 16:14:41','2024-11-12 16:14:41'),(14,67,'Completed by carlo','carlo','carlo','2024-11-12 16:15:13','2024-11-12 16:15:13'),(15,68,'Donation request Created','kian','kian','2024-11-12 16:23:38','2024-11-12 16:23:38'),(16,68,'Approved by carlo','carlo','carlo','2024-11-13 03:15:26','2024-11-13 03:15:26'),(17,68,'Completed by carlo','carlo','carlo','2024-11-13 03:17:52','2024-11-13 03:17:52'),(18,69,'Donation request Created','kian','kian','2024-11-13 03:27:19','2024-11-13 03:27:19'),(19,69,'Approved by carlo','carlo','carlo','2024-11-13 03:29:34','2024-11-13 03:29:34'),(22,72,'Donation request Created','kian','kian','2024-11-13 16:43:01','2024-11-13 16:43:01');
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

-- Dump completed on 2024-11-14  1:05:27
