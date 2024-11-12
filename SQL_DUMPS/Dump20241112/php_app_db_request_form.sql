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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_form`
--

LOCK TABLES `request_form` WRITE;
/*!40000 ALTER TABLE `request_form` DISABLE KEYS */;
INSERT INTO `request_form` VALUES (59,'RE000000059','Loki','carlo','2024-10-21 17:19:27','2024-10-17 14:10:10','Alucard','Bucal Elementary School','123-987-6543','BES.2024@gmail.com','Bucal Calamba City','Flitches','50','Flitches','For Gazzibo','2024-10-16','06:00','Bucal Elementary School','In front of Vanessa Homes Subdivision','Rejected',NULL,'Yakal','yes','yes','yes','carlo','2024-10-21 15:05:31','carlo','2024-10-21 15:06:35','carlo','2024-10-21 17:19:27'),(60,'RE000000060','kian','carlo','2024-10-21 15:00:15','2024-10-21 14:46:26','Johny','City College of calamba','123-987-6543','ccc@gmail.com','Calamba Laguna','Flitches','150','Sample Description','Test purpose','2024-10-25','08:59','Calamba City','Near church','Rejected',NULL,'Coconuts','yes','yes','yes',NULL,NULL,NULL,NULL,'carlo','2024-10-21 15:00:15'),(61,'RE000000061','kian',NULL,'2024-11-11 17:56:17','2024-11-11 17:53:40','Requestee2','sample office 2','123-987-6543','alice.smith@greenearth.org','1725 Slough Avenue, Scranton','Coals','4','sample description','sample request','2024-11-12','10:56','1725 Slough Avenue, Scranton','Test','Completed',NULL,NULL,'yes','yes','yes','carlo','2024-11-11 17:55:35','carlo','2024-11-11 17:56:17',NULL,NULL),(62,'RE000000062','john','john','2024-11-12 08:21:05','2024-11-12 18:45:30','Requestee3','Sample Office 3','123-123-1234','bob.jones@greenearth.org','1423 Maple Street, Riverton','Books','10','Educational books for kids','Educational Donation','2024-11-14','14:00','1423 Maple Street, Riverton','Handle with care','Completed',NULL,'Books Set','yes','yes','no','john','2024-11-13 16:10:00','john','2024-11-14 15:00:00',NULL,NULL),(63,'RE000000063','emily','emily','2024-11-12 08:21:05','2024-11-14 00:35:21','Requestee4','Sample Office 4','234-234-2345','john.doe@greenearth.org','328 River Road, Greenfield','Clothes','20','Clothes for the needy','Humanitarian Aid','2024-11-16','09:30','328 River Road, Greenfield','Urgent','Completed',NULL,'Clothing Set','yes','no','yes','emily','2024-11-14 12:00:00','emily','2024-11-16 10:00:00',NULL,NULL),(64,'RE000000064','jane','jane','2024-11-12 08:22:34','2024-11-15 03:25:11','Requestee5','Sample Office 5','345-345-3456','susan.white@greenearth.org','67 Oak Street, Linden','Toys','15','Toys for children','Children’s Welfare','2024-11-18','11:00','67 Oak Street, Linden','Fragile items, handle carefully','Completed',NULL,'Toy Set','yes','no','yes','jane','2024-11-15 14:20:30',NULL,'2024-10-20 13:00:00',NULL,NULL),(65,'RE000000065','mike','mike','2024-11-12 08:22:34','2024-11-16 01:10:55','Requestee6','Sample Office 6','456-456-4567','mike.smith@greenearth.org','500 High Street, Hillside','Food','30','Food packets for the poor','Relief Effort','2024-11-20','12:00','500 High Street, Hillside','None','Completed',NULL,'Food Packets','yes','yes','no','mike','2024-11-16 14:40:00','mike','2024-10-20 13:00:00',NULL,NULL);
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

-- Dump completed on 2024-11-12 18:37:31
