-- MySQL dump 10.13  Distrib 8.4.2, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: biconnect
-- ------------------------------------------------------
-- Server version	8.4.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('biconnect-cache-landing_stats','a:3:{s:5:\"users\";i:5;s:8:\"projects\";i:3;s:9:\"interests\";i:7;}',1783989489);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campuses`
--

DROP TABLE IF EXISTS `campuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campuses_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campuses`
--

LOCK TABLES `campuses` WRITE;
/*!40000 ALTER TABLE `campuses` DISABLE KEYS */;
INSERT INTO `campuses` VALUES (1,'Kramat 98 (Pusat)','Kramat 98','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(2,'Pemuda','Pemuda','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(3,'Salemba 22 & 45','Salemba 22 & 45','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(4,'Kramat 168','Kramat 168','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(5,'Dewisartika A & B','Dewisartika A & B','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(6,'Kalimalang','Kalimalang','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(7,'Jatiwaringin','Jatiwaringin','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(8,'Fatmawati','Fatmawati','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(9,'Warung Jati','Warung Jati','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(10,'Cengkareng','Cengkareng','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(11,'Slipi','Slipi','Wilayah DKI Jakarta','2026-06-27 19:02:31','2026-06-27 19:02:31'),(12,'Margonda','Margonda','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(13,'Bogor A, B & Cilebut','Bogor A, B & Cilebut','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(14,'BSD','BSD','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(15,'Ciledug','Ciledug','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(16,'Bekasi (Cut Mutia & Kaliabang)','Bekasi (Cut Mutia & Kaliabang)','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(17,'Cibitung','Cibitung','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(18,'Cikarang','Cikarang','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(19,'Sukabumi','Sukabumi','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(20,'Karawang','Karawang','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(21,'Cikampek','Cikampek','Wilayah Jawa Barat & Banten','2026-06-27 19:02:31','2026-06-27 19:02:31'),(22,'Tasikmalaya','Tasikmalaya','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31'),(23,'Tegal','Tegal','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31'),(24,'Purwokerto','Purwokerto','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31'),(25,'Surakarta','Surakarta','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31'),(26,'Yogyakarta','Yogyakarta','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31'),(27,'Pontianak','Pontianak','PSDKU','2026-06-27 19:02:31','2026-06-27 19:02:31');
/*!40000 ALTER TABLE `campuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_post_id_created_at_index` (`post_id`,`created_at`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,1,3,NULL,'Coba pastikan di tailwind.config.js content-nya pointing ke resources/**/*.blade.php, saya juga pernah stuck di masalah ini!','2026-06-26 03:43:07','2026-06-26 03:43:07'),(2,1,2,1,'Terima kasih kak Aditya! Ternyata emang path content-nya yang salah. Sudah fixed sekarang 🎉','2026-06-26 03:43:07','2026-06-26 03:43:07'),(3,1,5,NULL,'Mantap, saya juga baru mulai pakai Tailwind. Bookmark dulu buat referensi.','2026-06-26 03:43:07','2026-06-26 03:43:07'),(4,3,3,NULL,'Saya tertarik nih kak! Saya biasa pakai Figma dan sudah beberapa kali handle desain app mobile. Boleh diskusi lebih lanjut?','2026-06-26 03:43:07','2026-06-26 03:43:07'),(5,3,4,NULL,'Apakah masih open? Saya punya pengalaman di UI/UX research juga.','2026-06-26 03:43:07','2026-06-26 03:43:07'),(6,3,2,5,'Masih open kak, silakan! Nanti kita bisa bikin grup WA untuk koordinasi.','2026-06-26 03:43:07','2026-06-26 03:43:07'),(7,4,2,NULL,'Budget range-nya berapa ya kak? Dan estimasi waktu pengerjaannya berapa lama?','2026-06-26 03:43:07','2026-06-26 03:43:07');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_verification_tokens`
--

DROP TABLE IF EXISTS `email_verification_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_verification_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_verification_tokens_token_unique` (`token`),
  KEY `email_verification_tokens_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_verification_tokens`
--

