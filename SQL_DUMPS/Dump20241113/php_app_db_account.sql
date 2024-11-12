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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'inactive',
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `full_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (64,'kian','$2y$10$nbjiw60sCTWSZCx/D2JY0O0XYY6/Pg2fWPK/b3yvy/dtJEGG6JHPG','2024-07-11 07:14:05','Staff','active','2024-10-18 12:14:42',NULL),(65,'carlo','$2y$10$DlSbkqirNA5O101S9v2neu3sWJrbEbtm5a1cebfwkQm8N2AICDAkq','2024-09-03 16:34:40','Admin','active','2024-10-29 06:29:03','Carlo Magandi'),(67,'Loki','$2y$10$oh549lKPKDgOoi/ty.liM.jBQo2R5kPRzmwQWNjfq6oi.2mQOLo8.','2024-09-29 11:43:05','Field_Staff','active','2024-11-06 05:41:18','Kurt Lim'),(68,'Tom','$2y$10$7p4Im.4XtWJHQ.6qHAKR8O2rDrIVcmTBN.dbxj35EBl2YH3TlSdnm','2024-10-29 06:33:46','Staff','active','2024-11-11 15:54:15','Tom Holland'),(69,'peter','$2y$10$tt4saCJR/RhuiXIkZjnC9uB1FzeonBpseCP27gW0u9xxR6.O9TEhu','2024-10-29 06:39:57','Staff','inactive','2024-11-11 15:57:42','Peter Parker'),(70,'tony','$2y$10$i6lW11CPZqoIDgK0TJCtueXu2dkyzIw3k0KSbbqd6W.8.A3/qRvlK','2024-10-29 06:40:50','Staff','active','2024-11-11 03:20:22','Tony Stark'),(71,'steve','$2y$10$npdtydfA6d33f.aOffSapOy7ki3WET9DR5M6MZfZgBu0Tkuv9fLn.','2024-10-29 06:43:16','Field_Staff','active','2024-10-29 16:27:15','Steve Rogers'),(73,'james','$2y$10$6J7d1Gpo/kbEWj2iQ0ZQxeWFc1gVw21I4VvZU0PcH4myKEJ.mWX/G','2024-11-11 16:43:35','Staff','active','2024-11-11 17:08:18','James Reid');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  1:04:52
