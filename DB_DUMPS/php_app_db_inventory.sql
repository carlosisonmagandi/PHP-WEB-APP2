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
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_of_apprehension` varchar(225) DEFAULT NULL,
  `sitio` varchar(225) DEFAULT NULL,
  `barangay` varchar(225) DEFAULT NULL,
  `city_municipality` varchar(225) DEFAULT NULL,
  `province` varchar(225) DEFAULT NULL,
  `apprehending_officer` varchar(225) DEFAULT NULL,
  `apprehended_items` varchar(500) DEFAULT NULL,
  `EMV_forest_product` varchar(225) DEFAULT NULL,
  `EMV_conveyance_implements` varchar(225) DEFAULT NULL,
  `involve_personalities` varchar(225) DEFAULT NULL,
  `custodian` varchar(225) DEFAULT NULL,
  `ACP_status_or_case_no` varchar(225) DEFAULT NULL,
  `date_of_confiscation_order` varchar(225) DEFAULT NULL,
  `remarks` varchar(225) DEFAULT NULL,
  `apprehended_persons` varchar(225) DEFAULT NULL,
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` varchar(225) DEFAULT NULL,
  `apprehended_quantity` int DEFAULT NULL,
  `apprehended_volume` varchar(225) DEFAULT NULL,
  `apprehended_vehicle` varchar(225) DEFAULT NULL,
  `apprehended_vehicle_type` varchar(225) DEFAULT NULL,
  `apprehended_vehicle_plate_no` varchar(225) DEFAULT NULL,
  `create_by` varchar(225) DEFAULT NULL,
  `update_by` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (145,'2024-08-30','Makulots','Bucal','Calamba','Laguna','John','Coconuts','N/A','N/A','PENRO','N/A','0234918','2022-10-31','Test remarks','Juliet','2024-09-06 17:28:06','2024-09-01',200,'150 bd','Toyota','4x4','WOW404',NULL,NULL),(153,'2020-01-26','N/A','','Sta. Rosa','Laguna','DENRO','Narra Lumber','103,820.00 @ P100/bd. ft','200,000.00','N/A','Chief, EMS Penro Lag','Final Report submitted to R.O dated 09/03/2020','','Waiting for confiscation Order from R.O','Narciso C. Pineda','2024-09-16 15:05:09','2024-09-06',31,'1,038.20 bd.','Mitsubishi-Fuso','Truck','WLM-775',NULL,'carlo'),(154,'2020-02-06','N/A','Taimtim','San Pablo','LAGUNA','EMS PENRO Laguna','Yakal lumber','151700 @ 100/bd. ft','N/A','N/A','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','','Waiting for confiscation order from R.O','N/A','2024-09-16 13:08:37','2024-09-06',49,'200 cu','N/A','N/A','N/A',NULL,'carlo'),(159,'2023-11-30','','Lalakay','Los Banos','Laguna','John','Coconut','103,820.00 @ P100/bd. ft','200,000.00','Harry','Chief, EMS Penro Lag','1234','2024-12-31','Sample lalakay ','N/A','2024-09-16 11:54:23','2024-09-16',31,'150 bd','Toyota','4x4','WOW404','carlo',NULL),(160,'','','','San Jose','Batangas','','Yakal','103,820.00 @ P100/bd. ft','200,000.00','N/A','ED Regional Office','11235','2024-09-18','Sample Yakal','Jones','2024-09-16 15:02:35','2024-09-16',25,'1,038.20 bd.','Mitsubishi-Fuso','Closed Van','WLM-775','carlo','carlo');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-16 23:17:36
