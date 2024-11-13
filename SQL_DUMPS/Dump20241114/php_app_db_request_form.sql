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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_form`
--

LOCK TABLES `request_form` WRITE;
/*!40000 ALTER TABLE `request_form` DISABLE KEYS */;
INSERT INTO `request_form` VALUES (65,'RE000000065','mike','mike','2024-11-12 14:26:52','2024-11-16 01:10:55','Requestee6','Sample Office 6','456-456-4567','mike.smith@greenearth.org','500 High Street, Hillside','Coals','30','Food packets for the poor','Relief Effort','2024-11-20','12:00','500 High Street, Hillside','None','Completed',NULL,'Food Packets','yes','yes','no','mike','2024-11-16 14:40:00','mike','2024-10-20 13:00:00',NULL,NULL),(66,'RE000000061','kian',NULL,'2024-11-12 15:58:23','2024-11-12 15:11:29','Requestee100','Bucal Elementary School','123-987-6543','BES.2024@gmail.com','Bucal Calamba City','Lumber','12','Test','Test purpose','2024-11-12','14:00','Bucal Elementary School','N/A','Completed',NULL,NULL,'yes','yes','yes','carlo','2024-11-12 15:44:52','carlo','2024-11-12 15:58:23',NULL,NULL),(67,'RE000000061','kian',NULL,'2024-11-12 16:15:13','2024-11-12 16:13:00','Requestee A','Green Earth Org','123-987-6543','GEO.2024@gmail.com','789 Pine Street, Springfield','Flitches','20','Sample','Sample','','','101 Maple Avenue, Springfield','','Completed',NULL,NULL,'yes','yes','yes','carlo','2024-11-12 16:14:38','carlo','2024-11-12 16:15:13',NULL,NULL),(68,'RE503765276','kian',NULL,'2024-11-13 03:17:32','2024-11-12 16:23:38','Requestee B','Green Earth Org 2','987-654-3210','GEO.2024@gmail.com','789 Pine Street, Springfield','Coals','3','Test','Test','','','1725 Slough Avenue, Scranton','','Completed',NULL,NULL,'yes','yes','yes','carlo','2024-11-13 03:15:22','carlo','2024-11-13 03:17:32',NULL,NULL),(69,'RE283991716','kian',NULL,'2024-11-13 03:29:36','2024-11-13 03:27:19','Michael Johnson','','123-987-6543','pam.beesly@dundermifflin.com','1725 Slough Avenue, Scranton','Flitches','13','test','test','','','1725 Slough Avenue, Scranton','','Approved',NULL,NULL,'yes','yes','no','carlo','2024-11-13 03:29:36',NULL,NULL,NULL,NULL),(72,'RE226283313','kian',NULL,'2024-11-13 16:43:01','2024-11-13 16:43:01','Michael Johnson','Dunder Mifflin','123-987-6543','pam.beesly@dundermifflin.com','1725 Slough Avenue, Scranton','Coals','3','test','test','2024-11-14','','1725 Slough Avenue, Scranton','','Pending for Approval',NULL,NULL,'No','Yes','No',NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2024-11-14  1:05:17
