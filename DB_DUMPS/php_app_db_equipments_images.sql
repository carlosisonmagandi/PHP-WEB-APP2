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
-- Table structure for table `equipments_images`
--

DROP TABLE IF EXISTS `equipments_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipments_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `equipment_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `equipment_id` (`equipment_id`),
  CONSTRAINT `equipments_images_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments_images`
--

LOCK TABLES `equipments_images` WRITE;
/*!40000 ALTER TABLE `equipments_images` DISABLE KEYS */;
INSERT INTO `equipments_images` VALUES (22,9,'Bolo_Farm.jpg','Inventory/images/66e020359a17b.jpg','2024-09-10 10:32:21','2024-09-10 10:32:21'),(25,1,'Chainsaw.jpg','Inventory/images/66e069edd1c2c.jpg','2024-09-10 15:46:53','2024-09-09 16:00:00'),(26,2,'Chainsaw2.jpg','Inventory/images/66e069fb6c419.jpg','2024-09-10 15:47:07','2024-09-09 16:00:00'),(27,1,'Knife.jpg','Inventory/images/66e072663daa3.jpg','2024-09-10 16:23:02','2024-09-09 16:00:00'),(28,9,'Crowbar.jpg','Inventory/images/66e1e82604636.jpg','2024-09-11 18:57:42','2024-09-10 16:00:00'),(29,9,'Grass_Cutter.jpg','Inventory/images/66e1e882d33b8.jpg','2024-09-11 18:59:14','2024-09-10 16:00:00'),(30,9,'Knife.jpg','Inventory/images/66e1e882d7a7f.jpg','2024-09-11 18:59:14','2024-09-10 16:00:00'),(31,9,'Rope.jpg','Inventory/images/66e1e882dabfe.jpg','2024-09-11 18:59:14','2024-09-10 16:00:00'),(32,9,'Wood_Saw.jpg','Inventory/images/66e1e882dd83c.jpg','2024-09-11 18:59:14','2024-09-10 16:00:00');
/*!40000 ALTER TABLE `equipments_images` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-16 23:17:29
