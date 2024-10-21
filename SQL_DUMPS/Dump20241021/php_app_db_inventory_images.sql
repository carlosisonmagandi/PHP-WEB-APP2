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
-- Table structure for table `inventory_images`
--

DROP TABLE IF EXISTS `inventory_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inventory_id` int NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_id` (`inventory_id`),
  CONSTRAINT `inventory_images_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_images`
--

LOCK TABLES `inventory_images` WRITE;
/*!40000 ALTER TABLE `inventory_images` DISABLE KEYS */;
INSERT INTO `inventory_images` VALUES (192,145,'acacia.jpg','inventory-tree/Inventory/images/66daf5d6aed31.jpg',NULL,'2024-09-06'),(219,145,'mahogany.jpg','inventory-tree/Inventory/images/6706c023c16ae.jpg','2024-10-09 17:40:51','2024-10-09'),(220,145,'mango.jpeg','inventory-tree/Inventory/images/6706c023c62f5.jpeg','2024-10-09 17:40:51','2024-10-09'),(221,145,'narra.jpg','inventory-tree/Inventory/images/6706c023c9dab.jpg','2024-10-09 17:40:51','2024-10-09'),(224,145,'acacia - Copy.jpg','inventory-tree/Inventory/images/6706c0b6c0407.jpg','2024-10-09 17:43:18','2024-10-09'),(225,145,'coconut.jpg','inventory-tree/Inventory/images/6706c0b6c2d7e.jpg','2024-10-09 17:43:18','2024-10-09'),(226,162,'kamagong.jpg','inventory-tree/Inventory/images/6706cd055cb69.jpg','2024-10-09 18:35:49',NULL),(227,162,'mango.jpeg','inventory-tree/Inventory/images/6706cd055edc6.jpeg','2024-10-09 18:35:49',NULL),(229,164,'acacia.jpg','inventory-tree/Inventory/images/67080979c32a8.jpg','2024-10-10 17:06:01',NULL),(230,165,'kamagong.jpg','inventory-tree/Inventory/images/670fc69aeecff.jpg','2024-10-16 13:58:50',NULL),(231,166,'narra.jpg','inventory-tree/Inventory/images/670fc71ba375d.jpg','2024-10-16 14:00:59',NULL),(232,167,'mango.jpeg','inventory-tree/Inventory/images/670fc7ad29b3f.jpeg','2024-10-16 14:03:25',NULL),(233,168,'coconut.jpg','inventory-tree/Inventory/images/670fc8539c889.jpg','2024-10-16 14:06:11',NULL),(234,169,'mahogany.jpg','inventory-tree/Inventory/images/670fc8ef78fe5.jpg','2024-10-16 14:08:47',NULL),(235,170,'yakal.jpg','inventory-tree/Inventory/images/670fd6d90d443.jpg','2024-10-16 15:08:09',NULL),(236,171,'coconut.jpg','inventory-tree/Inventory/images/670fd7417961d.jpg','2024-10-16 15:09:53',NULL),(237,172,'mahogany.jpg','inventory-tree/Inventory/images/670fd842844a1.jpg','2024-10-16 15:14:10',NULL),(238,173,'kamagong.jpg','inventory-tree/Inventory/images/670fd94ba4675.jpg','2024-10-16 15:18:35',NULL),(239,174,'log-default-image.jpg','inventory-tree/Inventory/images/670fd9d47dac5.jpg','2024-10-16 15:20:52',NULL),(240,175,'narra.jpg','inventory-tree/Inventory/images/670fdb34cd4ad.jpg','2024-10-16 15:26:44',NULL),(241,176,'coconut.jpg','inventory-tree/Inventory/images/670fee19ee8e2.jpg','2024-10-16 16:47:21',NULL),(242,177,'kamagong.jpg','inventory-tree/Inventory/images/670fee82535dc.jpg','2024-10-16 16:49:06',NULL),(243,178,'acacia.jpg','inventory-tree/Inventory/images/670fef0453189.jpg','2024-10-16 16:51:16',NULL);
/*!40000 ALTER TABLE `inventory_images` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-21 23:27:23
