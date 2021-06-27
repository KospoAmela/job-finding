/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.23 : Database - webprogramming
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`webprogramming` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `webprogramming`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_of_category` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name_of_category`) values 
(1,'Turizam'),
(2,'Pravo'),
(3,'Ekonomija'),
(4,'IT'),
(6,'dummy');

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  `role` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT 'COMPANY',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_company_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `companies` */

insert  into `companies`(`id`,`name`,`email`,`phone`,`address`,`password`,`country`,`city`,`status`,`token`,`token_created_at`,`role`) values 
(1,'firma d.o.o.','info@firma.com','033/123-456','Aleja bb','password','bla','grad','PENDING','',NULL,'COMPANY'),
(2,'kafic','kafic@gmail.com','033/111-222','Trg 13','password','blabla','city','PENDING','',NULL,'COMPANY'),
(3,'dummy edit','dummy','dummy','dummy','dummy','blablabla','','PENDING','',NULL,'COMPANY'),
(6,'dummy edit 1','dummy1','dummy','dummy','dummy','dummy','dummy','PENDING','',NULL,'COMPANY'),
(9,'amela','helloleylaaa@gmail.com','060/336-8561','adresa','password','drzava','grad','PENDING','2e0af5be4289691e32e4f1b3a63c377e',NULL,'COMPANY'),
(14,'amela','amela@gmail.com','060/336-8561','adresa','5f4dcc3b5aa765d61d8327deb882cf99','drzava','grad','ACTIVE','9b3bdd03f2391a50967c37ee8582b3bb','2021-06-25 15:32:33','COMPANY'),
(15,'Blabla','blabla@blabla.com','12345678910','blabla','827ccb0eea8a706c4c34a16891f84e7b','bih','sarajevo','ACTIVE','d78be8f9685fcef4afe90e14a4b9f0cc','2021-06-26 21:26:01','COMPANY');

/*Table structure for table `job_applications` */

DROP TABLE IF EXISTS `job_applications`;

CREATE TABLE `job_applications` (
  `application_id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `fk_job_id` (`job_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `job_applications` */

insert  into `job_applications`(`application_id`,`job_id`,`user_id`,`timestamp`) values 
(1,1,51,'2021-06-25 23:07:39'),
(2,7,51,'2021-06-27 12:17:22'),
(3,1,51,'2021-06-27 12:19:50'),
(4,3,51,'2021-06-27 12:20:24');

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `posted_at` timestamp NOT NULL,
  `deadline` timestamp NULL DEFAULT NULL,
  `category_id` int unsigned NOT NULL,
  `type_id` int unsigned NOT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `category_id` (`category_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

insert  into `jobs`(`id`,`company_id`,`title`,`description`,`posted_at`,`deadline`,`category_id`,`type_id`,`country`,`city`) values 
(1,1,'Pripravnik/ca u odjelu za finansije','bla bla','2021-03-13 23:02:32','2021-03-30 00:00:00',3,1,'BiH','blabla'),
(3,2,'Trazi se konobar','opis radnog mjesta','2021-03-19 18:19:08','2021-03-29 23:59:59',2,1,'Croatia','blabla'),
(4,1,'title','bla bla','2021-03-22 17:55:42','2021-03-29 23:59:59',2,1,'Serbia',''),
(5,1,'title','bla bla test test','2021-03-29 23:59:59','2021-03-29 23:59:59',2,1,'drzava','grad'),
(6,1,'title','bla bla','2021-04-06 19:25:15','2021-03-29 23:59:59',2,1,'drzava','grad'),
(7,15,'Naslov','Opis','2021-06-27 12:16:38','2021-06-30 12:16:41',2,2,'BiH','Sarajevo');

/*Table structure for table `types` */

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name_of_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_type_name` (`name_of_type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `types` */

insert  into `types`(`id`,`name_of_type`) values 
(5,'dummy 1'),
(2,'Full-time job'),
(1,'Internship'),
(3,'Part-time job');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `role` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_email` (`email`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`surname`,`email`,`password`,`username`,`status`,`role`,`token`,`token_created_at`) values 
(51,'Amela','Kospo','kospoamela1@gmail.com','827ccb0eea8a706c4c34a16891f84e7b','amelak','ACTIVE','USER','249f09376bf4f3e9b7f6fc3a8abf5092','2021-06-22 11:27:03'),
(52,'Amela','Kospo','amela.kospo@stu.ibu.edu.ba','827ccb0eea8a706c4c34a16891f84e7b','blabla','ACTIVE','USER',NULL,'2021-06-25 10:40:10'),
(54,'Benjamin','Krehic','benjamin.krehic@stu.ibu.edu.ba','827ccb0eea8a706c4c34a16891f84e7b','bendzi','ACTIVE','USER','f8e86fd4474f89ab6424ac8e67861c81','2021-06-25 11:43:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
