-- MySQL dump 10.13  Distrib 8.0.16, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: admin_ndis
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dumps`
--

DROP TABLE IF EXISTS `dumps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `dumps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dumps`
--

LOCK TABLES `dumps` WRITE;
/*!40000 ALTER TABLE `dumps` DISABLE KEYS */;
/*!40000 ALTER TABLE `dumps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external_service_providers`
--

DROP TABLE IF EXISTS `external_service_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `external_service_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_groups_id` int(10) unsigned DEFAULT NULL,
  `service_provided` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registration_groups_fk_58767` (`registration_groups_id`),
  CONSTRAINT `registration_groups_fk_58767` FOREIGN KEY (`registration_groups_id`) REFERENCES `registration_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external_service_providers`
--

LOCK TABLES `external_service_providers` WRITE;
/*!40000 ALTER TABLE `external_service_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `external_service_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_model_type_model_id_index` (`model_type`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (70,'2014_10_12_100000_create_password_resets_table',1),(71,'2019_02_20_000001_add_dumps_table',1),(72,'2019_05_09_132638603132_create_1557408399462_permissions_table',1),(73,'2019_05_09_132638648783_create_1557408399703_roles_table',1),(74,'2019_05_09_132638700992_create_1557408399910_users_table',1),(75,'2019_05_09_132639717703_create_1557408399717_permission_role_pivot_table',1),(76,'2019_05_09_132639833473_custom_1557408399833_create_media_table',1),(77,'2019_05_09_132639917689_create_1557408399917_role_user_pivot_table',1),(78,'2019_05_09_133402559731_custom_1557408842559_create_audit_logs_table',1),(79,'2019_05_09_133409328397_create_1557408851606_task_statuses_table',1),(80,'2019_05_09_133409375671_create_1557408851670_task_tags_table',1),(81,'2019_05_09_133409442641_create_1557408851776_tasks_table',1),(82,'2019_05_09_133411783296_create_1557408851783_task_task_tag_pivot_table',1),(83,'2019_05_09_133622842973_drop_1557408983851_audit_logs_table',1),(84,'2019_05_09_134224998936_create_1557409346644_transaction_types_table',1),(85,'2019_05_09_134225483474_create_1557409349908_notes_table',1),(86,'2019_05_09_134225553019_create_1557409349912_documents_table',1),(87,'2019_05_09_134225835580_create_1557409350391_transactions_table',1),(88,'2019_05_09_140648290131_create_1557410808768_participants_table',1),(89,'2019_05_09_140914828721_create_1557410955294_registration_groups_table',1),(90,'2019_05_09_141532489936_create_1557411333276_participant_funds_table',1),(91,'2019_05_09_141650098008_drop_1557411411421_transactions_table',1),(92,'2019_05_09_141650102522_drop_1557411411540_documents_table',1),(93,'2019_05_09_141650106780_drop_1557411412782_notes_table',1),(94,'2019_05_09_141650142798_drop_1557411413433_transaction_types_table',1),(95,'2019_05_10_105717425302_create_1557485839754_support_worker_documents_table',1),(96,'2019_05_10_110342299528_update_1557486223986_support_worker_documents_table',1),(97,'2019_05_17_063447330884_create_1558074888119_support_workers_table',1),(98,'2019_05_17_074207588722_create_1558078930136_external_service_providers_table',1),(99,'2019_05_17_074345928035_drop_1558079026295_transactions_table',1),(100,'2019_05_17_081055361702_create_1558080656895_service_bookings_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participant_funds`
--

DROP TABLE IF EXISTS `participant_funds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `participant_funds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(10) unsigned NOT NULL,
  `registration_group_id` int(10) unsigned NOT NULL,
  `funds` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `participant_fk_46180` (`participant_id`),
  KEY `registration_group_fk_46181` (`registration_group_id`),
  CONSTRAINT `participant_fk_46180` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `registration_group_fk_46181` FOREIGN KEY (`registration_group_id`) REFERENCES `registration_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participant_funds`
--

LOCK TABLES `participant_funds` WRITE;
/*!40000 ALTER TABLE `participant_funds` DISABLE KEYS */;
/*!40000 ALTER TABLE `participant_funds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants_details`
--

DROP TABLE IF EXISTS `participants_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `participants_details` (
  `participant_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date_ndis` date NOT NULL,
  `end_date_ndis` date NOT NULL,
  `ndis_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participant_goals` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_requirements` longtext COLLATE utf8mb4_unicode_ci,
  `budget_funding` double(8,2) NOT NULL DEFAULT '0.00',
  `funds_balance` double(12,2) NOT NULL DEFAULT '0.00',
  `using_guardian` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_onboarding_complete` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`participant_id`),
  CONSTRAINT `participants_details_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants_details`
--

LOCK TABLES `participants_details` WRITE;
/*!40000 ALTER TABLE `participants_details` DISABLE KEYS */;
INSERT INTO `participants_details` VALUES (1,'Any New Address','1231','123131','2019-04-18','2019-06-29','2342342',NULL,NULL,0.00,0.00,0,0,'2019-05-26 16:06:59','2019-05-26 16:06:59',NULL);
/*!40000 ALTER TABLE `participants_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `permission_role` (
  `role_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  KEY `role_id_fk_45955` (`role_id`),
  KEY `permission_id_fk_45955` (`permission_id`),
  CONSTRAINT `permission_id_fk_45955` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `role_id_fk_45955` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(1,46),(1,47),(1,48),(1,49),(1,50),(1,51),(1,52),(1,53),(1,54),(1,55),(1,56),(1,57),(1,58),(1,59),(1,60),(1,61),(1,62),(1,63),(1,64),(1,65),(1,66),(1,67),(1,68),(1,69),(1,70),(1,71),(1,72),(1,73),(2,17),(2,18),(2,19),(2,20),(2,21),(2,22),(2,23),(2,24),(2,25),(2,26),(2,27),(2,28),(2,29),(2,30),(2,31),(2,32),(2,33),(2,34),(2,35),(2,36),(2,37),(2,38),(2,39),(2,40),(2,41),(2,42),(2,43),(2,44),(2,45),(2,46),(2,47),(2,48),(2,49),(2,50),(2,51),(2,52),(2,53),(2,54),(2,55),(2,56),(2,57),(2,58),(2,59),(2,60),(2,61),(2,62),(2,63),(2,64),(2,65),(2,66),(2,67),(2,68),(2,69),(2,70),(2,71),(2,72),(2,73),(3,23),(3,25),(3,26),(3,28),(3,29),(3,30),(3,31),(3,32),(3,33),(4,23),(4,24),(4,25),(4,26),(4,27),(4,28),(4,29),(4,30),(4,31),(4,32),(4,33),(3,24),(3,27);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'user_management_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(2,'permission_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(3,'permission_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(4,'permission_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(5,'permission_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(6,'permission_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(7,'role_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(8,'role_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(9,'role_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(10,'role_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(11,'role_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(12,'user_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(13,'user_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(14,'user_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(15,'user_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(16,'user_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(17,'task_management_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(18,'task_status_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(19,'task_status_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(20,'task_status_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(21,'task_status_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(22,'task_status_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(23,'task_tag_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(24,'task_tag_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(25,'task_tag_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(26,'task_tag_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(27,'task_tag_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(28,'task_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(29,'task_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(30,'task_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(31,'task_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(32,'task_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(33,'tasks_calendar_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(34,'time_report_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(35,'time_report_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(36,'time_report_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(37,'time_report_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(38,'time_report_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(39,'participant_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(40,'participant_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(41,'participant_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(42,'participant_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(43,'participant_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(44,'registration_group_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(45,'registration_group_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(46,'registration_group_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(47,'registration_group_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(48,'registration_group_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(49,'participant_fund_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(50,'participant_fund_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(51,'participant_fund_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(52,'participant_fund_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(53,'participant_fund_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(54,'support_worker_document_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(55,'support_worker_document_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(56,'support_worker_document_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(57,'support_worker_document_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(58,'support_worker_document_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(59,'support_worker_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(60,'support_worker_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(61,'support_worker_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(62,'support_worker_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(63,'support_worker_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(64,'external_service_provider_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(65,'external_service_provider_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(66,'external_service_provider_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(67,'external_service_provider_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(68,'external_service_provider_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(69,'service_booking_create','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(70,'service_booking_edit','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(71,'service_booking_show','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(72,'service_booking_delete','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL),(73,'service_booking_access','2019-05-17 08:10:56','2019-05-17 08:10:56',NULL);
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_groups`
--

DROP TABLE IF EXISTS `registration_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `registration_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `price_limit` double(8,2) NOT NULL DEFAULT '0.00',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_groups`
--

LOCK TABLES `registration_groups` WRITE;
/*!40000 ALTER TABLE `registration_groups` DISABLE KEYS */;
INSERT INTO `registration_groups` VALUES (1,'Assistance with self-care activities - Standard','0',0.00,0,'1','2019-05-27 06:13:59','2019-05-27 06:13:59',NULL),(2,'Assistance With Self-Care Activities - Standard - Weekday Daytime','01_011_0107_1_1',48.14,1,'1','2019-05-27 06:14:57','2019-05-27 06:14:57',NULL);
/*!40000 ALTER TABLE `registration_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  KEY `user_id_fk_45964` (`user_id`),
  KEY `role_id_fk_45964` (`role_id`),
  CONSTRAINT `role_id_fk_45964` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `user_id_fk_45964` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','2019-05-09 13:26:39','2019-05-09 13:26:39',NULL),(2,'User','2019-05-09 13:26:39','2019-05-09 13:26:39',NULL),(3,'Participant','2019-05-26 14:38:07','2019-05-26 14:38:07',NULL),(4,'Support Worker','2019-05-26 14:39:01','2019-05-26 14:39:01',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_bookings`
--

DROP TABLE IF EXISTS `service_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `service_bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(10) unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `registration_group_id` int(10) unsigned DEFAULT NULL,
  `item_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_worker_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_bookings_participant_id_foreign` (`participant_id`),
  KEY `registration_group_fk_58809` (`registration_group_id`),
  KEY `support_worker_fk_58812` (`support_worker_id`),
  CONSTRAINT `registration_group_fk_58809` FOREIGN KEY (`registration_group_id`) REFERENCES `registration_groups` (`id`),
  CONSTRAINT `service_bookings_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `support_worker_fk_58812` FOREIGN KEY (`support_worker_id`) REFERENCES `support_workers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_bookings`
--

LOCK TABLES `service_bookings` WRITE;
/*!40000 ALTER TABLE `service_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_worker_documents`
--

DROP TABLE IF EXISTS `support_worker_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `support_worker_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_worker_documents`
--

LOCK TABLES `support_worker_documents` WRITE;
/*!40000 ALTER TABLE `support_worker_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_worker_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_workers`
--

DROP TABLE IF EXISTS `support_workers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `support_workers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_groups_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registration_groups_fk_58729` (`registration_groups_id`),
  CONSTRAINT `registration_groups_fk_58729` FOREIGN KEY (`registration_groups_id`) REFERENCES `registration_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_workers`
--

LOCK TABLES `support_workers` WRITE;
/*!40000 ALTER TABLE `support_workers` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_workers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_statuses`
--

DROP TABLE IF EXISTS `task_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `task_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_statuses`
--

LOCK TABLES `task_statuses` WRITE;
/*!40000 ALTER TABLE `task_statuses` DISABLE KEYS */;
INSERT INTO `task_statuses` VALUES (1,'Open','2019-05-09 13:34:11','2019-05-09 13:34:11',NULL),(2,'In progress','2019-05-09 13:34:11','2019-05-09 13:34:11',NULL),(3,'Closed','2019-05-09 13:34:11','2019-05-09 13:34:11',NULL);
/*!40000 ALTER TABLE `task_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_tags`
--

DROP TABLE IF EXISTS `task_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `task_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_tags`
--

LOCK TABLES `task_tags` WRITE;
/*!40000 ALTER TABLE `task_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_task_tag`
--

DROP TABLE IF EXISTS `task_task_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `task_task_tag` (
  `task_id` int(10) unsigned NOT NULL,
  `task_tag_id` int(10) unsigned NOT NULL,
  KEY `task_id_fk_46024` (`task_id`),
  KEY `task_tag_id_fk_46024` (`task_tag_id`),
  CONSTRAINT `task_id_fk_46024` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `task_tag_id_fk_46024` FOREIGN KEY (`task_tag_id`) REFERENCES `task_tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_task_tag`
--

LOCK TABLES `task_task_tag` WRITE;
/*!40000 ALTER TABLE `task_task_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `task_task_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `status_id` int(10) unsigned DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `assigned_to_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_fk_46023` (`status_id`),
  KEY `assigned_to_fk_46027` (`assigned_to_id`),
  CONSTRAINT `assigned_to_fk_46027` FOREIGN KEY (`assigned_to_id`) REFERENCES `users` (`id`),
  CONSTRAINT `status_fk_46023` FOREIGN KEY (`status_id`) REFERENCES `task_statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','deepak@superappbros.com.au',NULL,'$2y$10$pQfaazFex6HOHkns2ciNW.jrBqPi01sqEgDJyeKITd7iPzrBfZEjW',NULL,'2019-05-09 13:35:50','2019-05-26 14:23:58',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-27  6:49:26
