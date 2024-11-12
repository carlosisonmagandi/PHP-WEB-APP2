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
-- Table structure for table `equipment_condition_ref_data`
--

DROP TABLE IF EXISTS `equipment_condition_ref_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_condition_ref_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition_title` varchar(255) DEFAULT NULL,
  `condition_description` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_condition_ref_data`
--

LOCK TABLES `equipment_condition_ref_data` WRITE;
/*!40000 ALTER TABLE `equipment_condition_ref_data` DISABLE KEYS */;
INSERT INTO `equipment_condition_ref_data` VALUES (3,'Used','The equipment has been previously used but is still functional.','2024-09-12 14:15:58','2024-09-12 14:15:58'),(4,'Broken','The equipment is non-functional and needs repairs to be operational.','2024-09-12 14:16:12','2024-09-12 14:16:12'),(5,'Damaged','he equipment has visible damage but might still be usable with some repairs.','2024-09-12 14:16:26','2024-09-12 14:16:26'),(6,'Poor','The equipment is significantly worn and may have minor functional issues.','2024-09-12 14:16:42','2024-09-12 14:16:42'),(7,'Fair','The equipment has noticeable wear and tear but still functions properly.','2024-09-12 14:16:57','2024-09-12 14:16:57'),(8,'Good','The equipment shows minor signs of wear but is fully functional.','2024-09-12 14:17:10','2024-09-12 14:17:10'),(9,'New','The equipment is in perfect, unused condition.','2024-09-12 14:17:33','2024-09-12 14:17:33'),(11,'Overused','sampleoverused','2024-09-29 12:05:03','2024-09-29 12:05:03');
/*!40000 ALTER TABLE `equipment_condition_ref_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  1:04:48
