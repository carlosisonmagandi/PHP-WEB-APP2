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
-- Table structure for table `vehicle_status_ref_data`
--

DROP TABLE IF EXISTS `vehicle_status_ref_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicle_status_ref_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_title` varchar(255) DEFAULT NULL,
  `status_description` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_status_ref_data`
--

LOCK TABLES `vehicle_status_ref_data` WRITE;
/*!40000 ALTER TABLE `vehicle_status_ref_data` DISABLE KEYS */;
INSERT INTO `vehicle_status_ref_data` VALUES (4,'Available','Vehicle is available for use or sale','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(5,'In Use','Vehicle is currently in use','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(6,'Under Maintenance','Vehicle is undergoing maintenance or repairs','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(7,'Out of Service','Vehicle is temporarily out of service','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(8,'Decommissioned','Vehicle has been permanently taken out of service','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(9,'Pending Sale','Vehicle is pending sale','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(10,'Reserved','Vehicle is reserved for future use or sale','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(11,'Lost','Vehicle is lost or missing','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(12,'Stolen','Vehicle has been reported stolen','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(13,'Confiscated','Vehicle has been confiscated by authorities or another entity','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(14,'Impounded','Vehicle is held in an impound facility','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(15,'Leased','Vehicle is currently leased out','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL),(16,'On Loan','Vehicle is temporarily loaned to another party','2024-10-14 16:35:45','2024-10-14 16:35:45',NULL,NULL);
/*!40000 ALTER TABLE `vehicle_status_ref_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-17  3:41:50
