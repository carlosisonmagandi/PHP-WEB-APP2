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
-- Table structure for table `condition_status_tree`
--

DROP TABLE IF EXISTS `condition_status_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `condition_status_tree` (
  `id` int NOT NULL AUTO_INCREMENT,
  `condition_type` varchar(255) DEFAULT NULL,
  `condition_description` varchar(255) DEFAULT NULL,
  `activity_date` varchar(255) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `condition_status_tree`
--

LOCK TABLES `condition_status_tree` WRITE;
/*!40000 ALTER TABLE `condition_status_tree` DISABLE KEYS */;
INSERT INTO `condition_status_tree` VALUES (1,'Freshly Cut','Logs that have been recently cut down and are still relatively green and moist. These logs often have high moisture content and are heavier.',NULL,'2024-06-18 12:43:24'),(2,'Partially Processed','Logs that have been partially processed, such as being stripped of bark or cut into smaller sections, but not yet fully milled into lumber.',NULL,'2024-06-18 12:43:24'),(3,'Dry','Logs that have been cut for a while and have lost much of their moisture content. These are typically lighter and may have started to develop cracks or splits due to drying.',NULL,'2024-06-18 12:43:24'),(4,'Infested','Logs that show signs of infestation by insects such as termites, beetles, or other wood-boring pests. These logs may have visible holes, sawdust, or insect activity.',NULL,'2024-06-18 12:43:24'),(5,'Rotten/Decayed','Logs that have started to decompose due to fungal or bacterial activity. These logs may be soft, discolored, and structurally compromised.',NULL,'2024-06-18 12:43:24'),(6,'Damaged','Logs that have been damaged during harvesting, transport, or storage. This could include physical damage such as splits, cracks, or breakage.',NULL,'2024-06-18 12:43:24'),(7,'Illegally Harvested','Logs that have been cut from protected areas, without proper permits, or in violation of forestry regulations.',NULL,'2024-06-18 12:43:24'),(8,'Confiscated','Logs that have been seized by authorities due to illegal activities such as unauthorized logging or transportation.',NULL,'2024-06-18 12:43:24'),(9,'Branded/Marked','Logs that have been marked or branded by authorities or logging companies for identification purposes. These marks often indicate the origin, owner, or intended use of the logs.',NULL,'2024-06-18 12:43:24'),(10,'Stored/Stacked','Logs that have been stored in impounding areas, often stacked in piles for inventory and monitoring purposes. These logs might have varying conditions depending on how long they have been stored and the environmental conditions of the storage area.',NULL,'2024-06-18 12:43:24');
/*!40000 ALTER TABLE `condition_status_tree` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-16 23:17:48
