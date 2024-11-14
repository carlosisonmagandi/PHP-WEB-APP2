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
-- Table structure for table `incident_report_monitoring`
--

DROP TABLE IF EXISTS `incident_report_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_report_monitoring` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inc_reports_id` int NOT NULL,
  `action_description` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `inc_reports_id` (`inc_reports_id`),
  CONSTRAINT `incident_report_monitoring_ibfk_1` FOREIGN KEY (`inc_reports_id`) REFERENCES `incident_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_report_monitoring`
--

LOCK TABLES `incident_report_monitoring` WRITE;
/*!40000 ALTER TABLE `incident_report_monitoring` DISABLE KEYS */;
INSERT INTO `incident_report_monitoring` VALUES (1,36,'New report ticket created','John Doe','John Doe','2024-11-14 03:13:37','2024-11-14 03:13:37'),(2,37,'New report ticket created','kian','kian','2024-11-14 04:27:16','2024-11-14 04:27:16'),(3,37,'Accepted by steve','steve','steve','2024-11-14 04:36:39','2024-11-14 04:36:39');
/*!40000 ALTER TABLE `incident_report_monitoring` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-14 18:46:10
