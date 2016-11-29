-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: twitter
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tweet_id` int(10) unsigned NOT NULL,
  `comment_text` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tweet_id` (`tweet_id`),
  KEY `Comment_ibfk_1` (`user_id`),
  CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`tweet_id`) REFERENCES `Tweet` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comment`
--

LOCK TABLES `Comment` WRITE;
/*!40000 ALTER TABLE `Comment` DISABLE KEYS */;
INSERT INTO `Comment` VALUES (1,26,7,'ale głupoty','2016-11-27 17:07:08'),(4,9,7,'też tak myślę','2016-11-27 17:23:04'),(5,26,19,'vzcnnnv','2016-11-27 20:16:13'),(6,26,19,'asgshad','2016-11-27 20:18:19'),(7,26,19,'ffhsjyrazfhfjashf sdhs','2016-11-27 20:21:13'),(8,26,19,'Pierwszy dobry komentarz','2016-11-27 20:26:15'),(9,26,19,'Właśnie się nad tym zastanawiałem','2016-11-27 20:30:49'),(10,26,19,'Nie wiem tego','2016-11-27 20:32:56'),(11,26,19,'jutro będzie gorzej','2016-11-27 20:34:39'),(12,26,9,'jutro będzie lepiej','2016-11-27 20:36:17'),(13,26,9,'nareszcie dobrze działa','2016-11-27 20:36:35'),(14,26,17,'Też nie wiem','2016-11-27 20:37:22'),(15,26,18,'Też już kończę','2016-11-27 20:38:03'),(21,31,28,'Jan komentuje swój pierwszy tweet','2016-11-29 09:29:09'),(22,32,28,'al komentuje tweet jana','2016-11-29 09:32:46'),(25,31,28,'fjdsjgjsh','2016-11-29 09:56:34');
/*!40000 ALTER TABLE `Comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Message`
--

DROP TABLE IF EXISTS `Message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `recipient_id` int(10) unsigned NOT NULL,
  `message_text` text CHARACTER SET utf8 COLLATE utf8_roman_ci,
  `status` tinyint(1) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `Message_ibfk_1` (`sender_id`),
  CONSTRAINT `Message_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `Message_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Message`
--

LOCK TABLES `Message` WRITE;
/*!40000 ALTER TABLE `Message` DISABLE KEYS */;
INSERT INTO `Message` VALUES (1,1,26,'nie wystarczy',0,'2016-11-28 09:42:29'),(2,1,26,'nie wystarczy już dość',1,'2016-11-28 09:43:15'),(3,1,26,'hello',1,'2016-11-28 10:00:21'),(4,26,1,'hello to you',0,'2016-11-28 10:18:01'),(8,32,31,'Wiadomość od ala do Jana',1,'2016-11-29 09:33:07'),(9,32,2,'wiadomość do lolka',0,'2016-11-29 09:33:31'),(10,32,31,'Janek spróbuj przeczytać wiadomość ode mnie Pozdrawiam',1,'2016-11-29 09:34:16'),(11,31,32,'al przeczytałem wiadomość od Ciebie Pozdrawiam',0,'2016-11-29 09:36:57');
/*!40000 ALTER TABLE `Message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tweet`
--

DROP TABLE IF EXISTS `Tweet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tweet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tweet_text` varchar(140) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Tweet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tweet`
--

LOCK TABLES `Tweet` WRITE;
/*!40000 ALTER TABLE `Tweet` DISABLE KEYS */;
INSERT INTO `Tweet` VALUES (4,1,'Wieczór też ładny','2016-11-21 21:43:16'),(5,1,'test polskich znaków ĄĆŚŹŻżęółŁ','2016-11-21 21:45:12'),(6,1,'test polskich znaków ĄĆŚŹŻżęółŁ','2016-11-21 22:30:23'),(7,1,'Dobranoc na dziś wystarczy ciekawe kiedy przekroczę 140 znaków','2016-11-21 22:32:12'),(8,1,'Czas na pierwszy dziś tweet z polskimi znakami ąćźżłó','2016-11-22 08:21:00'),(9,26,'Ale dziś piękna pogoda','2016-11-26 10:55:22'),(15,2,'To pierwszy tweet wysłany przez stronę index.php','2016-11-26 15:05:20'),(16,2,'Czy to TWEET lubisz?','2016-11-26 15:06:31'),(17,2,'Co ta Pola wygaduje?','2016-11-26 15:49:07'),(18,2,'Chyba już czas kończyć pracę na dziś','2016-11-26 16:10:05'),(19,2,'Pierwszy niedzielny tweet','2016-11-27 19:25:33'),(28,31,'Pierwszy tweet Jana ','2016-11-29 09:28:47'),(29,32,'Pierwszy tweet ala','2016-11-29 09:32:29');
/*!40000 ALTER TABLE `Tweet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `hashed_password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'bolek@wp.pl','bolek','$2y$10$usW432giLvIbkK/Nlw/LX.SgeXAs2YlMiqziwvbIQ1oMYW2nihOJS'),(2,'lolek@wp.pl','lolek','$2y$10$U5SFbJ7b/shFsUoWG5vuYucBzKTHiRVdoXme6AAbq5zcbH/Xm1K.2'),(9,'tosia@wp.pl','tosia','$2y$10$Ux.21/f02VBJNv1XEsKeWeiByntg23naaOpNXEJ1WHyJQ7aNVK1wO'),(26,'reksio@wp.pl','reksio','$2y$10$L8s5SknNkbDRpSEHw1ir6.dwlzKNb5l.hmrTbRqgPGIp04mCgXUje'),(31,'jan@wp.pl','jan','$2y$10$4npIGWd0qyzwVk69WM.6m.noja/V/68UzKzLQ9xmunnnMLM195GmK'),(32,'obla@wp.pl','al','$2y$10$BdcpePuMTmfH/wCzJSmTKOGk4niwES26g1fKrO3lUCZE4FXVk9AEe');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-29 10:01:08
