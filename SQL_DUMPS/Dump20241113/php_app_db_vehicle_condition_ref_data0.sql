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
-- Table structure for table `vehicle_condition_ref_data`
--

DROP TABLE IF EXISTS `vehicle_condition_ref_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_condition_ref_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `condition_title` varchar(255) DEFAULT NULL,
  `condition_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_condition_ref_data`
--

LOCK TABLES `vehicle_condition_ref_data` WRITE;
/*!40000 ALTER TABLE `vehicle_condition_ref_data` DISABLE KEYS */;
INSERT INTO `vehicle_condition_ref_data` VALUES (6,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'New','Brand new vehicle with no prior usage'),(7,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Like New','Barely used, in excellent condition'),(8,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Used - Excellent','Used vehicle in excellent condition with minor wear'),(9,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Used - Good','Used vehicle in good condition with moderate wear'),(10,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Used - Fair','Used vehicle with noticeable wear and tear'),(11,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Damaged','Vehicle with some form of damage that requires repair'),(12,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Salvage','Vehicle with significant damage, often written off by insurance'),(13,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Restored','Vehicle that has been restored to good condition from a previous damaged state'),(14,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Certified Pre-Owned','Used vehicle certified by manufacturer or dealership'),(15,'2024-10-14 16:33:26','2024-10-14 16:33:26',NULL,NULL,'Parts Only','Vehicle that is no longer operational, sold for parts only');
/*!40000 ALTER TABLE `vehicle_condition_ref_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  0:52:03
