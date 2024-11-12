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
-- Table structure for table `security_questions`
--

DROP TABLE IF EXISTS `security_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `security_questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question1` varchar(255) NOT NULL,
  `question2` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `account_id` int NOT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_account_id` (`account_id`),
  CONSTRAINT `fk_account_id` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_questions`
--

LOCK TABLES `security_questions` WRITE;
/*!40000 ALTER TABLE `security_questions` DISABLE KEYS */;
INSERT INTO `security_questions` VALUES (31,'6. What is your favorite hobby?','8. What is your favorite movie?','Reading Books','Star wars',64,'2024-07-11 07:14:05',NULL),(32,'6. What is your favorite hobby?','1. What is your mother\'s maiden name?','guitar','alano',65,'2024-09-03 16:34:40',NULL),(34,'2. What city were you born in?','26. What is your favorite color?','Calamba','Black',67,'2024-09-29 11:43:05','2024-09-29 11:43:05'),(35,'8. What is your favorite movie?','13. What was your high school mascot?','Spider man','Spider Man',68,'2024-10-29 06:33:46','2024-10-29 06:33:46'),(36,'8. What is your favorite movie?','13. What was your high school mascot?','Spider Man','Spider Man',69,'2024-10-29 06:39:57','2024-10-29 06:39:57'),(37,'8. What is your favorite movie?','13. What was your high school mascot?','Iron Man','Iron Man',70,'2024-10-29 06:40:50','2024-10-29 06:40:50'),(38,'8. What is your favorite movie?','13. What was your high school mascot?','Captain America','Captain America',71,'2024-10-29 06:43:16','2024-10-29 06:43:16'),(40,'6. What is your favorite hobby?','8. What is your favorite movie?','eating','Star wars',73,'2024-11-11 16:43:35','2024-11-11 16:43:35');
/*!40000 ALTER TABLE `security_questions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-13  1:05:05