LOCK TABLES `email_verification_tokens` WRITE;
/*!40000 ALTER TABLE `email_verification_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_verification_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `following_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `follows_follower_id_following_id_unique` (`follower_id`,`following_id`),
  KEY `follows_following_id_foreign` (`following_id`),
  CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info_hub`
--

DROP TABLE IF EXISTS `info_hub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `info_hub` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info_hub`
--

LOCK TABLES `info_hub` WRITE;
/*!40000 ALTER TABLE `info_hub` DISABLE KEYS */;
/*!40000 ALTER TABLE `info_hub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_01_000001_create_skills_table',1),(5,'2025_01_01_000002_create_user_skills_table',1),(6,'2025_01_01_000003_create_posts_table',1),(7,'2025_01_01_000004_create_post_skills_table',1),(8,'2025_01_01_000005_create_post_interests_table',1),(9,'2025_01_01_000006_create_comments_table',1),(10,'2025_01_01_000007_create_post_likes_table',1),(11,'2025_01_01_000008_create_follows_table',1),(12,'2025_01_01_000011_create_otp_verifications_table',1),(13,'2026_06_06_104119_create_notifications_table',1),(14,'2026_06_06_163237_add_onboarding_completed_to_users_table',1),(15,'2026_06_06_173135_add_is_active_to_users_table',1),(16,'2026_06_11_000001_create_info_hub_table',1),(17,'2026_06_11_000002_create_social_links_table',1),(18,'2026_06_25_000001_create_email_verification_tokens_table',1),(19,'2026_06_25_000002_add_status_to_posts_table',1),(20,'2026_06_28_000001_create_campuses_table',2),(21,'2026_07_03_000001_add_status_to_post_interests_table',3),(22,'2026_07_03_000002_add_whatsapp_to_users_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('0ff68ef2-07a4-44bd-9fc5-de134fee0720','App\\Notifications\\InterestSelected','App\\Models\\User',1,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 01:15:59','2026-07-07 01:15:59'),('1d69d30e-4a5d-4d91-a145-fa48ab18fb87','App\\Notifications\\CompleteProfile','App\\Models\\User',2,'{\"url\":\"http:\\/\\/biconnect.test\\/profile\\/edit\",\"message\":\"Lengkapi profil kamu agar lebih mudah ditemukan oleh rekan kolaborasi!\"}',NULL,'2026-07-05 03:39:42','2026-07-05 03:39:42'),('26a85afe-fb04-491a-af42-efb21e303be6','App\\Notifications\\InterestSelected','App\\Models\\User',1,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 01:21:02','2026-07-07 01:21:02'),('29755a40-b1bf-4fa5-9b38-043dde801d15','App\\Notifications\\InterestSelected','App\\Models\\User',4,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-06 21:47:14','2026-07-06 21:47:14'),('2ac3fe38-d161-4e88-abfe-31c94afff666','App\\Notifications\\ProjectApproved','App\\Models\\User',3,'{\"post_id\":6,\"post_title\":\"Project Building App integrasi AI\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/6\",\"message\":\"Project kamu \\\"Project Building App integrasi AI\\\" telah disetujui oleh admin dan sekarang aktif.\"}',NULL,'2026-07-06 01:12:16','2026-07-06 01:12:16'),('46a5623f-7fb2-40b9-833b-053eda20425e','App\\Notifications\\InterestSelected','App\\Models\\User',3,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-06 21:47:11','2026-07-06 21:47:11'),('55e8b368-4e10-4286-a3c1-4eead5cea868','App\\Notifications\\ProjectRejected','App\\Models\\User',3,'{\"post_id\":4,\"post_title\":\"Project Aplikasi Kasir (POS) UMKM Kuliner Margonda\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/4\",\"reason\":null,\"message\":\"Project kamu \\\"Project Aplikasi Kasir (POS) UMKM Kuliner Margonda\\\" ditolak oleh admin.\"}',NULL,'2026-07-06 01:34:43','2026-07-06 01:34:43'),('5bb64bbd-3754-4347-b382-690dc2dc73dc','App\\Notifications\\InterestSelected','App\\Models\\User',1,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 02:06:10','2026-07-07 02:06:10'),('9e86d7eb-8e37-4456-8098-f57a30cf12c7','App\\Notifications\\InterestSelected','App\\Models\\User',1,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 01:31:09','2026-07-07 01:31:09'),('a3683722-2c41-4a6d-874e-5fd76f9b6697','App\\Notifications\\CompleteProfile','App\\Models\\User',1,'{\"url\":\"http:\\/\\/biconnect.test\\/profile\\/edit\",\"message\":\"Lengkapi profil kamu agar lebih mudah ditemukan oleh rekan kolaborasi!\"}',NULL,'2026-07-06 01:12:00','2026-07-06 01:12:00'),('bc7eef82-b0eb-4335-9513-3a71e37d0344','App\\Notifications\\CompleteProfile','App\\Models\\User',3,'{\"url\":\"http:\\/\\/biconnect.test\\/profile\\/edit\",\"message\":\"Lengkapi profil kamu agar lebih mudah ditemukan oleh rekan kolaborasi!\"}',NULL,'2026-07-06 01:10:17','2026-07-06 01:10:17'),('c2c488da-9f79-4013-82f7-23e418135ad1','App\\Notifications\\ProjectApproved','App\\Models\\User',5,'{\"post_id\":5,\"post_title\":\"Belajar Kelompok Membuat Mobile Flutter App Sukarela\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/5\",\"message\":\"Project kamu \\\"Belajar Kelompok Membuat Mobile Flutter App Sukarela\\\" telah disetujui oleh admin dan sekarang aktif.\"}',NULL,'2026-07-06 21:33:57','2026-07-06 21:33:57'),('c992af78-22c6-48b1-bbae-ab96b442a976','App\\Notifications\\InterestSelected','App\\Models\\User',5,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 01:16:06','2026-07-07 01:16:06'),('def932b1-f012-4664-81c9-4a9eaa32bdb0','App\\Notifications\\NewInterest','App\\Models\\User',2,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"user_id\":1,\"user_name\":\"Administrator BSI\",\"user_avatar\":\"https:\\/\\/ui-avatars.com\\/api\\/?name=Administrator+BSI&background=EFF6FF&color=1E40AF&size=128&bold=true\",\"message\":\"Administrator BSI tertarik dengan project kamu \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\"\"}',NULL,'2026-07-06 21:44:34','2026-07-06 21:44:34'),('fe96f164-e259-4fbd-a4c0-c3704616040e','App\\Notifications\\InterestSelected','App\\Models\\User',1,'{\"post_id\":3,\"post_title\":\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\",\"url\":\"http:\\/\\/biconnect.test\\/post\\/3\",\"message\":\"Selamat! Kamu terpilih sebagai kandidat untuk project \\\"Dicari Partner UI\\/UX Designer untuk Project BiConnect\\\". Pemilik project akan segera menghubungimu.\"}',NULL,'2026-07-07 01:21:14','2026-07-07 01:21:14');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otp_verifications`
--

DROP TABLE IF EXISTS `otp_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otp_verifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otp_verifications_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otp_verifications`
--

LOCK TABLES `otp_verifications` WRITE;
/*!40000 ALTER TABLE `otp_verifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `otp_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_interests`
--

DROP TABLE IF EXISTS `post_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_interests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('pending','selected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_interests_post_id_user_id_unique` (`post_id`,`user_id`),
  KEY `post_interests_user_id_foreign` (`user_id`),
  CONSTRAINT `post_interests_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_interests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_interests`
--

LOCK TABLES `post_interests` WRITE;
/*!40000 ALTER TABLE `post_interests` DISABLE KEYS */;
INSERT INTO `post_interests` VALUES (1,3,3,'pending',NULL),(2,3,4,'pending',NULL),(3,3,5,'pending',NULL),(4,4,2,'pending',NULL),(5,5,2,'pending',NULL),(6,5,4,'pending',NULL),(7,3,1,'selected','2026-07-06 21:44:34');
/*!40000 ALTER TABLE `post_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_likes`
--

DROP TABLE IF EXISTS `post_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_likes` (
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `post_likes_user_id_foreign` (`user_id`),
  CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_likes`
--

LOCK TABLES `post_likes` WRITE;
/*!40000 ALTER TABLE `post_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_skills`
--

DROP TABLE IF EXISTS `post_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_skills` (
  `post_id` bigint unsigned NOT NULL,
  `skill_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`skill_id`),
  KEY `post_skills_skill_id_foreign` (`skill_id`),
  CONSTRAINT `post_skills_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_skills`
--

LOCK TABLES `post_skills` WRITE;
/*!40000 ALTER TABLE `post_skills` DISABLE KEYS */;
INSERT INTO `post_skills` VALUES (1,19),(4,19),(6,21),(1,22),(3,23),(6,23),(2,24),(5,24),(4,26),(3,28);
/*!40000 ALTER TABLE `post_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` enum('discussion','project') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `campus_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_type` enum('paid','unpaid','portfolio') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `status` enum('pending','approved','rejected','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_type_is_active_index` (`type`,`is_active`),
  KEY `posts_created_at_index` (`created_at`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,2,'discussion','Bagaimana cara setup Vite dengan Tailwind CSS v3 di Laravel 11?','Halo teman-teman BSI! Saya sedang mencoba mengintegrasikan Vite dengan Tailwind CSS v3 di project Laravel baru saya. Tapi ketika saya jalankan npm run dev, stylenya tidak masuk/tidak ter-load. \n\nApakah ada konfigurasi khusus di tailwind.config.js atau vite.config.js yang terlewat? Terima kasih sebelumnya!',NULL,NULL,'Kramat 98',NULL,1,'pending','2026-06-26 03:43:06','2026-06-26 03:43:06'),(2,4,'discussion','Rekomendasi topik Skripsi RPL BSI yang berfokus ke Mobile App','Permisi kak, saya semester 6 prodi RPL Kampus Cengkareng. Sedang mempersiapkan judul skripsi untuk semester depan. Rencananya mau buat aplikasi mobile. \n\nKira-kira topik apa ya yang sedang tren dan berpeluang besar diterima oleh dosen pembimbing? Apakah aplikasi e-learning, marketplace, atau smart city?',NULL,NULL,'Cengkareng',NULL,1,'pending','2026-06-26 03:43:07','2026-06-26 03:43:07'),(3,2,'project','Dicari Partner UI/UX Designer untuk Project BiConnect','Kami sedang membangun platform BiConnect menggunakan Laravel dan Alpine.js. Saat ini kami membutuhkan partner Designer untuk merancang mockup antarmuka pengguna agar lebih premium, modern, dan responsive.\n\nProject ini bersifat portfolio untuk skripsi, tapi jika hasil kerja memuaskan kita bisa kembangkan ke ranah komersial. Ditunggu kolaborasinya!',NULL,'2026-07-10','Kramat 98','portfolio',1,'approved','2026-06-26 03:43:07','2026-07-02 19:35:05'),(4,3,'project','Project Aplikasi Kasir (POS) UMKM Kuliner Margonda','Dibutuhkan developer backend Laravel untuk membantu menyelesaikan modul inventory dan integrasi payment gateway pada aplikasi kasir UMKM. Desain UI/UX sudah selesai di Figma. \n\nProject ini berbayar (Paid) dengan sistem bagi hasil atau borongan. Diutamakan mahasiswa domisili Depok agar mudah koordinasi offline.',NULL,'2026-07-03','Margonda','paid',0,'rejected','2026-06-26 03:43:07','2026-07-06 01:34:43'),(5,5,'project','Belajar Kelompok Membuat Mobile Flutter App Sukarela','Halo! Saya ingin membuat project iseng-iseng untuk belajar Flutter bareng. Targetnya adalah membuat clone aplikasi to-do list sederhana dengan integrasi Firebase.\n\nSifatnya unpaid (sukarela) untuk sama-sama belajar dari dasar. Siapa saja boleh gabung!',NULL,'2026-07-16','Jatiwaringin','unpaid',1,'approved','2026-06-26 03:43:07','2026-07-06 21:33:57'),(6,3,'project','Project Building App integrasi AI','bantu mengerjakan frontend untuk website yang terintegrasi dengan AI',NULL,'2026-07-09','BSD','unpaid',1,'approved','2026-07-06 01:11:36','2026-07-06 01:12:16');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('07C8gvJdn2oxwOiaMpo8vKbyVV3AvT3kRPU0PiJX',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJxbEdzTnN5bnppUFBVMGUzOEpqd2JsU0JVbWhLczQ1TTFVR2FUc1VkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783764108),('1tHpHr62u7Q2pjIrtLcCYXV3bpcA2kGOPzdakgPz',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI3RXNpSHZZMnZIZmo1cDB6ZjhZWWZnZUFVQUhHQks3dWtNZFFmZjRaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783434399),('2owc0FR2hSpUNuV2fnNSEWVVSd8kLbvLUQtkPQ1u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJPNUJhSVpWYklQMlA3akVWQW1EWFRqQno3N2YzWENrRHo2UnBZRExDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783575740),('5NGtPmq1fytD5YkbdajMQCVYJzfJ9nn7mgYYyEE9',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJNNkVZVkNlSjVDQTl4SXhBNnVZTlFWMXBra014a3dzZTRxbXRFU2tUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783598129),('5QZT4TbPI9bD9gt9gEw7u2FqRgwT09zpeLgEN6gf',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJiY3dTYVh3d2ZrUHAyTzlvck9qRjhoR1MwdEUwTUl3TjM0VU5ybzI4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783581916),('5w2J9MTCqiJ8q8CAwQnGf738L1EKuIdZ3VGnCfEe',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI2clFWSkF0d25nZGp2T2REd3VCaEJjZXJjaGE4V2NqRnVlQzVodUs4IiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvYmljb25uZWN0LnRlc3RcL2ZlZWQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783506426),('7ZGjVcpDQbi8UZWEMFqdf02O3tqY6kyCBIKfqnHM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJCcEVVblA4dTFmaUhNUEJFQ3ZFa1VXSldEUWxJbFZ4M09WckthSWd6IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783598153),('8p5ANxkS6uNpiTp4ZVy4CSnvatUB5EoxQfd3C6pr',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiI5R3Z0ajNqd3AwSTFOZ2N5ZFNHbklBRFlVaGJhNDNaSHpVcXRpTkJSIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783597986),('CacmrLzGk5JXcbobPVrhJkYs6Qm2DPnOic2NU2Oc',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJuUnZPNHZieTZXY0oyR0dGc0MxODdRMWxTenJVaThjRG1zQzFoMTNyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783597664),('EI5QstAxG6f8C8GWtefsek7UKpbXkr24VRaOD0dG',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI0NGRuWjg0ODZBMkQzUTR1djBjeW93MlIyN3BONEV1TVpGbm91WmNWIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvYmljb25uZWN0LnRlc3RcL3Bvc3RcLzMiLCJyb3V0ZSI6InBvc3Quc2hvdyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=',1783399665),('eR5o7Ca3l2GHVjxv2fg9Aw62eCSTTSVRH23X7QmF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiIyT3RMS0pVdUxLRTFFT1BiM0d0ZDU4bG1qYnl5UHhCdDRxQVE0Z0hIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783598121),('flu7pxRfaeJZucXCaSu6RYYaJLQdeHQDJrmML75u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJWc3B0Z2hYSE8zWjBJMGVNUlFCaFUxcW5jSjhhNmxRcDJ1R2VVZ3FrIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783575786),('FTrIAEHgf3kESN93pyc0PbFzaZ7hrdHgiDoV9Rj2',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ4cGZvRVVsVHpyVmd1RW1sTG8yaDQ3RFFZT0M0b1pBOWlXazhnZWloIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783941475),('Gih09PPiAJROf6IXVZ7cIxmtH4H2AIRb7DUsePlK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJOc01QOHRaY09nWVZ4S1FINEVhSHBqeW1rTTB1eGkyVzFIQnZRTGsyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783697082),('gsihidWG8pqKZhPUN1Q8a7Iuo8fV1J0otbQJWiKK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJQajlXRmwyanZ5SWtEOG5HNEpwYWtMbkxjTlpxOUtGN0E5Sm5ROEw4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783686170),('O9QITaOS4VAZ88LnTqMSOh4fDKSCfklTK4UN60nk',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJSWmhhNGpaRDZkZmFQYkU2dXc3M1J3WlVjc0xJVTlKZXU3N0Q2MFNXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783598111),('s44t4j0SqYZoahXSo2yD7tYYYf7ohrpiRxG61SHp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJYMzRPQWpNa2RTUEV1cjVtVjNVRHRDVnJqWDhoamp5WE1tcmliNXVFIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783575738),('T5XtnpsW30ik38iRK2qdbdgYr6C1EB3mVz7GIpeJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJROFJUTzIwTGZWSFdoVFVxSDRSMWhaaDNId0lZaEpWc0VZaWplUzhzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783599822),('TnBUoQ7twx8MrgP77e5s4ZnYr5teqzSu4dmEclAV',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJpR1RId0tPbDZEVFFtS3VwZTk2MGR3amY0cHU4TXd0WGNSZ2xhQTBLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783764112),('TVxj7ZPAyXobZhye29XIBTwGiE8mrfuKMH0bMA8a',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJla2JaUEg5bHpnc0M4RXR2Q0FEOHF4bDd0cWxqTkI4SFBuZklhNWtQIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783989190),('VTKyRLdBNa4HFevuX0SDFvS9UMayp0CppQyWi8eY',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJQMXVJYVpjWkxXZTZWV0FTUmd5a2tWOVRUbWE4eHJyYXdSNXJpQTdVIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJ1cmwiOltdLCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvYmljb25uZWN0LnRlc3RcL3Bvc3RcLzMiLCJyb3V0ZSI6InBvc3Quc2hvdyJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=',1783415327),('XLCsJ8vrDNvCt5gzsDCFlZOGOrk2xM3QHtx9yhLb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJnYzBUYVRHc1IwWUJQbjNRdU1BU2RINEFjdkxKclBmMUJnaGFoME5OIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783597750),('ZRpJ8konYp2WejBlhnQ2ThOZYnZHnacsFvRIhLy0',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.22.3 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36','eyJfdG9rZW4iOiJrVUZMaFhtekF3NGJXNGR1MUZBVUVQTHFWMDBDR3NRZEs4WnpjVDVpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2JpY29ubmVjdC50ZXN0XC8/aGVyZD1wcmV2aWV3Iiwicm91dGUiOiJsYW5kaW5nIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1783575983);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skills_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'UI/UX Design','2026-06-26 03:43:04','2026-06-26 03:43:04'),(2,'Graphic Design','2026-06-26 03:43:04','2026-06-26 03:43:04'),(3,'Web Development','2026-06-26 03:43:04','2026-06-26 03:43:04'),(4,'Android Development','2026-06-26 03:43:04','2026-06-26 03:43:04'),(5,'Data Analysis','2026-06-26 03:43:04','2026-06-26 03:43:04'),(6,'Copywriting','2026-06-26 03:43:04','2026-06-26 03:43:04'),(7,'Video Editing','2026-06-26 03:43:04','2026-06-26 03:43:04'),(8,'Social Media Management','2026-06-26 03:43:04','2026-06-26 03:43:04'),(9,'Riset & Analisis','2026-06-26 03:43:04','2026-06-26 03:43:04'),(10,'Presentasi','2026-06-26 03:43:04','2026-06-26 03:43:04'),(11,'Fotografi','2026-06-26 03:43:04','2026-06-26 03:43:04'),(12,'Ilustrasi','2026-06-26 03:43:04','2026-06-26 03:43:04'),(13,'Konten Kreatif','2026-06-26 03:43:04','2026-06-26 03:43:04'),(14,'Akuntansi','2026-06-26 03:43:04','2026-06-26 03:43:04'),(15,'Event Organizer','2026-06-26 03:43:04','2026-06-26 03:43:04'),(16,'Backend Development','2026-06-26 03:43:04','2026-06-26 03:43:04'),(17,'Machine Learning','2026-06-26 03:43:04','2026-06-26 03:43:04'),(18,'Mobile Development','2026-06-26 03:43:04','2026-06-26 03:43:04'),(19,'Laravel','2026-06-26 03:43:05','2026-06-26 03:43:05'),(20,'Vue.js','2026-06-26 03:43:05','2026-06-26 03:43:05'),(21,'React','2026-06-26 03:43:05','2026-06-26 03:43:05'),(22,'Tailwind CSS','2026-06-26 03:43:05','2026-06-26 03:43:05'),(23,'Figma','2026-06-26 03:43:05','2026-06-26 03:43:05'),(24,'Flutter','2026-06-26 03:43:05','2026-06-26 03:43:05'),(25,'Python','2026-06-26 03:43:05','2026-06-26 03:43:05'),(26,'MySQL','2026-06-26 03:43:05','2026-06-26 03:43:05'),(27,'PHP','2026-06-26 03:43:05','2026-06-26 03:43:05'),(28,'Alpine.js','2026-06-26 03:43:05','2026-06-26 03:43:05'),(29,'Git','2026-06-26 03:43:05','2026-06-26 03:43:05');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `social_links_user_id_platform_unique` (`user_id`,`platform`),
  CONSTRAINT `social_links_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES (1,2,'linkedin','https://www.linkedin.com/in/ruhul-ikram/','2026-06-28 04:51:09','2026-06-28 04:51:09'),(2,2,'github','https://www.linkedin.com/in/ruhul-ikram/','2026-06-28 04:51:09','2026-06-28 04:51:09'),(3,2,'instagram','https://www.linkedin.com/in/ruhul-ikram/','2026-06-28 04:51:09','2026-06-28 04:51:09'),(4,2,'twitter','https://www.linkedin.com/in/ruhul-ikram/','2026-06-28 04:51:09','2026-06-28 04:51:09'),(5,2,'website','https://www.linkedin.com/in/ruhul-ikram/','2026-06-28 04:51:09','2026-06-28 04:51:09');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_skills`
--

DROP TABLE IF EXISTS `user_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_skills` (
  `user_id` bigint unsigned NOT NULL,
  `skill_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`skill_id`),
  KEY `user_skills_skill_id_foreign` (`skill_id`),
  CONSTRAINT `user_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_skills`
--

LOCK TABLES `user_skills` WRITE;
/*!40000 ALTER TABLE `user_skills` DISABLE KEYS */;
INSERT INTO `user_skills` VALUES (1,4),(1,16);
/*!40000 ALTER TABLE `user_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `semester` tinyint unsigned DEFAULT NULL,
  `campus_area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `onboarding_completed` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nim_unique` (`nim`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator BSI','admin@biconnect.bsi.ac.id',NULL,'$2y$12$qF4RFRRjN9t9KWCM/poAp.ESDZqfsukY3YMYuECZoZpxfovlHBTiO',NULL,'Staff IT',NULL,'Kramat 98','Akun Administrator Sistem BiConnect.','081234567890',NULL,NULL,0,1,1,1,1,'BIwVBSbin2vrgLhM4SBr1Dkk15RjJln9xRCtivRSr411gXle87vd2eAsfhQI','2026-06-26 03:43:05','2026-07-07 01:31:08'),(2,'Ikram Maulana','ikram.maulana@bsi.ac.id',NULL,'$2y$12$ZrE2SjMKmnx5qZYw/sxpm.oFAZ/mXBKtuO5N9j1cra.phPgSYlwsi','12210001','Sistem Informasi',6,'Kramat 98','Fullstack Developer. Suka Laravel & Tailwind CSS.','081234567891','avatars/vFIqrt67cqaE8PuV74mFy3BIuTBvLG5I2cTymTvs.jpg',NULL,0,0,1,1,1,'ASpcME3dXX0FpxRg37MJPx5EbyEvcJNwYSdPoByDa1ofZxVc04ZAsmjTTr9j','2026-06-26 03:43:05','2026-07-07 01:31:08'),(3,'Aditya Wijaya','aditya.wijaya@bsi.ac.id',NULL,'$2y$12$zDIL1h/BPUtSaGMT.qIdk.FxIQgBxOcEzPuKr1YIe7E27YhiqlnsC','12210002','Teknologi Informasi',4,'Margonda','UI/UX Designer enthusiast & Figma lover.','081234567892',NULL,NULL,0,0,1,1,1,NULL,'2026-06-26 03:43:05','2026-07-07 01:31:08'),(4,'Siti Aminah','siti.aminah@bsi.ac.id',NULL,'$2y$12$4f76cTlDXqLWd2ktdPH.Hej.NseeotSYEYOJawHowhZ4R.qFyWEcG','12210003','Rekayasa Perangkat Lunak',6,'Cengkareng','Mobile Developer learning Flutter & React Native.','081234567893',NULL,NULL,0,0,1,0,1,NULL,'2026-06-26 03:43:05','2026-07-07 01:31:08'),(5,'Budi Santoso','budi.santoso@bsi.ac.id',NULL,'$2y$12$TAYDlLYXUPmuum7PIUclCuzFN2Wqkpgh4edkPnKCE5lT1.s0XesIm','12210004','Sistem Informasi',2,'Jatiwaringin','Junior Web Developer. Sedang belajar PHP dasar.','081234567894',NULL,NULL,0,0,1,1,1,NULL,'2026-06-26 03:43:05','2026-07-07 01:31:08');
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

-- Dump completed on 2026-07-18 11:24:29