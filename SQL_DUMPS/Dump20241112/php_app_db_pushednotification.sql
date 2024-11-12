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
-- Table structure for table `pushednotification`
--

DROP TABLE IF EXISTS `pushednotification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pushednotification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_created` date DEFAULT NULL,
  `time_created` time DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `landing_page` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pushednotification`
--

LOCK TABLES `pushednotification` WRITE;
/*!40000 ALTER TABLE `pushednotification` DISABLE KEYS */;
INSERT INTO `pushednotification` VALUES (57,'Account Registration','2024-07-11','15:14:05','seen','/Pages/admin/manageAccount.php','kian'),(58,'Account Registration','2024-09-04','00:34:40','unseen','/Pages/admin/manageAccount.php','carlo'),(59,'Account Registration','2024-09-17','16:57:27','unseen','/Pages/admin/manageAccount.php','gian'),(60,'Account Registration','2024-09-29','19:43:05','seen','/Pages/admin/manageAccount.php','Loki'),(61,'Account Registration','2024-10-29','14:33:46','unseen','/Pages/admin/manageAccount.php','Tom'),(62,'Account Registration','2024-10-29','14:39:58','unseen','/Pages/admin/manageAccount.php','peter'),(63,'Account Registration','2024-10-29','14:40:50','unseen','/Pages/admin/manageAccount.php','tony'),(64,'Account Registration','2024-10-29','14:43:16','unseen','/Pages/admin/manageAccount.php','steve'),(65,'Account Registration','2024-11-12','00:34:26','unseen','/Pages/admin/manageAccount.php','James'),(66,'Account Registration','2024-11-12','00:43:35','seen','/Pages/admin/manageAccount.php','james');
/*!40000 ALTER TABLE `pushednotification` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-12 18:37:14
