-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kgb
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_day` date NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES (29,'Flata','Najib','1982-11-09','HDHD33','FR'),(30,'KAMAL','ERRAMLAOUI','1982-11-02','007','ES'),(31,'naim','karim','1990-11-02','Blanca','AU'),(32,'Jean','Baptiste','1980-12-10','HULK','FR'),(33,'farid','swissri','1975-10-02','Aladin','DE'),(34,'Alice','Hugette','1970-12-01','Kimora','FR');
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_mission`
--

DROP TABLE IF EXISTS `agent_mission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_mission` (
  `agent_id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`mission_id`),
  KEY `IDX_423490963414710B` (`agent_id`),
  KEY `IDX_42349096BE6CAE90` (`mission_id`),
  CONSTRAINT `FK_423490963414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_42349096BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_mission`
--

LOCK TABLES `agent_mission` WRITE;
/*!40000 ALTER TABLE `agent_mission` DISABLE KEYS */;
/*!40000 ALTER TABLE `agent_mission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agent_speciality`
--

DROP TABLE IF EXISTS `agent_speciality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_speciality` (
  `agent_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  PRIMARY KEY (`agent_id`,`speciality_id`),
  KEY `IDX_829171813414710B` (`agent_id`),
  KEY `IDX_829171813B5A08D7` (`speciality_id`),
  CONSTRAINT `FK_829171813414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_829171813B5A08D7` FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_speciality`
--

LOCK TABLES `agent_speciality` WRITE;
/*!40000 ALTER TABLE `agent_speciality` DISABLE KEYS */;
INSERT INTO `agent_speciality` VALUES (29,14),(29,16),(30,15),(30,17),(31,15),(31,16),(32,16),(32,17),(33,14),(34,15),(34,16),(34,17);
/*!40000 ALTER TABLE `agent_speciality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_day` date NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (6,'Flata','Yassine','1988-11-01','Alpha2','MA'),(7,'BAHADI','CHAKIB','1980-11-01','Kim006','DE'),(8,'Marie','Fingers','2022-08-20','BETA09','DZ');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_mission`
--

DROP TABLE IF EXISTS `contact_mission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_mission` (
  `contact_id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL,
  PRIMARY KEY (`contact_id`,`mission_id`),
  KEY `IDX_A48D3BDE7A1254A` (`contact_id`),
  KEY `IDX_A48D3BDBE6CAE90` (`mission_id`),
  CONSTRAINT `FK_A48D3BDBE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A48D3BDE7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_mission`
--

LOCK TABLES `contact_mission` WRITE;
/*!40000 ALTER TABLE `contact_mission` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_mission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220808222104',NULL,NULL),('DoctrineMigrations\\Version20220810190924','2022-08-10 21:09:32',151),('DoctrineMigrations\\Version20220810191320','2022-08-10 21:13:25',128),('DoctrineMigrations\\Version20220811131118','2022-08-11 15:11:27',375),('DoctrineMigrations\\Version20220811133305','2022-08-11 15:33:12',44);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission`
--

DROP TABLE IF EXISTS `mission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9067F23CC54C8C93` (`type_id`),
  KEY `IDX_9067F23C6BF700BD` (`status_id`),
  KEY `IDX_9067F23C3B5A08D7` (`speciality_id`),
  CONSTRAINT `FK_9067F23C3B5A08D7` FOREIGN KEY (`speciality_id`) REFERENCES `speciality` (`id`),
  CONSTRAINT `FK_9067F23C6BF700BD` FOREIGN KEY (`status_id`) REFERENCES `mission_status` (`id`),
  CONSTRAINT `FK_9067F23CC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `mission_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission`
--

LOCK TABLES `mission` WRITE;
/*!40000 ALTER TABLE `mission` DISABLE KEYS */;
INSERT INTO `mission` VALUES (21,9,7,14,'Crosswind','Aniyah Coalition','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.','DZ','2022-08-13','2022-08-14'),(23,7,6,14,'Harbinger','Harbinger','Caves Coalition','DE','2022-08-19','2022-08-26'),(24,8,9,14,'Just Reward','Bale','\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat vol','DZ','2022-08-20','2022-08-28'),(25,8,8,14,'Strongbox','Strongbox chasseur prime','\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat vol','DE','2022-08-20','2022-08-28'),(26,8,7,14,'Headhunter','Headhunter Plus','Headhunter','DE','2022-08-21','2022-08-21'),(27,7,6,16,'Kuvalda Arabica','Kuvalda Arabica','\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat vol','DZ','2022-08-13','2022-08-14');
/*!40000 ALTER TABLE `mission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_agent`
--

DROP TABLE IF EXISTS `mission_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_agent` (
  `mission_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  PRIMARY KEY (`mission_id`,`agent_id`),
  KEY `IDX_B61DC3A0BE6CAE90` (`mission_id`),
  KEY `IDX_B61DC3A03414710B` (`agent_id`),
  CONSTRAINT `FK_B61DC3A03414710B` FOREIGN KEY (`agent_id`) REFERENCES `agent` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_B61DC3A0BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_agent`
--

LOCK TABLES `mission_agent` WRITE;
/*!40000 ALTER TABLE `mission_agent` DISABLE KEYS */;
INSERT INTO `mission_agent` VALUES (21,30),(23,30),(23,31),(23,33),(24,30),(24,33),(25,31),(26,29),(26,30),(26,34),(27,30),(27,31);
/*!40000 ALTER TABLE `mission_agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_contact`
--

DROP TABLE IF EXISTS `mission_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_contact` (
  `mission_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`mission_id`,`contact_id`),
  KEY `IDX_DD5E7275BE6CAE90` (`mission_id`),
  KEY `IDX_DD5E7275E7A1254A` (`contact_id`),
  CONSTRAINT `FK_DD5E7275BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DD5E7275E7A1254A` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_contact`
--

LOCK TABLES `mission_contact` WRITE;
/*!40000 ALTER TABLE `mission_contact` DISABLE KEYS */;
INSERT INTO `mission_contact` VALUES (21,8),(23,7),(24,8),(25,7),(26,7),(27,8);
/*!40000 ALTER TABLE `mission_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_planque`
--

DROP TABLE IF EXISTS `mission_planque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_planque` (
  `mission_id` int(11) NOT NULL,
  `planque_id` int(11) NOT NULL,
  PRIMARY KEY (`mission_id`,`planque_id`),
  KEY `IDX_DA0690F7BE6CAE90` (`mission_id`),
  KEY `IDX_DA0690F7CE8A20B` (`planque_id`),
  CONSTRAINT `FK_DA0690F7BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DA0690F7CE8A20B` FOREIGN KEY (`planque_id`) REFERENCES `planque` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_planque`
--

LOCK TABLES `mission_planque` WRITE;
/*!40000 ALTER TABLE `mission_planque` DISABLE KEYS */;
INSERT INTO `mission_planque` VALUES (23,9),(26,9),(26,10);
/*!40000 ALTER TABLE `mission_planque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_status`
--

DROP TABLE IF EXISTS `mission_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_status`
--

LOCK TABLES `mission_status` WRITE;
/*!40000 ALTER TABLE `mission_status` DISABLE KEYS */;
INSERT INTO `mission_status` VALUES (6,'En cours'),(7,'En préparation'),(8,'Echec'),(9,'Terminée');
/*!40000 ALTER TABLE `mission_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_target`
--

DROP TABLE IF EXISTS `mission_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_target` (
  `mission_id` int(11) NOT NULL,
  `target_id` int(11) NOT NULL,
  PRIMARY KEY (`mission_id`,`target_id`),
  KEY `IDX_1E97F5B2BE6CAE90` (`mission_id`),
  KEY `IDX_1E97F5B2158E0B66` (`target_id`),
  CONSTRAINT `FK_1E97F5B2158E0B66` FOREIGN KEY (`target_id`) REFERENCES `target` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1E97F5B2BE6CAE90` FOREIGN KEY (`mission_id`) REFERENCES `mission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_target`
--

LOCK TABLES `mission_target` WRITE;
/*!40000 ALTER TABLE `mission_target` DISABLE KEYS */;
INSERT INTO `mission_target` VALUES (21,5),(23,5),(24,7),(25,5),(25,7),(26,8),(27,6);
/*!40000 ALTER TABLE `mission_target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_type`
--

DROP TABLE IF EXISTS `mission_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mission_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_type`
--

LOCK TABLES `mission_type` WRITE;
/*!40000 ALTER TABLE `mission_type` DISABLE KEYS */;
INSERT INTO `mission_type` VALUES (7,'Surveillance'),(8,'Assassinat'),(9,'Infiltration');
/*!40000 ALTER TABLE `mission_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planque`
--

DROP TABLE IF EXISTS `planque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B3A04BAC54C8C93` (`type_id`),
  CONSTRAINT `FK_4B3A04BAC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `planque_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planque`
--

LOCK TABLES `planque` WRITE;
/*!40000 ALTER TABLE `planque` DISABLE KEYS */;
INSERT INTO `planque` VALUES (8,6,'HMSK25','106 rue de la marre 972012 USA','US'),(9,8,'RIO2','107 rue de la 106 costa rica','DE'),(10,7,'GOST01','81 socoma 1 n 1008','DE'),(11,7,'Mort','Section 1.10.32 du \"De Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)','AR'),(12,9,'Iron55','Section 1.10.32 du \"De Finibus  85 bis','FR'),(13,6,'Discoteka','Finibus Bonorum et Malorum\" de Ciceron (45 av. J.-C.)','AT');
/*!40000 ALTER TABLE `planque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planque_type`
--

DROP TABLE IF EXISTS `planque_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planque_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planque_type`
--

LOCK TABLES `planque_type` WRITE;
/*!40000 ALTER TABLE `planque_type` DISABLE KEYS */;
INSERT INTO `planque_type` VALUES (6,'Nivada'),(7,'Bolivia'),(8,'Cachète'),(9,'Costa Riko');
/*!40000 ALTER TABLE `planque_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speciality`
--

DROP TABLE IF EXISTS `speciality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speciality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speciality`
--

LOCK TABLES `speciality` WRITE;
/*!40000 ALTER TABLE `speciality` DISABLE KEYS */;
INSERT INTO `speciality` VALUES (14,'Piragate'),(15,'Sport combat'),(16,'Avions'),(17,'Drônes'),(18,'Pillage'),(19,'Communication');
/*!40000 ALTER TABLE `speciality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `target`
--

DROP TABLE IF EXISTS `target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `target` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_day` date NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `target`
--

LOCK TABLES `target` WRITE;
/*!40000 ALTER TABLE `target` DISABLE KEYS */;
INSERT INTO `target` VALUES (5,'Tyron','D','2006-11-02','HS55HS','FR'),(6,'Cornier','Marie','1985-10-31','MMSS55','DZ'),(7,'Marie','Cornier','1990-11-01','Cendrillon','FR'),(8,'Céline','mamarine','1980-12-15','Douce15','DE');
/*!40000 ALTER TABLE `target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'havikoro2004@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$FN81eR6wmOfwlIyvnyRGb.tD3YQVzw6dGE/uYit9Wspiavb33vwaq','najib','flata','2022-08-08');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-16 15:59:59
