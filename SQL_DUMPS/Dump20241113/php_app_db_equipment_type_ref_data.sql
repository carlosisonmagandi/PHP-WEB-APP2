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
-- Table structure for table `equipment_type_ref_data`
--

DROP TABLE IF EXISTS `equipment_type_ref_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_type_ref_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_title` varchar(255) DEFAULT NULL,
  `type_description` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_type_ref_data`
--

LOCK TABLES `equipment_type_ref_data` WRITE;
/*!40000 ALTER TABLE `equipment_type_ref_data` DISABLE KEYS */;
INSERT INTO `equipment_type_ref_data` VALUES (7,'Heavy Equipment','Refers to large, powerful machines typically used in construction, mining, and agriculture for heavy-duty tasks such as excavation, lifting, or material transport. Examples include bulldozers, excavators, cranes, and loaders.','2024-09-11 18:37:56','2024-09-11 18:37:56'),(8,'Handheld Tools','Small, portable tools operated by hand, typically used for manual tasks like cutting, drilling, or fastening. Examples include hammers, screwdrivers, wrenches, and drills.','2024-09-11 18:38:14','2024-09-11 18:38:14'),(9,'Cutting Tools:','Tools designed for cutting various materials, such as metal, wood, or plastic. These tools often have sharp edges or blades. Examples include saws, chisels, and shears.','2024-09-11 18:38:35','2024-09-11 18:38:35'),(10,'Transport Equipment','Devices and vehicles used to move materials, equipment, or personnel from one location to another. Examples include trucks, forklifts, and conveyor belts.','2024-09-11 18:39:06','2024-09-11 18:39:06'),(11,'Climbing Gear','Equipment used to ensure safety and efficiency while climbing or working at heights. This includes ropes, harnesses, carabiners, and ladders, often used in construction, maintenance, or mountaineering.','2024-09-11 18:39:34','2024-09-11 18:39:34'),(12,'Road Construction Equipment','Specialized machinery used in the construction and maintenance of roads. This includes pavers, graders, rollers, and asphalt mixers for tasks like leveling, paving, and compacting surfaces.','2024-09-11 18:39:53','2024-09-11 18:39:53'),(13,'Measuring Tools','Instruments used to measure dimensions, angles, or distances with precision. Examples include tape measures, calipers, levels, and laser distance meters.','2024-09-11 18:40:09','2024-09-11 18:40:09'),(14,'Safety Equipment','Protective gear designed to safeguard workers from injury or accidents. This includes items like helmets, gloves, goggles, ear protection, and high-visibility clothing used in various industries.','2024-09-11 18:40:25','2024-09-11 18:40:25'),(18,'Test','Tes desc','2024-09-14 06:37:02','2024-09-14 06:37:02'),(19,'Narra','sajdghj','2024-09-14 06:37:51','2024-09-14 06:37:51');
/*!40000 ALTER TABLE `equipment_type_ref_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  1:04:42
