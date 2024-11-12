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
-- Table structure for table `species`
--

DROP TABLE IF EXISTS `species`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `species` (
  `id` int NOT NULL AUTO_INCREMENT,
  `species_name` varchar(255) DEFAULT NULL,
  `species_description` varchar(255) DEFAULT NULL,
  `activity_date` varchar(255) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `species`
--

LOCK TABLES `species` WRITE;
/*!40000 ALTER TABLE `species` DISABLE KEYS */;
INSERT INTO `species` VALUES (2,'Test Species name','test species desc',NULL,'2024-06-28 16:43:34'),(3,'Molave','A hard and durable wood, often used in construction and furniture.',NULL,'2024-06-28 16:57:22'),(4,'Philippine Mahogany','A group of species valued for their timber.',NULL,'2024-06-28 16:57:22'),(5,'Yakal','Known for its strength and used in heavy construction.',NULL,'2024-06-28 16:57:22'),(6,'Lauan','Various species used for plywood and veneer.',NULL,'2024-06-28 16:57:22'),(7,'Apitong','Used in construction and boat building.',NULL,'2024-06-28 16:57:22'),(8,'Bagras','Known for its multi-colored bark, also called rainbow eucalyptus.',NULL,'2024-06-28 16:57:22'),(9,'Balete','Often found in lowland forests, known for its large roots and spiritual significance.',NULL,'2024-06-28 16:57:22'),(10,'Dao','Known for its large size and high-quality wood.',NULL,'2024-06-28 16:57:22'),(11,'Ipil','Used in shipbuilding and heavy construction.',NULL,'2024-06-28 16:57:22'),(12,'Kamagong','Known for its dark, hard wood also called ebony.',NULL,'2024-06-28 16:57:22'),(13,'Mangkono','The hardest Philippine wood, used in tool handles and construction.',NULL,'2024-06-28 16:57:22'),(14,'Bagtikan','A tall tree used for timber and plywood.',NULL,'2024-06-28 16:57:22'),(15,'Almaciga','Source of Manila copal resin.',NULL,'2024-06-28 16:57:22'),(16,'Mangrove species','Important for coastal ecosystems.',NULL,'2024-06-28 16:57:22'),(17,'Mango','The Philippines produces some of the world\'s best mangoes.',NULL,'2024-06-28 16:57:22'),(18,'Durian','Known for its strong odor and rich flavor.',NULL,'2024-06-28 16:57:22'),(19,'Lanzones','Sweet and tangy fruit, highly prized in the Philippines.',NULL,'2024-06-28 16:57:22'),(20,'Rambutan','A tropical fruit with a hairy exterior and sweet interior.',NULL,'2024-06-28 16:57:22'),(21,'Mangosteen','Often called the \"queen of fruits\" for its sweet and juicy segments.',NULL,'2024-06-28 16:57:22'),(22,'Banana','Numerous varieties are cultivated in the Philippines.',NULL,'2024-06-28 16:57:22'),(23,'Jackfruit','Large fruit with sweet flesh.',NULL,'2024-06-28 16:57:22'),(24,'Coconut','Widely grown for its versatile fruit and other uses.',NULL,'2024-06-28 16:57:22'),(25,'Papaya','A tropical fruit enjoyed both ripe and green.',NULL,'2024-06-28 16:57:22'),(26,'Fire Tree','Known for its bright red flowers.',NULL,'2024-06-28 16:57:22'),(27,'Golden Shower Tree','Known for its long, yellow flower clusters.',NULL,'2024-06-28 16:57:22'),(28,'Acacia','Often used as a shade tree with wide, spreading branches.',NULL,'2024-06-28 16:57:22'),(29,'Bougainvillea','Though often a shrub, it can grow as a small tree with vibrant flowers.',NULL,'2024-06-28 16:57:22'),(30,'Narra','The national tree of the Philippines, known for its durable wood and striking yellow flowers.','2024-07-02','2024-06-28 16:57:22');
/*!40000 ALTER TABLE `species` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  0:52:10
