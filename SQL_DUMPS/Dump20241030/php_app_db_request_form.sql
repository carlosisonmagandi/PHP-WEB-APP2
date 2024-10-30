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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_form`
--

LOCK TABLES `request_form` WRITE;
/*!40000 ALTER TABLE `request_form` DISABLE KEYS */;
INSERT INTO `request_form` VALUES (1,'RE000000123','kian','carlo','2024-10-21 17:19:13','2024-09-20 18:29:37','Alice Smith','Green Earth Orgs','123-456-7891','alice.smith@greenearth.com','123 Oak Street, Springfields','Flitches','18','Laptops for rural schools.','To support education in rural areas','2024-09-11','10:00','456 Elm Street, Springfields','Contact before delivery. Thanks','Pending for Approval',NULL,'Yakal','no','yes','yes','carlo','2024-10-17 08:39:05','carlo','2024-10-17 09:12:35','carlo','2024-10-21 17:18:23'),(2,'RE000000124','kian','kian','2024-10-21 17:19:13','2024-09-20 18:40:24','Bob Williams','Clean Water Initiative','987-654-3210','bob.w@cleanwater.org','1789 Pine Street, Springfield','Coals','35','Water filters for remote communities','To provide clean drinking water','2024-10-15','14:00','101 Maple Avenue, Springfield','Please deliver between 2-4 PM','Pending for Approval',NULL,'','yes','yes','yes','carlo','2024-10-21 16:06:22','carlo','2024-10-16 19:15:12',NULL,NULL),(3,'RE000000125','kian','kian','2024-10-21 17:19:13','2024-09-20 18:46:05','Pam Beeslie','Dunder Mifflin','123-987-6543','pam.beesly@dundermifflin.com','1725 Slough Avenue, Scranton','Flitches','20','Chairs for conference rooms','To upgrade office furniture','2024-11-07','15:00','1725 Slough Avenue, Scranton','Please assemble upon delivery','Pending for Approval',NULL,'Narra','yes','no','yes','carlo','2024-10-17 13:29:49','carlo','2024-10-17 13:29:59',NULL,NULL),(59,'RE000000059','Loki','carlo','2024-10-21 17:19:27','2024-10-17 14:10:10','Alucard','Bucal Elementary School','123-987-6543','BES.2024@gmail.com','Bucal Calamba City','Flitches','50','Flitches','For Gazzibo','2024-10-16','06:00','Bucal Elementary School','In front of Vanessa Homes Subdivision','Rejected',NULL,'Yakal','yes','yes','yes','carlo','2024-10-21 15:05:31','carlo','2024-10-21 15:06:35','carlo','2024-10-21 17:19:27'),(60,'RE000000060','kian','carlo','2024-10-21 15:00:15','2024-10-21 14:46:26','Johny','City College of calamba','123-987-6543','ccc@gmail.com','Calamba Laguna','Flitches','150','Sample Description','Test purpose','2024-10-25','08:59','Calamba City','Near church','Rejected',NULL,'Coconuts','yes','yes','yes',NULL,NULL,NULL,NULL,'carlo','2024-10-21 15:00:15');
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

-- Dump completed on 2024-10-30 23:05:24
