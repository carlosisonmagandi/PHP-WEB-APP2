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
-- Table structure for table `incident_reports`
--

DROP TABLE IF EXISTS `incident_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_reports` (
  `id` int NOT NULL AUTO_INCREMENT,
  `report_number` varchar(255) DEFAULT NULL,
  `state` varchar(225) DEFAULT NULL,
  `assigned_by` varchar(225) DEFAULT NULL,
  `assigned_to` varchar(225) DEFAULT NULL,
  `isAccepted` varchar(225) DEFAULT NULL,
  `date_assigned` varchar(225) DEFAULT NULL,
  `date_reported` varchar(225) DEFAULT NULL,
  `reported_by` varchar(225) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(225) DEFAULT NULL,
  `coordinate_lat` varchar(225) DEFAULT NULL,
  `coordinate_lng` varchar(225) DEFAULT NULL,
  `illegal_activity_detail` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_reports`
--

LOCK TABLES `incident_reports` WRITE;
/*!40000 ALTER TABLE `incident_reports` DISABLE KEYS */;
INSERT INTO `incident_reports` VALUES (33,'REP50826928','Open','kian','Kurt Lim','Pending','2024-11-07 18:52:10','2024-10-31','James','kian','kian','2024-11-07 18:52:10','2024-11-07 18:50:07','Bucal Calamba City ','123.221','44.214','Suspected for collecting log'),(34,'REP22700063','Assigned','kian','Kurt Lim','Pending','2024-11-12 03:42:38','2024-11-12','Sample','kian','kian','2024-11-12 03:42:38','2024-11-11 17:45:22','Calamba','123.221','44.214','Test'),(35,'REP97024826','Accepted','kian','Steve Rogers','Accepted','2024-11-12 03:46:36','2024-11-08','Concerned citizen 1','kian','kian','2024-11-12 08:52:54','2024-11-12 03:46:36','Bucal Calamba City ','123.221','44.214','Suspected for collecting logs'),(36,'REP65335358','Assigned','kian','Steve Rogers','Pending','2024-11-13 15:36:47','2024-11-06','Concerned Citizen AB','kian','kian','2024-11-13 15:36:47','2024-11-13 15:36:47','Calamba,Calabarzon,Philippines26 Blk 35 lot 24 Calamba Park Place, Calamba, 4027 Laguna, Philippines','14.157269','121.134114','Suspected for collecting logs');
/*!40000 ALTER TABLE `incident_reports` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-14  1:05:03
