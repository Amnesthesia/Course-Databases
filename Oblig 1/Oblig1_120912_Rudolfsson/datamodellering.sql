-- MySQL dump 10.13  Distrib 5.5.30, for Linux (x86_64)
--
-- Host: localhost    Database: oblig
-- ------------------------------------------------------
-- Server version	5.5.32-MariaDB-log

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
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'First entry','Lorem ipsum dolor sit amet, et connectetur etc','2013-09-03 21:34:42',1),(2,1,'new entry','waqeqwe','2013-09-05 20:32:34',0),(3,1,'Changed entry','Now with actual content!','2013-09-05 22:58:11',0),(4,1,'Changed entry','<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans; font-weight: normal;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer a nisl non purus sagittis dapibus. Suspendisse posuere lacus congue, ornare orci quis, bibendum velit. Suspendisse tristique euismod nunc, non ultricies nisl interdum ac. Phasellus quis sagittis erat, fringilla dictum enim. Vestibulum quis fermentum ligula. Suspendisse sagittis augue libero, eget laoreet enim elementum vitae. In sagittis magna semper mi eleifend congue.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans; font-weight: normal;\">Quisque sed turpis ac ante molestie congue vel in dui. Etiam eget mi nisi. Integer ut nibh in nulla eleifend dictum. Maecenas at erat quis arcu facilisis blandit. Nunc quis eros vulputate, lacinia quam eget, venenatis mi. Nulla facilisi. Vivamus viverra, justo id molestie facilisis, sapien elit dictum dolor, nec mollis nisi massa vel sem. Sed sagittis, turpis lobortis fermentum luctus, nunc ipsum scelerisque mauris, vel feugiat eros nibh et massa. Donec felis ante, consequat in euismod quis, fermentum sed lectus. Praesent accumsan lacus quis augue mattis dignissim. Proin ac urna nec nisi condimentum semper at ac nunc.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans; font-weight: normal;\">Praesent nulla orci, condimentum vel velit quis, scelerisque vestibulum orci. Maecenas justo lacus, porttitor non turpis at, adipiscing dapibus elit. Maecenas adipiscing dignissim dolor ac volutpat. Morbi ut ultricies risus, rhoncus aliquam nunc. Maecenas in elementum mi. Etiam nisl libero, interdum vitae magna non, sodales elementum ante. Morbi malesuada lacus vel nisl bibendum, sed porta magna consectetur. Nulla facilisi. Proin in pharetra diam. Vivamus facilisis interdum nisl nec posuere. Nullam enim odio, vestibulum eget commodo vulputate, dignissim id nibh. Mauris tortor augue, tempor eu ligula eget, volutpat vehicula sem. Curabitur eleifend hendrerit auctor. Nam vitae porta augue. Fusce tristique augue vel velit suscipit suscipit.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans; font-weight: normal;\">Maecenas elementum purus nec mi consectetur elementum. Integer tempor luctus nunc, tincidunt posuere odio lobortis vel. Nam rhoncus ligula sed turpis ullamcorper tempus. Sed sollicitudin, augue eu dapibus sollicitudin, lacus massa molestie tellus, a iaculis eros odio a massa. Nulla egestas, ante at blandit sagittis, orci lorem pellentesque nibh, ac feugiat dolor nisi quis urna. Vestibulum mollis urna ut scelerisque consectetur. Donec fermentum eget magna sed tincidunt. Nunc at metus arcu. Nulla rhoncus enim non diam sodales consectetur. Nunc quis est ut velit luctus porta non nec nisl. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc euismod metus vitae sodales egestas. Donec tristique, neque ac imperdiet pulvinar, nibh turpis rutrum odio, bibendum dignissim justo purus eget purus.</p>\r\n<p style=\"text-align: justify; line-height: 14px; margin: 0px 0px 14px; padding: 0px; font-family: Arial, Helvetica, sans; font-weight: normal;\">Proin mollis accumsan volutpat. Ut ante arcu, blandit eget auctor vel, sollicitudin ac lorem. Morbi aliquet tempus urna, vel malesuada lorem tempor eu. Phasellus venenatis dictum massa, a facilisis odio suscipit ac. Phasellus eget fermentum quam. Nullam elementum congue blandit. Nulla hendrerit eleifend placerat. Nulla facilisi. Proin quam odio, laoreet et turpis et, pharetra rhoncus nunc. Sed semper libero id dolor varius elementum. Nam eu pellentesque tortor. Morbi faucibus odio in tincidunt consectetur. Proin aliquam vulputate eros et pellentesque. Nunc mattis, elit in congue laoreet, risus urna luctus arcu, at suscipit erat enim eu mi. Sed enim metus, volutpat id ultricies at, ornare eu massa. Sed diam neque, lobortis scelerisque hendrerit vel, placerat non massa.</p>','2013-09-06 00:02:43',0),(5,2,'Demo Entry','<p>Adding a post as a different user -- woop woop!</p>','2013-09-07 22:12:35',0),(6,2,'Demo Formatting','<h1><strong>I can do heading</strong></h1>\r\n<h2><strong>I can do heading #2</strong></h2>\r\n<h3><strong>I can do heading #3</strong></h3>\r\n<p><strong>I can do bold</strong></p>\r\n<p style=\"text-align: right;\"><strong>I can do right-alignment</strong></p>\r\n<p style=\"text-align: center;\"><strong>I can be centerrrreed</strong></p>\r\n<blockquote>\r\n<p style=\"text-align: left;\"><strong>There are three things I hate:</strong></p>\r\n<ol>\r\n<li><strong>Blogs</strong></li>\r\n<li><strong>Lists</strong></li>\r\n<li><strong>Irony</strong></li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n</blockquote>\r\n<p><code><strong>&lt;?php echo \"Look at that, we can do code too!\"; ?&gt;</strong></code></p>','2013-09-08 00:42:19',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `permission_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Overlord','Enables all permissions, Administrator style',1),(3,'User','Regular user. Can update own data',3);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hashword` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'amnesthesia','sintpanda@gmail.com','phjIN5YcE/3uo','Victor','Rudolfsson','2013-09-05 22:02:17'),(2,3,'Demo','demo@demo.com','ph75Afd02NTrw','Changed','Demo','2013-09-07 22:08:55');
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

-- Dump completed on 2013-09-08 23:47:05
