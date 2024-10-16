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
-- Table structure for table `request_form`
--

DROP TABLE IF EXISTS `request_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `request_form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `request_number` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `requestor_name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `type_of_requested_item` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `request_description` varchar(255) DEFAULT NULL,
  `purpose_of_donation` varchar(255) DEFAULT NULL,
  `preferred_delivery_date` varchar(255) DEFAULT NULL,
  `preferred_delivery_time` varchar(255) DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `special_instructions` varchar(255) DEFAULT NULL,
  `approval_status` varchar(255) DEFAULT NULL,
  `cancellation_reason` varchar(255) DEFAULT NULL,
  `name_of_requested_item` varchar(255) DEFAULT NULL,
  `letter_of_intent` varchar(255) DEFAULT NULL,
  `project_eng_certification` varchar(255) DEFAULT NULL,
  `budget_officer_certification` varchar(255) DEFAULT NULL,
  `approve_by` varchar(255) DEFAULT NULL,
  `date_of_approval` varchar(255) DEFAULT NULL,
  `complete_by` varchar(255) DEFAULT NULL,
  `date_of_completion` varchar(255) DEFAULT NULL,
  `reject_by` varchar(255) DEFAULT NULL,
  `date_of_rejection` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_form`
--

LOCK TABLES `request_form` WRITE;
/*!40000 ALTER TABLE `request_form` DISABLE KEYS */;
INSERT INTO `request_form` VALUES (1,'RE000000123','kian','carlo','2024-10-16 19:27:15','2024-09-20 18:29:37','Alice Smith','Green Earth Orgs','123-456-7891','alice.smith@greenearth.com','123 Oak Street, Springfields','Flitches','18','Laptops for rural schools.','To support education in rural areas','2024-09-11','10:00','456 Elm Street, Springfields','Contact before delivery. Thanks','Completed',NULL,'Yakal','no','yes','yes','carlo','2024-10-16 19:27:08','carlo','2024-10-16 19:27:15',NULL,NULL),(2,'RE000000124','kian','kian','2024-10-16 19:15:12','2024-09-20 18:40:24','Bob Williams','Clean Water Initiative','987-654-3210','bob.w@cleanwater.org','1789 Pine Street, Springfield','','35','Water filters for remote communities','To provide clean drinking water','2024-10-15','14:00','101 Maple Avenue, Springfield','Please deliver between 2-4 PM','Completed',NULL,'','','','','carlo','2024-10-16 19:10:43','carlo','2024-10-16 19:15:12',NULL,NULL),(3,'RE000000125','kian','carlo','2024-10-08 17:41:51','2024-09-20 18:46:05','Pam Beeslie','Dunder Mifflin','123-987-6543','pam.beesly@dundermifflin.com','1725 Slough Avenue, Scranton','','20','Chairs for conference rooms','To upgrade office furniture','2024-11-07','15:00','1725 Slough Avenue, Scranton','Please assemble upon delivery','Rejected',NULL,'','','no','yes',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `request_form` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-17  3:42:06
