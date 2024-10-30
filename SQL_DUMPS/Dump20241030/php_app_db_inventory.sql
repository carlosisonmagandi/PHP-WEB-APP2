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
  `activity_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_created` varchar(225) DEFAULT NULL,
  `apprehended_quantity` int DEFAULT NULL,
  `apprehended_volume` varchar(225) DEFAULT NULL,
  `apprehended_vehicle` varchar(225) DEFAULT NULL,
  `apprehended_vehicle_type` varchar(225) DEFAULT NULL,
  `apprehended_vehicle_plate_no` varchar(225) DEFAULT NULL,
  `create_by` varchar(225) DEFAULT NULL,
  `update_by` varchar(225) DEFAULT NULL,
  `depository_sitio` varchar(225) DEFAULT NULL,
  `depository_barangay` varchar(225) DEFAULT NULL,
  `depository_city` varchar(225) DEFAULT NULL,
  `depository_province` varchar(225) DEFAULT NULL,
  `linear_mtrs` varchar(225) DEFAULT NULL,
  `apprehended_persons` varchar(225) DEFAULT NULL,
  `species_type` varchar(225) DEFAULT NULL,
  `species_status` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (145,'2024-10-26','N/A','Lalakay','Los Banos ','Laguna','PENRO LAGUNA','Coconuts','150000','N/A','PENRO','N/A','0234918','undefined','Test remarks','2024-10-16 12:18:27','2024-09-01',200,'150 bd','Toyota','4x4','WOW404',NULL,'carlo','N/A','Bucal','Calamba','Laguna','500','','Flitches','Confiscated'),(162,'2024-10-26','Makulot','Halang','Calamba','Laguna','CENRO','Acacia','103,820.00 ','200,000.00','Joseph Abraham, Jessica Gojo','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Sample record','2024-10-10 19:27:50','2024-10-09',2412,'160 bd','Toyota','Closed Van','WLM-775','carlo','carlo','N/A','Lalakay','Los Banos','Laguna','130','','Lumber','Freshly Cut'),(164,'2024-10-09','Malaya','Real','Calamba','Laguna','Penro Laguna','Yakal','10000','100,000.00','Hollaista','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Test','2024-10-16 12:29:39','2024-10-10',49,'200 cu','Mitsubishi-Fuso','Truck','404BOB','carlo','carlo','N/A','Lalakay','Los Banos','Laguna','421','','Lumber','Confiscated'),(165,'2024-01-19','Malayo','Real','Calamba','Laguna','Penro','Kamagong','40210','30,000','Gerome','ED Regional Office','Final Report submitted to R.O dated 09/03/2020','undefined','Confiscated last January','2024-10-16 13:58:50','2024-10-16',70,'2,040.20 bd.','Toyota','Closed Van','WLM-775','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','500','','Coals','Confiscated'),(166,'2024-02-16','Madilim','Canlubang','Calamba','Laguna','PENRO','Narra','40500','100,000.00','Georgie','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Confiscated last Feb','2024-10-16 14:00:59','2024-10-16',520,'150 bd','Mitsubishi-Fuso','Truck','BOB221','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','421','','Coals','Confiscated'),(167,'2024-03-18','Matuwid','Halang','Calamba','Laguna','Penro','Mango','300000','200,000.00','Jasmine','ED Regional Office','Final Report submitted to R.O dated 09/03/2020','undefined','Confiscated last March','2024-10-16 14:03:25','2024-10-16',70100,'160 bd','Toyota','4x4','HOT441','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','500','','Coals','Confiscated'),(168,'2024-04-05','Malinaw','San Cristobal','San Pablo','Laguna','Penro','Coconut','60000','200,000.00','Juliet','Chief, EMS Penro Lag','Final Report submitted to R.O dated 09/03/2020','undefined','Confiscated last April','2024-10-16 14:06:11','2024-10-16',200,'160 bd','Toyota','Truck','KOL606','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','421','','Coals','Confiscated'),(169,'2024-05-16','Baluktot','Lalakay','Los Banos ','Laguna','Penro','Mahogany','70000','100,000.00','Shane','Chief, EMS Penro Lag','Final Report submitted to R.O dated 09/03/2020','undefined','Confiscated last May','2024-10-16 14:08:47','2024-10-16',670,'55.30','Toyota','Closed Van','BVJ412','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','300','','Coals','Confiscated'),(170,'2024-06-18','Malalim','Bucal','Calamba','Laguna','Penro','Yakal','60100','200,000.00','Josefa','ED Regional Office','Final Report submitted to R.O dated 09/03/2020','undefined','Confiscated Last June','2024-10-16 15:08:09','2024-10-16',512,'150 bd','Toyota','4x4','OWW515','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','421','','Coals','Confiscated'),(171,'2024-07-12','Mababaw','Real','Calamba','Laguna','Penro','Yakal','20','400,100','Gilbert','N/A','Final Report submitted to R.O dated 06/25/2020','undefined','Confiscated last July','2024-10-16 15:09:53','2024-10-16',90,'150 bd','Mitsubishi-Fuso','4x4','WOW401','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','500','','Coals','Confiscated'),(172,'2024-08-08','Matalim','San Antonio','Pila','Laguna','Penro','Acacia','30','200,000.00','Jesica','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Confiscated last August','2024-10-16 15:14:10','2024-10-16',200,'150 bd','Mitsubishi-Fuso','4x4','WOW408','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','300','','Coals','Confiscated'),(173,'2024-09-13','Malabo','San Cristobal','San Pablo','Laguna','Penro','Coconuts','30','200,000.00','Wintel','ED Regional Office','0234918','undefined','Confiscated last Sept 13','2024-10-16 15:18:35','2024-10-16',31,'55.30','Toyota','Closed Van','404BOC','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','130','','Coals','Confiscated'),(174,'2024-10-10','Bahala','Bucal','Calamba','Laguna','Penro','Acacia','30','200,000.00','Faith','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Confiscated last October16','2024-10-16 15:20:52','2024-10-16',22,'21','Toyota','4x4','TOT777','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','130','','Coals','Confiscated'),(175,'2024-10-09','Maliwanag','Halang','Calamba','Laguna','Penro','Acacia','15','200,000.00','Bob','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Confiscated last Oct 9','2024-10-16 15:26:44','2024-10-16',21,'150 bd','Toyota','4x4','WOW400','carlo',NULL,'N/A','Lalakay','Los Banos','','500','','Coals','Confiscated'),(176,'2024-01-18','Magalang','Real','Calamba','Laguna','Penro','Coconuts','20','200,000.00','Jessie','ED Regional Office','Final Report submitted to R.O dated 09/03/2020','undefined','Test ','2024-10-16 16:47:21','2024-10-16',200,'150 bd','Toyota','4x4','TOT712','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','130','','Lumber','Confiscated'),(177,'2024-01-19','Mabaho','Halang','Calamba','Laguna','Penro','Yakal lumber','40','200,000.00','Alucard','ED Regional Office','Final Report submitted to R.O dated 06/25/2020','undefined','Test','2024-10-16 16:49:06','2024-10-16',60,'150 bd','Mitsubishi-Fuso','Truck','WLM-775','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','421','','Lumber','Confiscated'),(178,'2024-01-31','Mabango','Bucal','Calamba','Laguna','Penro','Acacia','15','100,000.00','Gusion','ED Regional Office','Final Report submitted to R.O dated 09/03/2020','undefined','Test','2024-10-16 16:51:16','2024-10-16',10,'150 bd','Mitsubishi-Fuso','4x4','HNA515','carlo',NULL,'N/A','Lalakay','Los Banos','Laguna','421','','Lumber','Confiscated');
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

-- Dump completed on 2024-10-30 23:05:20
