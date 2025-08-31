-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: jaajfm
-- ------------------------------------------------------
-- Server version	8.0.30

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
-- Table structure for table `analytics_music_likes`
--

DROP TABLE IF EXISTS `analytics_music_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_music_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `music_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `liked_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_music_likes_music_id_liked_at_index` (`music_id`,`liked_at`),
  KEY `analytics_music_likes_user_id_liked_at_index` (`user_id`,`liked_at`),
  CONSTRAINT `analytics_music_likes_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analytics_music_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_music_likes`
--

LOCK TABLES `analytics_music_likes` WRITE;
/*!40000 ALTER TABLE `analytics_music_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_music_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_music_plays`
--

DROP TABLE IF EXISTS `analytics_music_plays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_music_plays` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `music_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `played_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_music_plays_music_id_played_at_index` (`music_id`,`played_at`),
  KEY `analytics_music_plays_user_id_played_at_index` (`user_id`,`played_at`),
  CONSTRAINT `analytics_music_plays_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analytics_music_plays_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_music_plays`
--

LOCK TABLES `analytics_music_plays` WRITE;
/*!40000 ALTER TABLE `analytics_music_plays` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_music_plays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_music_views`
--

DROP TABLE IF EXISTS `analytics_music_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_music_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `music_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `viewed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_music_views_music_id_viewed_at_index` (`music_id`,`viewed_at`),
  KEY `analytics_music_views_user_id_viewed_at_index` (`user_id`,`viewed_at`),
  CONSTRAINT `analytics_music_views_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analytics_music_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_music_views`
--

LOCK TABLES `analytics_music_views` WRITE;
/*!40000 ALTER TABLE `analytics_music_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_music_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_page_views`
--

DROP TABLE IF EXISTS `analytics_page_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_page_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `referrer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_page_views_url_viewed_at_index` (`url`,`viewed_at`),
  KEY `analytics_page_views_user_id_viewed_at_index` (`user_id`,`viewed_at`),
  CONSTRAINT `analytics_page_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_page_views`
--

LOCK TABLES `analytics_page_views` WRITE;
/*!40000 ALTER TABLE `analytics_page_views` DISABLE KEYS */;
INSERT INTO `analytics_page_views` VALUES (1,'http://jaajfm.test/',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','http://jaajfm.test/music/digital-love','2025-08-31 03:29:31','2025-08-31 03:30:31','2025-08-31 03:30:31'),(2,'http://jaajfm.test/',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','http://jaajfm.test/','2025-08-31 04:00:42','2025-08-31 04:00:48','2025-08-31 04:00:48');
/*!40000 ALTER TABLE `analytics_page_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_playlist_creates`
--

DROP TABLE IF EXISTS `analytics_playlist_creates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_playlist_creates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `playlist_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL,
  `tracked_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_playlist_creates_playlist_id_foreign` (`playlist_id`),
  KEY `analytics_playlist_creates_user_id_created_at_index` (`user_id`,`created_at`),
  CONSTRAINT `analytics_playlist_creates_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analytics_playlist_creates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_playlist_creates`
--

LOCK TABLES `analytics_playlist_creates` WRITE;
/*!40000 ALTER TABLE `analytics_playlist_creates` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_playlist_creates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_searches`
--

DROP TABLE IF EXISTS `analytics_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_searches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `results_count` int NOT NULL DEFAULT '0',
  `searched_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_searches_query_searched_at_index` (`query`,`searched_at`),
  KEY `analytics_searches_user_id_searched_at_index` (`user_id`,`searched_at`),
  CONSTRAINT `analytics_searches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_searches`
--

LOCK TABLES `analytics_searches` WRITE;
/*!40000 ALTER TABLE `analytics_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analytics_user_follows`
--

DROP TABLE IF EXISTS `analytics_user_follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analytics_user_follows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `followed_id` bigint unsigned NOT NULL,
  `followed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analytics_user_follows_follower_id_followed_at_index` (`follower_id`,`followed_at`),
  KEY `analytics_user_follows_followed_id_followed_at_index` (`followed_id`,`followed_at`),
  CONSTRAINT `analytics_user_follows_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analytics_user_follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analytics_user_follows`
--

LOCK TABLES `analytics_user_follows` WRITE;
/*!40000 ALTER TABLE `analytics_user_follows` DISABLE KEYS */;
/*!40000 ALTER TABLE `analytics_user_follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#6366f1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_likes`
--

DROP TABLE IF EXISTS `comment_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `comment_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comment_likes_user_id_comment_id_unique` (`user_id`,`comment_id`),
  KEY `comment_likes_comment_id_foreign` (`comment_id`),
  CONSTRAINT `comment_likes_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_likes`
--

LOCK TABLES `comment_likes` WRITE;
/*!40000 ALTER TABLE `comment_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `music_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_music_id_foreign` (`music_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  CONSTRAINT `comments_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Super chanson ! 🎵',1,1,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,'J\'adore cette mélodie',2,2,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,'Très bien produit !',3,3,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,'Parfait pour se détendre',4,4,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(5,'Excellent travail !',5,5,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(6,'Génial ! 👏',6,6,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cookie_consents`
--

DROP TABLE IF EXISTS `cookie_consents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cookie_consents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `consent_data` json NOT NULL,
  `consented_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cookie_consents_user_id_consented_at_index` (`user_id`,`consented_at`),
  KEY `cookie_consents_ip_address_consented_at_index` (`ip_address`,`consented_at`),
  CONSTRAINT `cookie_consents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cookie_consents`
--

LOCK TABLES `cookie_consents` WRITE;
/*!40000 ALTER TABLE `cookie_consents` DISABLE KEYS */;
/*!40000 ALTER TABLE `cookie_consents` ENABLE KEYS */;
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
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
  `attempts` tinyint unsigned NOT NULL,
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
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `music_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `likes_user_id_music_id_unique` (`user_id`,`music_id`),
  KEY `likes_music_id_foreign` (`music_id`),
  CONSTRAINT `likes_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,2,2,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,3,3,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,4,4,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(5,5,5,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(6,6,6,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(7,7,7,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(8,1,8,'2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_01_21_000001_create_categories_table',1),(5,'2025_01_21_000002_create_musics_table',1),(6,'2025_01_21_000003_create_likes_table',1),(7,'2025_01_21_000004_create_comments_table',1),(8,'2025_01_21_000005_create_playlists_table',1),(9,'2025_01_21_000006_create_playlist_music_table',1),(10,'2025_01_21_000007_create_user_follows_table',1),(11,'2025_01_22_000001_add_missing_fields_to_musics_table',1),(12,'2025_01_23_000001_add_slug_to_playlists_table',1),(13,'2025_01_23_000002_create_posts_table',1),(14,'2025_01_23_000003_create_post_comments_table',1),(15,'2025_01_23_000004_add_cover_image_to_playlists_and_music_tables',1),(16,'2025_01_23_000005_create_music_genres_table',1),(17,'2025_01_23_000006_create_music_genre_table',1),(18,'2025_01_23_000008_create_analytics_tables',1),(19,'2025_01_23_000009_add_is_ai_generated_to_musics_table',1),(20,'2025_01_23_000010_fix_music_file_paths',1),(21,'2025_01_23_000011_add_is_admin_to_users_table',1),(22,'2025_01_23_000012_create_reports_table',1),(23,'2025_01_23_000013_create_comment_likes_table',1),(24,'2025_08_16_195649_add_two_factor_columns_to_users_table',1),(25,'2025_08_16_195712_create_personal_access_tokens_table',1),(26,'2025_08_24_000001_add_slug_to_musics_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music_genre`
--

DROP TABLE IF EXISTS `music_genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `music_genre` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `music_id` bigint unsigned NOT NULL,
  `music_genre_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `music_genre_music_id_music_genre_id_unique` (`music_id`,`music_genre_id`),
  KEY `music_genre_music_genre_id_foreign` (`music_genre_id`),
  CONSTRAINT `music_genre_music_genre_id_foreign` FOREIGN KEY (`music_genre_id`) REFERENCES `music_genres` (`id`) ON DELETE CASCADE,
  CONSTRAINT `music_genre_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music_genre`
--

LOCK TABLES `music_genre` WRITE;
/*!40000 ALTER TABLE `music_genre` DISABLE KEYS */;
INSERT INTO `music_genre` VALUES (1,1,145,NULL,NULL),(2,1,296,NULL,NULL),(3,2,103,NULL,NULL),(4,2,129,NULL,NULL),(5,2,198,NULL,NULL),(6,2,226,NULL,NULL),(7,3,74,NULL,NULL),(8,3,113,NULL,NULL),(9,4,14,NULL,NULL),(10,4,58,NULL,NULL),(11,4,273,NULL,NULL),(12,5,59,NULL,NULL),(13,6,143,NULL,NULL),(14,6,176,NULL,NULL),(15,6,225,NULL,NULL),(16,7,106,NULL,NULL),(17,8,50,NULL,NULL),(18,8,131,NULL,NULL),(19,8,138,NULL,NULL),(20,8,190,NULL,NULL),(21,9,137,NULL,NULL),(22,9,302,NULL,NULL),(23,10,211,NULL,NULL);
/*!40000 ALTER TABLE `music_genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music_genres`
--

DROP TABLE IF EXISTS `music_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `music_genres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#8B5CF6',
  `parent_id` bigint unsigned DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `music_genres_slug_unique` (`slug`),
  KEY `music_genres_parent_id_order_index` (`parent_id`,`order`),
  CONSTRAINT `music_genres_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `music_genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=312 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music_genres`
--

LOCK TABLES `music_genres` WRITE;
/*!40000 ALTER TABLE `music_genres` DISABLE KEYS */;
INSERT INTO `music_genres` VALUES (1,'Musique Classique et Savante','musique-classique-et-savante',NULL,'#1E40AF',NULL,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,'Musique médiévale','musique-medievale',NULL,'#3B82F6',1,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,'Grégorien','gregorien',NULL,'#60A5FA',2,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,'Organum','organum',NULL,'#60A5FA',2,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(5,'Ars Nova','ars-nova',NULL,'#60A5FA',2,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(6,'Renaissance','renaissance',NULL,'#3B82F6',1,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(7,'Madrigal','madrigal',NULL,'#60A5FA',6,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(8,'Chanson','chanson',NULL,'#60A5FA',6,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(9,'Motet','motet',NULL,'#60A5FA',6,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(10,'Baroque','baroque',NULL,'#3B82F6',1,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(11,'Concerto','concerto',NULL,'#60A5FA',10,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(12,'Fugue','fugue',NULL,'#60A5FA',10,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(13,'Suite','suite',NULL,'#60A5FA',10,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(14,'Oratorio','oratorio',NULL,'#60A5FA',10,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(15,'Classique','classique',NULL,'#3B82F6',1,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(16,'Sonate','sonate',NULL,'#60A5FA',15,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(17,'Symphonie','symphonie',NULL,'#60A5FA',15,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(18,'Quatuor','quatuor',NULL,'#60A5FA',15,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(19,'Romantique','romantique',NULL,'#3B82F6',1,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(20,'Lied','lied',NULL,'#60A5FA',19,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(21,'Poème symphonique','poeme-symphonique',NULL,'#60A5FA',19,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(22,'Impressionnisme','impressionnisme',NULL,'#3B82F6',1,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(23,'Musique du XXe siècle','musique-du-xxe-siecle',NULL,'#3B82F6',1,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(24,'Dodécaphonisme','dodecaphonisme',NULL,'#60A5FA',23,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(25,'Sérialisme','serialisme',NULL,'#60A5FA',23,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(26,'Musique contemporaine','musique-contemporaine',NULL,'#3B82F6',1,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(27,'Spectrale','spectrale',NULL,'#60A5FA',26,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(28,'Électroacoustique','electroacoustique',NULL,'#60A5FA',26,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(29,'Opéra','opera',NULL,'#3B82F6',1,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(30,'Opera seria','opera-seria',NULL,'#60A5FA',29,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(31,'Opera buffa','opera-buffa',NULL,'#60A5FA',29,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(32,'Grand opéra','grand-opera',NULL,'#60A5FA',29,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(33,'Musique de chambre','musique-de-chambre',NULL,'#3B82F6',1,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(34,'Musique sacrée','musique-sacree',NULL,'#3B82F6',1,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(35,'Messe','messe',NULL,'#60A5FA',34,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(36,'Requiem','requiem',NULL,'#60A5FA',34,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(37,'Te Deum','te-deum',NULL,'#60A5FA',34,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(38,'Musique symphonique','musique-symphonique',NULL,'#3B82F6',1,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(39,'Concerto','concerto-1',NULL,'#3B82F6',1,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(40,'Solo','solo',NULL,'#60A5FA',39,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(41,'Grosso','grosso',NULL,'#60A5FA',39,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(42,'Musique vocale','musique-vocale',NULL,'#3B82F6',1,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(43,'Oratorio','oratorio-1',NULL,'#60A5FA',42,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(44,'Cantate','cantate',NULL,'#60A5FA',42,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(45,'Lied','lied-1',NULL,'#60A5FA',42,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(46,'Jazz et Musiques Improvisées','jazz-et-musiques-improvisees',NULL,'#DC2626',NULL,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(47,'Dixieland','dixieland',NULL,'#EF4444',46,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(48,'Swing','swing',NULL,'#EF4444',46,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(49,'Bebop','bebop',NULL,'#EF4444',46,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(50,'Cool Jazz','cool-jazz',NULL,'#EF4444',46,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(51,'Hard Bop','hard-bop',NULL,'#EF4444',46,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(52,'Free Jazz','free-jazz',NULL,'#EF4444',46,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(53,'Fusion','fusion',NULL,'#EF4444',46,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(54,'Smooth Jazz','smooth-jazz',NULL,'#EF4444',46,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(55,'Acid Jazz','acid-jazz',NULL,'#EF4444',46,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(56,'Nu Jazz','nu-jazz',NULL,'#EF4444',46,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(57,'Jazz Manouche','jazz-manouche',NULL,'#EF4444',46,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(58,'Latin Jazz','latin-jazz',NULL,'#EF4444',46,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(59,'Bossa Nova','bossa-nova',NULL,'#F87171',58,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(60,'Afro-Cuban','afro-cuban',NULL,'#F87171',58,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(61,'Modal Jazz','modal-jazz',NULL,'#EF4444',46,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(62,'Post-Bop','post-bop',NULL,'#EF4444',46,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(63,'Jazz Funk','jazz-funk',NULL,'#EF4444',46,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(64,'Spiritual Jazz','spiritual-jazz',NULL,'#EF4444',46,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(65,'European Jazz','european-jazz',NULL,'#EF4444',46,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(66,'Contemporary Jazz','contemporary-jazz',NULL,'#EF4444',46,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(67,'Blues et Dérivés','blues-et-derives',NULL,'#7C3AED',NULL,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(68,'Delta Blues','delta-blues',NULL,'#A855F7',67,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(69,'Chicago Blues','chicago-blues',NULL,'#A855F7',67,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(70,'Electric Blues','electric-blues',NULL,'#A855F7',67,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(71,'Acoustic Blues','acoustic-blues',NULL,'#A855F7',67,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(72,'Piedmont Blues','piedmont-blues',NULL,'#A855F7',67,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(73,'Texas Blues','texas-blues',NULL,'#A855F7',67,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(74,'West Coast Blues','west-coast-blues',NULL,'#A855F7',67,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(75,'British Blues','british-blues',NULL,'#A855F7',67,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(76,'Blues Rock','blues-rock',NULL,'#A855F7',67,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(77,'Rhythm and Blues (R&B)','rhythm-and-blues-rb',NULL,'#A855F7',67,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(78,'Jump Blues','jump-blues',NULL,'#A855F7',67,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(79,'Boogie Woogie','boogie-woogie',NULL,'#A855F7',67,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(80,'Rock et Metal','rock-et-metal',NULL,'#B91C1C',NULL,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(81,'Rock \'n\' Roll','rock-n-roll',NULL,'#DC2626',80,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(82,'Rockabilly','rockabilly',NULL,'#DC2626',80,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(83,'Surf Rock','surf-rock',NULL,'#DC2626',80,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(84,'Garage Rock','garage-rock',NULL,'#DC2626',80,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(85,'Psychedelic Rock','psychedelic-rock',NULL,'#DC2626',80,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(86,'Progressive Rock','progressive-rock',NULL,'#DC2626',80,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(87,'Art Rock','art-rock',NULL,'#DC2626',80,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(88,'Glam Rock','glam-rock',NULL,'#DC2626',80,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(89,'Hard Rock','hard-rock',NULL,'#DC2626',80,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(90,'Arena Rock','arena-rock',NULL,'#DC2626',80,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(91,'Southern Rock','southern-rock',NULL,'#DC2626',80,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(92,'Heartland Rock','heartland-rock',NULL,'#DC2626',80,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(93,'Indie Rock','indie-rock',NULL,'#DC2626',80,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(94,'Alternative Rock','alternative-rock',NULL,'#DC2626',80,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(95,'Grunge','grunge',NULL,'#DC2626',80,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(96,'Britpop','britpop',NULL,'#DC2626',80,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(97,'Post-Rock','post-rock',NULL,'#DC2626',80,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(98,'Math Rock','math-rock',NULL,'#DC2626',80,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(99,'Noise Rock','noise-rock',NULL,'#DC2626',80,18,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(100,'Shoegaze','shoegaze',NULL,'#DC2626',80,19,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(101,'Dream Pop','dream-pop',NULL,'#DC2626',80,20,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(102,'Heavy Metal','heavy-metal',NULL,'#991B1B',80,21,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(103,'Thrash Metal','thrash-metal',NULL,'#991B1B',80,22,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(104,'Death Metal','death-metal',NULL,'#991B1B',80,23,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(105,'Black Metal','black-metal',NULL,'#991B1B',80,24,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(106,'Power Metal','power-metal',NULL,'#991B1B',80,25,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(107,'Progressive Metal','progressive-metal',NULL,'#991B1B',80,26,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(108,'Doom Metal','doom-metal',NULL,'#991B1B',80,27,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(109,'Sludge Metal','sludge-metal',NULL,'#991B1B',80,28,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(110,'Stoner Rock/Metal','stoner-rockmetal',NULL,'#991B1B',80,29,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(111,'Nu Metal','nu-metal',NULL,'#991B1B',80,30,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(112,'Metalcore','metalcore',NULL,'#991B1B',80,31,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(113,'Deathcore','deathcore',NULL,'#991B1B',80,32,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(114,'Symphonic Metal','symphonic-metal',NULL,'#991B1B',80,33,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(115,'Folk Metal','folk-metal',NULL,'#991B1B',80,34,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(116,'Viking Metal','viking-metal',NULL,'#991B1B',80,35,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(117,'Industrial Metal','industrial-metal',NULL,'#991B1B',80,36,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(118,'Gothic Metal','gothic-metal',NULL,'#991B1B',80,37,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(119,'Atmospheric Metal','atmospheric-metal',NULL,'#991B1B',80,38,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(120,'Post-Metal','post-metal',NULL,'#991B1B',80,39,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(121,'Musiques Électroniques','musiques-electroniques',NULL,'#059669',NULL,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(122,'Disco','disco',NULL,'#10B981',121,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(123,'House','house',NULL,'#10B981',121,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(124,'Deep House','deep-house',NULL,'#34D399',123,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(125,'Tech House','tech-house',NULL,'#34D399',123,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(126,'Progressive House','progressive-house',NULL,'#34D399',123,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(127,'Electro House','electro-house',NULL,'#34D399',123,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(128,'Techno','techno',NULL,'#10B981',121,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(129,'Detroit Techno','detroit-techno',NULL,'#34D399',128,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(130,'Minimal Techno','minimal-techno',NULL,'#34D399',128,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(131,'Hard Techno','hard-techno',NULL,'#34D399',128,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(132,'Trance','trance',NULL,'#10B981',121,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(133,'Uplifting Trance','uplifting-trance',NULL,'#34D399',132,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(134,'Progressive Trance','progressive-trance',NULL,'#34D399',132,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(135,'Psytrance','psytrance',NULL,'#34D399',132,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(136,'Drum and Bass','drum-and-bass',NULL,'#10B981',121,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(137,'Jungle','jungle',NULL,'#34D399',136,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(138,'Liquid DnB','liquid-dnb',NULL,'#34D399',136,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(139,'Neurofunk','neurofunk',NULL,'#34D399',136,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(140,'Dubstep','dubstep',NULL,'#10B981',121,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(141,'UK Garage','uk-garage',NULL,'#10B981',121,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(142,'Breakbeat','breakbeat',NULL,'#10B981',121,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(143,'Big Beat','big-beat',NULL,'#10B981',121,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(144,'Hardcore','hardcore',NULL,'#10B981',121,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(145,'Gabber','gabber',NULL,'#34D399',144,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(146,'Happy Hardcore','happy-hardcore',NULL,'#34D399',144,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(147,'Hardstyle','hardstyle',NULL,'#10B981',121,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(148,'EDM (Electronic Dance Music)','edm-electronic-dance-music',NULL,'#10B981',121,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(149,'Ambient','ambient',NULL,'#10B981',121,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(150,'IDM (Intelligent Dance Music)','idm-intelligent-dance-music',NULL,'#10B981',121,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(151,'Glitch','glitch',NULL,'#10B981',121,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(152,'Minimal','minimal',NULL,'#10B981',121,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(153,'Drone','drone',NULL,'#10B981',121,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(154,'Dark Ambient','dark-ambient',NULL,'#10B981',121,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(155,'Musique Concrète','musique-concrete',NULL,'#10B981',121,18,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(156,'Électroacoustique','electroacoustique-1',NULL,'#10B981',121,19,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(157,'Noise','noise',NULL,'#10B981',121,20,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(158,'Industrial','industrial',NULL,'#10B981',121,21,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(159,'EBM (Electronic Body Music)','ebm-electronic-body-music',NULL,'#10B981',121,22,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(160,'Synthwave/Retrowave','synthwaveretrowave',NULL,'#10B981',121,23,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(161,'Vaporwave','vaporwave',NULL,'#10B981',121,24,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(162,'Chillwave','chillwave',NULL,'#10B981',121,25,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(163,'Pop et Musiques Populaires','pop-et-musiques-populaires',NULL,'#EC4899',NULL,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(164,'Pop Rock','pop-rock',NULL,'#F472B6',163,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(165,'Teen Pop','teen-pop',NULL,'#F472B6',163,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(166,'Dance Pop','dance-pop',NULL,'#F472B6',163,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(167,'Electropop','electropop',NULL,'#F472B6',163,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(168,'Synthpop','synthpop',NULL,'#F472B6',163,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(169,'New Wave','new-wave',NULL,'#F472B6',163,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(170,'Post-Punk','post-punk',NULL,'#F472B6',163,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(171,'Indie Pop','indie-pop',NULL,'#F472B6',163,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(172,'Dream Pop','dream-pop-1',NULL,'#F472B6',163,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(173,'Chamber Pop','chamber-pop',NULL,'#F472B6',163,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(174,'Art Pop','art-pop',NULL,'#F472B6',163,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(175,'Experimental Pop','experimental-pop',NULL,'#F472B6',163,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(176,'K-Pop','k-pop',NULL,'#F472B6',163,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(177,'J-Pop','j-pop',NULL,'#F472B6',163,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(178,'Europop','europop',NULL,'#F472B6',163,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(179,'Latin Pop','latin-pop',NULL,'#F472B6',163,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(180,'Hip-Hop et Rap','hip-hop-et-rap',NULL,'#F59E0B',NULL,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(181,'Old School Hip-Hop','old-school-hip-hop',NULL,'#FBBF24',180,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(182,'Boom Bap','boom-bap',NULL,'#FBBF24',180,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(183,'East Coast Hip-Hop','east-coast-hip-hop',NULL,'#FBBF24',180,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(184,'West Coast Hip-Hop','west-coast-hip-hop',NULL,'#FBBF24',180,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(185,'Southern Hip-Hop (Dirty South)','southern-hip-hop-dirty-south',NULL,'#FBBF24',180,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(186,'Gangsta Rap','gangsta-rap',NULL,'#FBBF24',180,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(187,'Conscious Rap','conscious-rap',NULL,'#FBBF24',180,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(188,'Alternative Hip-Hop','alternative-hip-hop',NULL,'#FBBF24',180,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(189,'Jazz Rap','jazz-rap',NULL,'#FBBF24',180,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(190,'Trap','trap',NULL,'#FBBF24',180,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(191,'Mumble Rap','mumble-rap',NULL,'#FBBF24',180,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(192,'Cloud Rap','cloud-rap',NULL,'#FBBF24',180,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(193,'Drill','drill',NULL,'#FBBF24',180,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(194,'Grime','grime',NULL,'#FBBF24',180,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(195,'UK Hip-Hop','uk-hip-hop',NULL,'#FBBF24',180,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(196,'French Rap','french-rap',NULL,'#FBBF24',180,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(197,'Horrorcore','horrorcore',NULL,'#FBBF24',180,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(198,'Christian Hip-Hop','christian-hip-hop',NULL,'#FBBF24',180,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(199,'Musiques du Monde','musiques-du-monde',NULL,'#16A34A',NULL,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(200,'Afrobeat','afrobeat',NULL,'#22C55E',199,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(201,'Highlife','highlife',NULL,'#22C55E',199,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(202,'Soukous','soukous',NULL,'#22C55E',199,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(203,'Mbalax','mbalax',NULL,'#22C55E',199,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(204,'Rai','rai',NULL,'#22C55E',199,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(205,'Gnawa','gnawa',NULL,'#22C55E',199,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(206,'Makossa','makossa',NULL,'#22C55E',199,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(207,'Kizomba','kizomba',NULL,'#22C55E',199,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(208,'Amapiano','amapiano',NULL,'#22C55E',199,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(209,'Bongo Flava','bongo-flava',NULL,'#22C55E',199,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(210,'Salsa','salsa',NULL,'#22C55E',199,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(211,'Merengue','merengue',NULL,'#22C55E',199,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(212,'Bachata','bachata',NULL,'#22C55E',199,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(213,'Reggaeton','reggaeton',NULL,'#22C55E',199,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(214,'Cumbia','cumbia',NULL,'#22C55E',199,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(215,'Vallenato','vallenato',NULL,'#22C55E',199,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(216,'Tango','tango',NULL,'#22C55E',199,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(217,'Bossa Nova','bossa-nova-1',NULL,'#22C55E',199,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(218,'Samba','samba',NULL,'#22C55E',199,18,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(219,'Forró','forro',NULL,'#22C55E',199,19,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(220,'Mariachi','mariachi',NULL,'#22C55E',199,20,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(221,'Ranchera','ranchera',NULL,'#22C55E',199,21,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(222,'Nueva Canción','nueva-cancion',NULL,'#22C55E',199,22,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(223,'Reggae','reggae',NULL,'#22C55E',199,23,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(224,'Dancehall','dancehall',NULL,'#22C55E',199,24,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(225,'Ska','ska',NULL,'#22C55E',199,25,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(226,'Rocksteady','rocksteady',NULL,'#22C55E',199,26,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(227,'Dub','dub',NULL,'#22C55E',199,27,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(228,'Soca','soca',NULL,'#22C55E',199,28,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(229,'Calypso','calypso',NULL,'#22C55E',199,29,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(230,'Zouk','zouk',NULL,'#22C55E',199,30,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(231,'Kompas','kompas',NULL,'#22C55E',199,31,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(232,'Raga (Musique classique indienne)','raga-musique-classique-indienne',NULL,'#22C55E',199,32,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(233,'Qawwali','qawwali',NULL,'#22C55E',199,33,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(234,'Bollywood','bollywood',NULL,'#22C55E',199,34,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(235,'Gamelan','gamelan',NULL,'#22C55E',199,35,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(236,'Taiko','taiko',NULL,'#22C55E',199,36,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(237,'Gagaku','gagaku',NULL,'#22C55E',199,37,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(238,'Pansori','pansori',NULL,'#22C55E',199,38,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(239,'Chinese Opera','chinese-opera',NULL,'#22C55E',199,39,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(240,'Flamenco','flamenco',NULL,'#22C55E',199,40,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(241,'Fado','fado',NULL,'#22C55E',199,41,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(242,'Celtic','celtic',NULL,'#22C55E',199,42,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(243,'Irish Folk','irish-folk',NULL,'#4ADE80',242,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(244,'Scottish Folk','scottish-folk',NULL,'#4ADE80',242,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(245,'Klezmer','klezmer',NULL,'#22C55E',199,43,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(246,'Chanson Française','chanson-francaise',NULL,'#22C55E',199,44,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(247,'Schlager','schlager',NULL,'#22C55E',199,45,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(248,'Volksmuziek','volksmuziek',NULL,'#22C55E',199,46,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(249,'Rebetiko','rebetiko',NULL,'#22C55E',199,47,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(250,'Country et Folk','country-et-folk',NULL,'#D97706',NULL,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(251,'Bluegrass','bluegrass',NULL,'#F59E0B',250,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(252,'Honky Tonk','honky-tonk',NULL,'#F59E0B',250,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(253,'Outlaw Country','outlaw-country',NULL,'#F59E0B',250,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(254,'Nashville Sound','nashville-sound',NULL,'#F59E0B',250,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(255,'Country Rock','country-rock',NULL,'#F59E0B',250,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(256,'Alt-Country','alt-country',NULL,'#F59E0B',250,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(257,'Americana','americana',NULL,'#F59E0B',250,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(258,'Western Swing','western-swing',NULL,'#F59E0B',250,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(259,'Country Pop','country-pop',NULL,'#F59E0B',250,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(260,'Traditional Folk','traditional-folk',NULL,'#F59E0B',250,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(261,'Contemporary Folk','contemporary-folk',NULL,'#F59E0B',250,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(262,'Folk Rock','folk-rock',NULL,'#F59E0B',250,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(263,'Folk Revival','folk-revival',NULL,'#F59E0B',250,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(264,'Protest Songs','protest-songs',NULL,'#F59E0B',250,13,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(265,'Singer-Songwriter','singer-songwriter',NULL,'#F59E0B',250,14,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(266,'Anti-Folk','anti-folk',NULL,'#F59E0B',250,15,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(267,'Freak Folk','freak-folk',NULL,'#F59E0B',250,16,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(268,'New Weird America','new-weird-america',NULL,'#F59E0B',250,17,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(269,'Musique Religieuse et Spirituelle','musique-religieuse-et-spirituelle',NULL,'#7C2D12',NULL,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(270,'Gospel','gospel',NULL,'#A16207',269,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(271,'Contemporary Christian','contemporary-christian',NULL,'#A16207',269,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(272,'Christian Rock','christian-rock',NULL,'#A16207',269,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(273,'Christian Metal','christian-metal',NULL,'#A16207',269,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(274,'Spiritual','spiritual',NULL,'#A16207',269,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(275,'Negro Spiritual','negro-spiritual',NULL,'#A16207',269,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(276,'Hymnes','hymnes',NULL,'#A16207',269,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(277,'Musique Soufie','musique-soufie',NULL,'#A16207',269,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(278,'Chants Bouddhistes','chants-bouddhistes',NULL,'#A16207',269,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(279,'Kirtan','kirtan',NULL,'#A16207',269,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(280,'Musique Sacrée Juive','musique-sacree-juive',NULL,'#A16207',269,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(281,'Chants Grégoriens','chants-gregoriens',NULL,'#A16207',269,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(282,'Musiques Expérimentales et Avant-Garde','musiques-experimentales-et-avant-garde',NULL,'#6B7280',NULL,10,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(283,'Musique Bruitiste','musique-bruitiste',NULL,'#9CA3AF',282,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(284,'Minimalisme','minimalisme',NULL,'#9CA3AF',282,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(285,'Musique Répétitive','musique-repetitive',NULL,'#9CA3AF',282,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(286,'Drone Music','drone-music',NULL,'#9CA3AF',282,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(287,'Field Recording','field-recording',NULL,'#9CA3AF',282,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(288,'Sound Art','sound-art',NULL,'#9CA3AF',282,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(289,'Plunderphonics','plunderphonics',NULL,'#9CA3AF',282,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(290,'Lowercase','lowercase',NULL,'#9CA3AF',282,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(291,'Microsound','microsound',NULL,'#9CA3AF',282,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(292,'Acousmatic Music','acousmatic-music',NULL,'#9CA3AF',282,9,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(293,'Musiques de Films et Médias','musiques-de-films-et-medias',NULL,'#1F2937',NULL,11,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(294,'Musique de Film','musique-de-film',NULL,'#4B5563',293,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(295,'Musique de Jeux Vidéo','musique-de-jeux-video',NULL,'#4B5563',293,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(296,'Musique de Télévision','musique-de-television',NULL,'#4B5563',293,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(297,'Library Music','library-music',NULL,'#4B5563',293,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(298,'Easy Listening','easy-listening',NULL,'#4B5563',293,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(299,'Lounge','lounge',NULL,'#4B5563',293,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(300,'Elevator Music','elevator-music',NULL,'#4B5563',293,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(301,'New Age','new-age',NULL,'#4B5563',293,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(302,'Fusion et Hybrides','fusion-et-hybrides',NULL,'#8B5CF6',NULL,12,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(303,'Jazz Fusion','jazz-fusion',NULL,'#A855F7',302,0,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(304,'Rock Fusion','rock-fusion',NULL,'#A855F7',302,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(305,'World Fusion','world-fusion',NULL,'#A855F7',302,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(306,'Electro-Acoustic','electro-acoustic',NULL,'#A855F7',302,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(307,'Nu-Disco','nu-disco',NULL,'#A855F7',302,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(308,'Folktronica','folktronica',NULL,'#A855F7',302,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(309,'Post-Genre','post-genre',NULL,'#A855F7',302,6,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(310,'Crossover','crossover',NULL,'#A855F7',302,7,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(311,'Third Stream','third-stream',NULL,'#A855F7',302,8,1,'2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `music_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musics`
--

DROP TABLE IF EXISTS `musics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `musics` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_ai_generated` tinyint(1) NOT NULL DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `status` enum('pending','approved','rejected','deleted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `musics_slug_unique` (`slug`),
  KEY `musics_user_id_foreign` (`user_id`),
  KEY `musics_category_id_foreign` (`category_id`),
  CONSTRAINT `musics_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `musics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musics`
--

LOCK TABLES `musics` WRITE;
/*!40000 ALTER TABLE `musics` DISABLE KEYS */;
INSERT INTO `musics` VALUES (1,'Dangerous Woman','dangerous-woman','Une chanson pop énergique avec des influences rock',0,'/music/dangerous-woman.mp3','storage/uploads/covers/1756254950_68ae52e642e80.jpg',NULL,180,15400,1,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,'Neon Dreams','neon-dreams','Synthwave électronique avec des mélodies nostalgiques',0,'/music/neon-dreams.mp3','storage/uploads/covers/1756254579_68ae51731218c.jpg',NULL,240,8900,2,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,'Midnight Jazz','midnight-jazz','Jazz nocturne avec saxophone et piano',0,'/music/midnight-jazz.mp3','storage/uploads/covers/1756253663_68ae4ddf31fb7.jpg',NULL,320,6700,3,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,'Digital Love','digital-love','Chanson électronique avec vocoder',0,'/music/digital-love.mp3','storage/uploads/covers/1756252894_68ae4adecd98f.jpg',NULL,200,12301,4,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:29:34'),(5,'Ocean Waves','ocean-waves','Musique ambiante relaxante avec sons d\'océan',0,'/music/ocean-waves.mp3','storage/uploads/covers/1756252131_68ae47e3787a4.jpg',NULL,480,4500,5,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(6,'Rock Anthem','rock-anthem','Rock classique avec guitares puissantes',0,'/music/rock-anthem.mp3','storage/uploads/covers/1756254950_68ae52e642e80.jpg',NULL,280,9800,6,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(7,'Classical Symphony','classical-symphony','Symphonie classique orchestrale',0,'/music/classical-symphony.mp3','storage/uploads/covers/1756254579_68ae51731218c.jpg',NULL,600,3200,7,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(8,'Hip Hop Beat','hip-hop-beat','Beat hip-hop avec flow rap',0,'/music/hip-hop-beat.mp3','storage/uploads/covers/1756253663_68ae4ddf31fb7.jpg',NULL,220,7600,1,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(9,'Folk Story','folk-story','Chanson folk acoustique avec guitare',0,'/music/folk-story.mp3','storage/uploads/covers/1756252894_68ae4adecd98f.jpg',NULL,260,5400,2,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39'),(10,'Pop Sensation','pop-sensation','Hit pop avec mélodie accrocheuse',0,'/music/pop-sensation.mp3','storage/uploads/covers/1756252131_68ae47e3787a4.jpg',NULL,190,11200,3,NULL,1,1,'pending','2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `musics` ENABLE KEYS */;
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist_music`
--

DROP TABLE IF EXISTS `playlist_music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playlist_music` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `playlist_id` bigint unsigned NOT NULL,
  `music_id` bigint unsigned NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `playlist_music_playlist_id_music_id_unique` (`playlist_id`,`music_id`),
  KEY `playlist_music_music_id_foreign` (`music_id`),
  CONSTRAINT `playlist_music_music_id_foreign` FOREIGN KEY (`music_id`) REFERENCES `musics` (`id`) ON DELETE CASCADE,
  CONSTRAINT `playlist_music_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_music`
--

LOCK TABLES `playlist_music` WRITE;
/*!40000 ALTER TABLE `playlist_music` DISABLE KEYS */;
INSERT INTO `playlist_music` VALUES (1,1,1,1,NULL,NULL),(2,1,3,2,NULL,NULL),(3,1,5,3,NULL,NULL),(4,2,3,1,NULL,NULL),(5,2,7,2,NULL,NULL),(6,2,9,3,NULL,NULL),(7,3,6,1,NULL,NULL),(8,3,8,2,NULL,NULL),(9,3,10,3,NULL,NULL),(10,4,1,1,NULL,NULL),(11,4,2,2,NULL,NULL),(12,4,10,3,NULL,NULL),(13,5,5,1,NULL,NULL),(14,5,7,2,NULL,NULL),(15,5,9,3,NULL,NULL);
/*!40000 ALTER TABLE `playlist_music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `playlists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `playlists_user_id_foreign` (`user_id`),
  KEY `playlists_slug_index` (`slug`),
  CONSTRAINT `playlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlists`
--

LOCK TABLES `playlists` WRITE;
/*!40000 ALTER TABLE `playlists` DISABLE KEYS */;
INSERT INTO `playlists` VALUES (1,'Mes Favoris',NULL,'Ma playlist personnelle',NULL,1,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,'Jazz & Blues',NULL,'Collection jazz et blues',NULL,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,'Rock Classics',NULL,'Les meilleurs du rock',NULL,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,'Pop Hits',NULL,'Les hits pop du moment',NULL,4,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(5,'Ambient Vibes',NULL,'Musique ambiante relaxante',NULL,5,1,'2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `playlists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comments_user_id_foreign` (`user_id`),
  KEY `post_comments_post_id_foreign` (`post_id`),
  CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_comments`
--

LOCK TABLES `post_comments` WRITE;
/*!40000 ALTER TABLE `post_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_comments` ENABLE KEYS */;
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
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reporter_id` bigint unsigned NOT NULL,
  `reportable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportable_id` bigint unsigned NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','resolved','dismissed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `resolved_by` bigint unsigned DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_reporter_id_foreign` (`reporter_id`),
  KEY `reports_reportable_type_reportable_id_index` (`reportable_type`,`reportable_id`),
  KEY `reports_resolved_by_foreign` (`resolved_by`),
  CONSTRAINT `reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('BLF9xgO3zsbWdHNrOV6nXlzoU7oOvPXFjuJTlDE4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:142.0) Gecko/20100101 Firefox/142.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWFRzVndzZEMzSVRFWlZRTk9nblROT2xTUkNMZXR5VEttUlVKSFpiTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9qYWFqZm0udGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1756618769),('H71zeE6fFZxZN5MpQL02Auv486b4TPhaZ46rvy2F',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUJFdlZGM1pIcEg1TTIwcHBBNmg4YmdzSmNnZGtpWTh5ZlZuenZ0SSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9qYWFqZm0udGVzdCI7fX0=',1756620048),('N7tTtk8lR0zZut7QICIsA5amc4KttKKZRMx18Hat',7,'127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXJoWTd0VWhsOFFqSW1pSXJEeXFxbkhOalpNQlF2bEJZTm5HZjRITyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9qYWFqZm0udGVzdC9hcGkvZ2VucmVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9',1756618917);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_follows`
--

DROP TABLE IF EXISTS `user_follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_follows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `following_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_follows_follower_id_following_id_unique` (`follower_id`,`following_id`),
  KEY `user_follows_following_id_foreign` (`following_id`),
  CONSTRAINT `user_follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_follows`
--

LOCK TABLES `user_follows` WRITE;
/*!40000 ALTER TABLE `user_follows` DISABLE KEYS */;
INSERT INTO `user_follows` VALUES (1,1,2,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(2,1,3,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(3,2,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(4,2,4,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(5,3,1,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(6,3,5,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(7,4,2,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(8,4,5,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(9,5,3,'2025-08-31 03:17:39','2025-08-31 03:17:39'),(10,5,4,'2025-08-31 03:17:39','2025-08-31 03:17:39');
/*!40000 ALTER TABLE `user_follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_preferences`
--

DROP TABLE IF EXISTS `user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_preferences_user_id_key_unique` (`user_id`,`key`),
  KEY `user_preferences_user_id_index` (`user_id`),
  CONSTRAINT `user_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_preferences`
--

LOCK TABLES `user_preferences` WRITE;
/*!40000 ALTER TABLE `user_preferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_preferences` ENABLE KEYS */;
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
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com',0,'2025-08-31 03:17:37','$2y$12$ed5o3WVkA2vD0Ko40DIbXehDg9JCHlVYoKl6x8iZ0UIwu24uR93ym',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:37','2025-08-31 03:17:37'),(2,'Alex Music','alex@jaajfm.com',0,'2025-08-31 03:17:38','$2y$12$I4VC0GfxPiGZOXpF93Rf9ux018zhpZRcDbeFABVm0QmSw45PBv2PS',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:38','2025-08-31 03:17:38'),(3,'Sarah Jazz','sarah@jaajfm.com',0,'2025-08-31 03:17:38','$2y$12$RStSH3i5CDRKlLkXiZ3dHOOEd8Y0gN0T7bsBh0FyBTnlYXJjZzAjK',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:38','2025-08-31 03:17:38'),(4,'Mike Rock','mike@jaajfm.com',0,'2025-08-31 03:17:38','$2y$12$9IRcfjCuwN4Fx2Vw5YctSu8wIK4xkW8.q50LC3.Xm8pArD9Ch9Gym',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:38','2025-08-31 03:17:38'),(5,'Emma Pop','emma@jaajfm.com',0,'2025-08-31 03:17:38','$2y$12$5vpZGD.0HGmZ5eqEpQHydOAc2o94C4VIdWUpMyGsym8luHbZ274p.',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:38','2025-08-31 03:17:38'),(6,'David Ambient','david@jaajfm.com',0,'2025-08-31 03:17:38','$2y$12$I01nHQzL9wV6W2HIaNm6M.mC.xzPjEIbE6DlcSp7TQLA9w3ge6pRO',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:38','2025-08-31 03:17:38'),(7,'Admin JaaJ FM','admin@jaajfm.com',1,'2025-08-31 03:17:39','$2y$12$BxX4sp9cx5W7iKgTvQciSuWXn.KZ6p5XPGJ0V0TfXDJfegYsjTJDa',NULL,NULL,NULL,NULL,NULL,NULL,'2025-08-31 03:17:39','2025-08-31 03:17:39');
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

-- Dump completed on 2025-08-31  8:39:01
